# Task Management Module

A simple Task Management System built with Laravel, featuring authentication, task CRUD operations, search & filtering, pagination, and AJAX-based status updates.

**Repository:** https://github.com/wajahat-088/task-manager

## Features

- **Authentication** — Laravel Breeze (login, registration, email verification)
- **Dashboard** — Overview of total, pending, in-progress, and completed tasks
- **Task Management** — Create, edit, delete, and list tasks
- **Search & Filters** — Search by title, filter by status and priority
- **Pagination** — Task listing is paginated
- **AJAX Status Update** — Update a task's status directly from the listing page without a full page reload
- **Form Request Validation** — Centralized validation logic via `TaskRequest`
- **Eloquent Relationships** — `Task belongsTo User` (creator)

## Tech Stack

- Laravel (PHP Framework)
- Laravel Breeze (Authentication)
- MySQL (Database)
- Blade Templates
- Tailwind CSS

## Database Structure

### `tasks` table

| Field        | Type                                          |
|--------------|------------------------------------------------|
| id           | bigint                                          |
| title        | string                                          |
| description  | text (nullable)                                 |
| status       | enum (`pending`, `in_progress`, `completed`)    |
| priority     | enum (`low`, `medium`, `high`)                  |
| due_date     | date                                             |
| created_by   | foreign key → users.id                          |
| created_at   | timestamp                                       |
| updated_at   | timestamp                                       |

## Validation Rules

Task creation and updates are validated via `App\Http\Requests\TaskRequest`:

| Field        | Rules                                              |
|--------------|------------------------------------------------------|
| title        | required, min 3 characters, max 255 characters       |
| description  | optional, string                                      |
| status       | required, must be one of: pending, in_progress, completed |
| priority     | required, must be one of: low, medium, high           |
| due_date     | required, valid date, must be today or a future date  |

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

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Visit the application**
   ```
   http://localhost:8000
   ```

## Default Seeded Users

| Name         | Email            | Password   |
|--------------|------------------|------------|
| Admin User   | admin@test.com   | password   |
| John Doe     | john@test.com    | password   |
| Jane Smith   | jane@test.com    | password   |

## Seeded Data

- 3 users
- 20 sample tasks with varying status, priority, and due dates

## Folder Structure (Key Files)

```
app/
  Http/
    Controllers/
      TaskController.php
    Requests/
      TaskRequest.php
  Models/
    Task.php
    User.php
database/
  migrations/
    xxxx_create_tasks_table.php
  seeders/
    UserSeeder.php
    TaskSeeder.php
resources/
  views/
    dashboard.blade.php
    tasks/
      index.blade.php
      create.blade.php
      edit.blade.php
routes/
  web.php
```

## Notes

- Validation is handled via `TaskRequest` (Form Request class), keeping validation logic separate from the controller.
- Status updates on the task listing page are handled via AJAX (`PATCH /tasks/{task}/status`) for a smoother user experience.
- Search and filters are implemented using Eloquent query scopes defined on the `Task` model.

## Bonus Features Implemented

- ✅ AJAX status update (task status can be changed from the listing page without a page reload)

## Author

**Wajahat**
GitHub: [@wajahat-088](https://github.com/wajahat-088)

