<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
	use HasFactory;
	
	// Tentukan nama tabel
	protected $table = 'attendance';
	
	protected $primaryKey = 'attendance_id';
	
	// Tentukan kolom yang dapat diisi
	protected $fillable = [
		'student', 'workshop_id', 'check_in_time', 'check_out_time'
	];
	
	// Relasi: Attendance terkait dengan satu mahasiswa (student)
	public function student()
	{
		return $this->belongsTo(Student::class, 'student', 'nim');
	}
	
	// Relasi: Attendance terkait dengan satu workshop
	public function workshop()
	{
		return $this->belongsTo(Workshop::class, 'workshop_id');
	}
}
