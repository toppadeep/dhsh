<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'role', 'education', 'images', 'documents', 'avatar'
    ];

    protected $cast=[
        'images' => 'array',
        'documents' => 'array'
    ];

    public function cources()
    {
        return $this->belongsToMany(CourceTeacher::class);
    }
}
