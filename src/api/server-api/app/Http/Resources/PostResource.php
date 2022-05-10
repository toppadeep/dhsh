<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
        /*$user = User::where('token', $request->bearerToken())->first();
        dd($user);
        if ($user->posts()->wherePivot('post_id', $this->id)->exists()) {
            $statusBookmark = true;
        }else {
            $statusBookmark = false;
        }*/

        return [
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "body" => $this->body,
            "cover" => $this->cover,
            "images" => json_decode($this->images, true),
            "documents" => json_decode($this->documents, true),
            "date" => $this->date,
            "userName" => User::find($this->user_id)->name,
            "userLogin" => User::find($this->user_id)->login,
            "userAvatar" => User::find($this->user_id)->avatar,
            "image" => User::find($this->user_id)->avatar,
            "viewed" => $this->viewed,
            "slug" => $this->slug,
            "category_id" => Category::find($this->category_id)->id,
            "category" => Category::find($this->category_id)->name,
        ];
    }
}


