<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourceTeacher extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'teacher_id', 'cource_id',
    ];
}
