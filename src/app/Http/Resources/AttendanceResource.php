<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
	public function toArray($request): array
	{
		return [
			'attendance_id' => $this->attendance_id,
			'student' => $this->student,
			'workshop_id' => $this->workshop_id,
			'check_in_time' => $this->check_in_time,
			'check_out_time' => $this->check_out_time,
			'status' => $this->status,
		];
	}
}
