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
        'title', 'body', 'cover', 'images', 'documents', 'payment',
    ];
    protected $cast=[
        'images' => 'array',
        'documents' => 'array'
    ];
    public function teachers()
    {
        return $this->belongsToMany(CourceTeacher::class);
    }


}
