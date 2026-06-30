<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The user who created this task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to search tasks by title.
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', "%{$term}%");
    }

    /**
     * Scope a query to filter tasks by status.
     */
    public function scopeFilterStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter tasks by priority.
     */
    public function scopeFilterPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    // Task.php, Product.php, aur Category.php — teeno mein yeh add karein

public function activityLogs()
{
    return $this->morphMany(ActivityLog::class, 'loggable');
}
}