<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
	public function toArray($request): array
	{
		return [
			'nim' => $this->nim,
			'name' => $this->name,
			'major' => $this->major,
			'study_program' => $this->study_program,
			'year' => $this->year,
			'email' => $this->email,
			'status' => $this->status,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}
