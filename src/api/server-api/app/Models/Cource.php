<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Cource extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title', 'body', 'image', 'payment',
    ];

    public function teachers()
    {
        return $this->hasMany(CourceTeacher::class);
    }


}
