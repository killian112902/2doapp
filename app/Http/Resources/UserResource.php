<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $avatar = $this->profile_photo_path
            ? Storage::disk('public')->url($this->profile_photo_path)
            : 'https://api.dicebear.com/7.x/identicon/svg?seed='.urlencode($this->email);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_url' => $avatar,
        ];
    }
}
