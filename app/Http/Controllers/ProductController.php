<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Http\Requests\ProductRequest;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['creator', 'category']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->filterStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->filterPriority($request->priority);
        }

        if ($request->filled('category')) {
            $query->filterCategory($request->category);
        }

        $sortColumn = in_array($request->sort, ['title', 'priority', 'status', 'due_date', 'created_at'])
            ? $request->sort
            : 'created_at';

        $sortDirection = $request->direction === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortColumn, $sortDirection);

        $products = $query->paginate(10)->withQueryString();

        // Dropdown ke liye saari categories bhej rahe hain
        $categories = Category::all();

        return view('products.index', compact('products', 'categories', 'sortColumn', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
       $product= Product::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        //create an activity log entry for the newly created product
        ActivityLog::record($product, 'created', "created product '{$product->title}'");

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
      //create an activity log entry for the updated product
        ActivityLog::record($product, 'updated', "updated product '{$product->title}'");

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Product $product)
    {
        $product->delete();

        //create an activity log entry for the deleted product
        ActivityLog::record($product, 'deleted', "deleted product '{$product->title}'");

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
    public function updateStatus(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $oldStatus = $product->status; //track old status for activity log


        $product->update(['status' => $validated['status']]);
        // Activity log entry
        ActivityLog::record($product, 'status_changed',
            "changed status of product '{$product->title}' from {$oldStatus} to {$product->status}");

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully!',
            'status'  => $product->status,
        ]);
    }
}
