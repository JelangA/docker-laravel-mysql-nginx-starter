<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
	use HasFactory;
	
	// Tentukan nama tabel (jika tidak sesuai dengan konvensi)
	protected $table = 'workshops';
	
	// Tentukan kolom yang dapat diisi
	protected $fillable = [
		'title', 'description', 'start_time', 'end_time', 'location'
	];
	
	// Relasi: Workshop memiliki banyak QR Code
	public function qrCodes()
	{
		return $this->hasMany(QrCode::class, 'workshop_id');
	}
	
	// Relasi: Workshop memiliki banyak absensi
	public function attendances()
	{
		return $this->hasMany(Attendance::class, 'workshop_id');
	}
}
