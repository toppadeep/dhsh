<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Даем разрешение на заполнение полей
    protected $fillable = [
        'id', 'name', 'login', 'password', 'avatar'
    ];

    protected $hidden = [
        'token', 'password', 'name'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
