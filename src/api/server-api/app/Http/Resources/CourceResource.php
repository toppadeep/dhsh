<?php

namespace App\Http\Resources;

use App\Models\CourceTeacher;
use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            "id" => $this->id,
            "title" => $this->title,
            "body" => $this->body,
            "image" => $this->image,
            "payment" => $this->payment,
            "teachers" => CourceTeacher::find($this->teacher_id),
        ];
    }
}
