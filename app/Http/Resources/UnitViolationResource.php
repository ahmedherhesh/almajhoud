<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitViolationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'user' => $this->user->name,
            // 'unit' => $this->unit->title,
            'violation' => $this->violation->title ?? '',
            'count' => $this->count,
            'cant_edit' => $this->cant_edit_at ? $this->cant_edit_at <= Carbon::now() : null,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
