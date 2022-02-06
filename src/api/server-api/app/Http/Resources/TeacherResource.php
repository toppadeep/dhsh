<?php

namespace App\Http\Resources;

use App\Models\Cource;
use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $teacher_slug = urldecode( Str::slug($this->name) );
        $teacher_slug = preg_replace('/([^a-z\d\-\_])/', '', $teacher_slug);

        return [
            "id" => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'role' => $this->role,
            'education' => $this->education,
            'avatar' => $this->avatar,
            "files" => json_decode($this->files, true),
            "slug" => $teacher_slug,
        ];
    }
}
