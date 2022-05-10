<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title', 'subtitle', 'body', 'cover', 'images', 'documents', 'date', 'viewed', 'slug', 'user_id', 'category_id'
    ];
    protected $cast=[
        'images' => 'array',
        'documents' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
