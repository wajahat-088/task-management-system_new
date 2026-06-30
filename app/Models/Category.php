<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // Ek category ke multiple products ho sakte hain
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // Task.php, Product.php, aur Category.php — teeno mein yeh add karein

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }
}
