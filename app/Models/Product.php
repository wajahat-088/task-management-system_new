<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'priority',
        'due_date', 'category_id', 'created_by',
    ];

    // Relationships 
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Query Scopes
    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', "%{$term}%");
    }

    public function scopeFilterStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFilterPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    // query scope - for category filter
    public function scopeFilterCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Task.php, Product.php, aur Category.php — teeno mein yeh add karein

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }
}
