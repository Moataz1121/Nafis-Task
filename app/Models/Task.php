<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model 
{
    //
    use HasFactory , HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
