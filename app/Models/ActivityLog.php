<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'loggable_type', 'loggable_id', 'action', 'description',
    ];
    //whom taken the action
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   //either task or product
    public function loggable()
    {
        return $this->morphTo();
    }

     //use to log from any controller
     public static function record($model, string $action, string $description)
    {
        return self::create([
            'user_id'       => auth()->id(),
            'loggable_type' => get_class($model),
            'loggable_id'   => $model->id,
            'action'        => $action,
            'description'   => $description,
        ]);
    }
}
