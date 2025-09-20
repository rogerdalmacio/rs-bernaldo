<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'project' => $this->project,
            'role' => $this->pivot->role ?? null,
            'start_date' => $this->pivot->start_date ?? null,
            'end_date' => $this->pivot->end_date ?? null,
        ];
    }
}
