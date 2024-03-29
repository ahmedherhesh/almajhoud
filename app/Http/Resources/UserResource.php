<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'status' => $this->status,
            'role'   => $this->getRoleNames()[0] ?? "",
            'permissions'  => $this->getPermissionNames(),
            'unit'   => $this->unit->myUnit ?? ($this->hasRole('admin') ? ['title' => 'أدمن'] : ['title' => 'لا يملك وحدات'])
        ];

        if ($this->showToken)
            $data['token'] = $this->createToken($this->email)->plainTextToken;
        return $data;
    }
}
