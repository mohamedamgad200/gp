<?php

namespace Modules\Post\App\resources;


use App\Http\Resources\DoctorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'post_image' => $this->getFirstMediaUrl('post_image'),
            'doctor' => DoctorResource::make($this->whenLoaded('doctor')),
        ];
    }
}
