<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $post_slug = urldecode( Str::slug($this->title) );
        $post_slug = preg_replace('/([^a-z\d\-\_])/', '', $post_slug);


        return [
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "body" => $this->body,
            "cover" => $this->cover,
            "files" => json_decode($this->files, true),
            "date" => $this->date,
            "userName" => User::find($this->user_id)->name,
            "userLogin" => User::find($this->user_id)->login,
            "image" => User::find($this->user_id)->avatar,
            "viewed" => $this->viewed,
            "slug" => $post_slug,
            "category" => Category::find($this->category_id)->name,
        ];
    }
}


