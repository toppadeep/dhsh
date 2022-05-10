<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $user = User::find($this->id);
        $posts = $user->posts()->get();

        return [
            "id" => $this->id,
            "name" => $this->name,
            "login" => $this->login,
            "favorites" => $posts,
            "avatar" => $this->avatar,
            "status" => $this->status,
            "token" => $this->token
        ];
    }
}
