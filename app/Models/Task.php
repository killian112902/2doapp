<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Allow mass assignment for core task fields including the new details column
    protected $fillable = ['title', 'details', 'is_done', 'user_id', 'deadline'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
