<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $defaultImage = asset('Default/profile.jpeg');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birth' => $this->birth,
            'profile_image' => $this->getFirstMediaUrl('doctor_profile_image')?:$defaultImage,
            'roles' => $this->roles->pluck('name') ?? [],
            'roles.permissions' => $this->getPermissionsViaRoles()->pluck(['name']) ?? [],
        ];
    }
}
