<?php

namespace App\Http\Resources;

use App\Models\CourceTeacher;
use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $course_slug = urldecode( Str::slug($this->title) );
        $course_slug = preg_replace('/([^a-z\d\-\_])/', '', $course_slug);

        return [
            "id" => $this->id,
            "title" => $this->title,
            "body" => $this->body,
            "cover" => $this->cover,
            "images" => json_decode($this->images, true),
            "documents" => json_decode($this->documents, true),
            "payment" => $this->payment,
            "slug" => $course_slug,
        ];
    }
}
