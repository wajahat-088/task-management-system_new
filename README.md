# Task Management Module

A simple Task Management System built with Laravel, featuring authentication, role-based permissions, activity logging, task/category/product CRUD operations built on the Repository Pattern, search & filtering, pagination, and AJAX-based status updates.

**Repository:** https://github.com/wajahat-088/task-manager

## Features

- **Authentication** — Laravel Breeze (login, registration, email verification)
- **Roles & Permissions** — Spatie Laravel Permission package, with role-based access control (Admin, Manager, User)
- **Activity Log** — Every create, update, delete, and status-change action is tracked with who performed it and when
- **Repository Pattern** — All Eloquent queries are abstracted behind repository interfaces, keeping controllers free of direct DB logic
- **Dashboard** — Overview of total, pending, in-progress, and completed tasks and products
- **Task Management** — Create, edit, delete, and list tasks
- **Category & Product Management** — Full CRUD for categories and products, following the same repository pattern as tasks
- **Search & Filters** — Search by title, filter by status and priority
- **Pagination** — Task, category, and product listings are paginated
- **AJAX Status Update** — Update a task's status directly from the listing page without a full page reload
- **Form Request Validation** — Centralized validation logic via `TaskRequest`, `CategoryRequest`, etc.
- **Eloquent Relationships** — `Task belongsTo User` (creator), `Category hasMany Product`, polymorphic `ActivityLog` on Task/Product/Category

## Tech Stack

- Laravel (PHP Framework)
- Laravel Breeze (Authentication)
- Spatie Laravel Permission (Roles & Permissions)
- MySQL (Database)
- Blade Templates
- Tailwind CSS

## Roles & Permissions

Access control is implemented using **Spatie Laravel Permission**, enforced at the route level via middleware on each controller (`can:permission-name`).

### Roles

| Role    | Description                                                          |
| ------- | -------------------------------------------------------------------- |
| Admin   | Full access to all modules (view, create, edit, delete)              |
| Manager | Can view, create, and edit tasks/products/categories — cannot delete |
| User    | Can only view and create tasks/products — read-only on categories    |

### Permissions

| Permission         | Admin | Manager | User |
| ------------------ | :---: | :-----: | :--: |
| view-task          |  ✅   |   ✅    |  ✅  |
| create-task        |  ✅   |   ✅    |  ✅  |
| edit-task          |  ✅   |   ✅    |  ❌  |
| delete-task        |  ✅   |   ❌    |  ❌  |
| view-product       |  ✅   |   ✅    |  ✅  |
| create-product     |  ✅   |   ✅    |  ❌  |
| edit-product       |  ✅   |   ✅    |  ❌  |
| delete-product     |  ✅   |   ❌    |  ❌  |
| view-category      |  ✅   |   ✅    |  ✅  |
| create-category    |  ✅   |   ❌    |  ❌  |
| edit-category      |  ✅   |   ❌    |  ❌  |
| delete-category    |  ✅   |   ❌    |  ❌  |
| view-activity-logs |  ✅   |   ✅    |  ❌  |

Roles and permissions are seeded via `RolePermissionSeeder`, and demo users are assigned roles via `UserSeeder`.

## Activity Log

Every mutation on `Task`, `Product`, and `Category` records is logged in the `activity_logs` table via a shared `ActivityLog::record()` helper, capturing:

- Which user performed the action
- Which model (task/product/category) was affected, via a polymorphic `loggable` relationship
- The action type (`created`, `updated`, `deleted`, `status_changed`)
- A human-readable description of the change

Users with the `view-activity-logs` permission can view a full audit trail from the task listing page.

## Repository Pattern

To keep controllers thin and decouple business logic from the underlying data source, all Eloquent queries have been moved out of the controllers into a dedicated **Repository layer**.

### Why

- Controllers now only depend on interfaces (e.g. `TaskRepositoryInterface`), not concrete Eloquent implementations
- If the data source ever changes (e.g. pulling data from a third-party API instead of the database), only the repository implementation needs to change — controllers, views, and routes remain untouched
- Filtering, sorting, searching, and stats logic is centralized in one place per module instead of being scattered across controllers

### Structure

```
app/
  Repositories/
    Interfaces/
      TaskRepositoryInterface.php
      ProductRepositoryInterface.php
      CategoryRepositoryInterface.php
    Eloquent/
      TaskRepository.php
      ProductRepository.php
      CategoryRepository.php
  Providers/
    RepositoryServiceProvider.php   # binds interfaces to their Eloquent implementations
```

Each repository implements its corresponding interface, and controllers receive the interface via constructor-injected dependency, letting Laravel's service container resolve the correct implementation at runtime.

## Database Structure

### `tasks` table

| Field       | Type                                         |
| ----------- | -------------------------------------------- |
| id          | bigint                                       |
| title       | string                                       |
| description | text (nullable)                              |
| status      | enum (`pending`, `in_progress`, `completed`) |
| priority    | enum (`low`, `medium`, `high`)               |
| due_date    | date                                         |
| created_by  | foreign key → users.id                       |
| created_at  | timestamp                                    |
| updated_at  | timestamp                                    |

### `categories` table

| Field      | Type      |
| ---------- | --------- |
| id         | bigint    |
| name       | string    |
| created_at | timestamp |
| updated_at | timestamp |

### `activity_logs` table

| Field         | Type                                                       |
| ------------- | ---------------------------------------------------------- |
| id            | bigint                                                     |
| user_id       | foreign key → users.id                                     |
| loggable_type | string (polymorphic — Task, Product, or Category)          |
| loggable_id   | bigint (polymorphic)                                       |
| action        | string (`created`, `updated`, `deleted`, `status_changed`) |
| description   | text                                                       |
| created_at    | timestamp                                                  |
| updated_at    | timestamp                                                  |

## Validation Rules

Task creation and updates are validated via `App\Http\Requests\TaskRequest`:

| Field       | Rules                                                     |
| ----------- | --------------------------------------------------------- |
| title       | required, min 3 characters, max 255 characters            |
| description | optional, string                                          |
| status      | required, must be one of: pending, in_progress, completed |
| priority    | required, must be one of: low, medium, high               |
| due_date    | required, valid date, must be today or a future date      |

Category creation and updates are validated via `App\Http\Requests\CategoryRequest`:

| Field | Rules                                          |
| ----- | ---------------------------------------------- |
| name  | required, min 2 characters, max 255 characters |

## Installation Steps

1. **Clone the repository**

    ```bash
    git clone https://github.com/wajahat-088/task-management-system_new.git
    cd task-management-system_new
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install JS dependencies & build assets**

    ```bash
    npm install
    npm run build
    ```

4. **Create environment file**

    ```bash
    cp .env.example .env
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Configure database** in `.env`

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task_manager
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. **Run migrations and seeders**

    ```bash
    php artisan migrate --seed
    ```

    This seeds:
    - Roles & permissions (`RolePermissionSeeder`)
    - Demo users assigned to roles (`UserSeeder`)
    - Sample tasks

8. **Start the development server**

    ```bash
    php artisan serve
    ```

9. **Visit the application**
    ```
    http://localhost:8000
    ```

## Default Seeded Users

| Name       | Email          | Password | Role    |
| ---------- | -------------- | -------- | ------- |
| Admin User | admin@test.com | password | Admin   |
| John Doe   | john@test.com  | password | Manager |
| Jane Smith | jane@test.com  | password | User    |

## Seeded Data

- 3 users (one per role)
- Roles and permissions for Admin, Manager, and User
- 20 sample tasks with varying status, priority, and due dates

## Folder Structure (Key Files)

```
app/
  Http/
    Controllers/
      TaskController.php
      CategoryController.php
      ProductController.php
    Requests/
      TaskRequest.php
      CategoryRequest.php
  Models/
    Task.php
    Category.php
    Product.php
    ActivityLog.php
    User.php
  Repositories/
    Interfaces/
      TaskRepositoryInterface.php
      ProductRepositoryInterface.php
      CategoryRepositoryInterface.php
    Eloquent/
      TaskRepository.php
      ProductRepository.php
      CategoryRepository.php
  Providers/
    RepositoryServiceProvider.php
database/
  migrations/
    xxxx_create_tasks_table.php
    xxxx_create_categories_table.php
    xxxx_create_activity_logs_table.php
  seeders/
    UserSeeder.php
    RolePermissionSeeder.php
    TaskSeeder.php
resources/
  views/
    dashboard.blade.php
    tasks/
      index.blade.php
      create.blade.php
      edit.blade.php
    categories/
      index.blade.php
      create.blade.php
      edit.blade.php
routes/
  web.php
```

## Notes

- Validation is handled via Form Request classes (`TaskRequest`, `CategoryRequest`), keeping validation logic separate from the controller.
- Status updates on the task listing page are handled via AJAX (`PATCH /tasks/{task}/status`) for a smoother user experience.
- Search and filters are implemented using Eloquent query scopes defined on the `Task` model, called from within the repository layer.
- Access control is enforced at the route/method level using Spatie's `can:permission-name` middleware.
- All create/update/delete/status-change actions are automatically logged via `ActivityLog::record()`, called from within each repository.

## Bonus Features Implemented

- ✅ AJAX status update (task status can be changed from the listing page without a page reload)
- ✅ Role-based access control (Admin / Manager / User) via Spatie Laravel Permission
- ✅ Activity logging for full audit trail on Task, Product, and Category changes
- ✅ Repository Pattern for a decoupled, swappable data access layer

## Author

**Wajahat**
GitHub: [@wajahat-088](https://github.com/wajahat-088)
