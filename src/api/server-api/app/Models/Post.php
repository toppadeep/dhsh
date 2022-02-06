<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title', 'subtitle', 'body', 'cover', 'files', 'date', 'viewed', 'user_id', 'category_id'
    ];
    protected $cast=[
        'files' => 'array'
    ];
}
