<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'role', 'education', 'files', 'avatar'
    ];

    protected $cast=[
        'files' => 'array'
    ];

    public function cources()
    {
        return $this->belongsToMany(CourceTeacher::class, 'cource_id');
    }
}
