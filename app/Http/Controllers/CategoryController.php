<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository)
    {
    }

    /**
     * Route-level permission checks.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('can:view-category',   only: ['index']),
            new Middleware('can:create-category', only: ['create', 'store']),
            new Middleware('can:edit-category',   only: ['edit', 'update']),
            new Middleware('can:delete-category', only: ['destroy']),
        ];
    }

    /**
     * Display a paginated listing of categories with their products count.
     */
    public function index()
    {
        $categories = $this->categoryRepository->getPaginated();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($category, $request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category);

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}