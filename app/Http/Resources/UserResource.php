<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        try{
            $posts = $this->whenLoaded('posts', function () {
                return [
                    'id' => $this->post->id,
                    'title' => $this->post->id,
                ];
            });
        }catch(Throwable $e){
            return $e->getMessage();
        }
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'is_admin'=> $this->is_admin, //* "0->user,1->admin"
            'is_ban'=> $this->is_ban, //* "0->is not ban,1->is ban"
            'activation_status'=> $this->activation_status, //* "0->is not active,1->is active"
            'email'=> $this->email,
            'phone_number'=> $this->phone_number,
            'posts' => $posts,
            'like_counts' =>$this->whenCounted('postUserLikes'),
        ];
    }
}
