<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
	use HasFactory;
	
	// Tentukan nama tabel (jika tidak sesuai dengan konvensi)
	protected $table = 'students';
	
	// Tentukan kolom yang dapat diisi
	protected $fillable = [
		'nim', 'name', 'major', 'study_program', 'year', 'email', 'status'
	];
	
	// Tentukan kolom yang tidak boleh diubah
	protected $guarded = [];
	
	// Menggunakan UUID sebagai primary key
	protected $keyType = 'string';
	
	public $incrementing = false;
	
	// Menambahkan mutator untuk enkripsi password
	protected $hidden = [
		'password',
	];
	
	// primery key = nim
	protected $primaryKey = 'nim';
	
	// Relasi: Mahasiswa dapat hadir pada banyak workshop
	public function attendances() : HasMany
	{
		return $this->hasMany(Attendance::class, 'student', 'nim');
	}
	
	// Relasi: Mahasiswa mendaftar sebagai user
	public function user() : HasOne
	{
		return $this->hasOne(User::class, 'nim', 'nim');
	}
}
