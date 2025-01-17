<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
	public function toArray($request): array
	{
		return [
			'workshop_id' => $this->workshop_id,
			'title' => $this->title,
			'description' => $this->description,
			'start_time' => $this->start_time,
			'end_time' => $this->end_time,
			'location' => $this->location,
			'created_at' => $this->created_at,
		];
	}
}
