<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
	// Menampilkan daftar absensi
	public function index()
	{
		$attendances = Attendance::all();
		return AttendanceResource::collection($attendances);
	}
	
	// Menampilkan detail absensi berdasarkan ID
	public function show($id)
	{
		$attendance = Attendance::findOrFail($id);
		return new AttendanceResource($attendance);
	}
	
	// Menambah absensi baru
	public function store(Request $request)
	{
		$validated = $request->validate([
			'student' => 'required|exists:students,nim',
			'workshop_id' => 'required|exists:workshops,workshop_id',
			'check_in_time' => 'required|date',
			'check_out_time' => 'nullable|date',
		]);
		
		$attendance = Attendance::create($validated);
		return new AttendanceResource($attendance);
	}
	
	// Mengupdate absensi berdasarkan ID
	public function update(Request $request, $id)
	{
		$validated = $request->validate([
			'student' => 'required|exists:students,id',
			'workshop_id' => 'required|exists:workshops,workshop_id',
			'check_in_time' => 'required|date',
			'check_out_time' => 'nullable|date',
		]);
		
		$attendance = Attendance::findOrFail($id);
		$attendance->update($validated);
		
		return new AttendanceResource($attendance);
	}
	
	// Menghapus absensi berdasarkan ID
	public function destroy($id)
	{
		$attendance = Attendance::findOrFail($id);
		$attendance->delete();
		
		return response()->json(['message' => 'Attendance deleted successfully']);
	}
	
	// Absensi Check-in
	public function checkIn(Request $request)
	{
		$validated = $request->validate([
			'student' => 'required|exists:students,nim',
			'workshop_id' => 'required|exists:workshops,workshop_id',
		]);
		
		// Ambil data workshop berdasarkan workshop_id
		$workshop = Workshop::where('workshop_id', $validated['workshop_id'])->first();
		
		if (!$workshop) {
			return response()->json(['message' => 'Workshop not found'], 404);
		}
		
		// Validasi apakah waktu saat ini berada dalam jadwal workshop
		$now = Carbon::now();
		if ($now->lt($workshop->start_time) || $now->gt($workshop->end_time)) {
			return response()->json(['message' => 'Check-in is not allowed outside workshop schedule'], 400);
		}
		
		// Cek apakah peserta sudah check-in di workshop yang sama
		$existingAttendance = Attendance::where('student', $validated['student'])
			->where('workshop_id', $validated['workshop_id'])
			->whereNull('check_out_time') // Pastikan belum check-out
			->first();
		
		if ($existingAttendance) {
			return response()->json(['message' => 'Already checked in'], 400);
		}
		
		// Buat entri absensi
		$attendance = Attendance::create([
			'student' => $validated['student'],
			'workshop_id' => $validated['workshop_id'],
			'check_in_time' => $now,
			'check_out_time' => null,
		]);
		
		return new AttendanceResource($attendance);
	}
	
	
	public function checkOut(Request $request)
	{
		// Validasi input
		$validated = $request->validate([
			'student' => 'required|exists:students,nim',
			'workshop_id' => 'required|exists:workshops,workshop_id',
		]);
		
		// Cari attendance_id berdasarkan workshop_id dan student
		$attendance = Attendance::where('workshop_id', $validated['workshop_id'])
			->where('student', $validated['student'])
			->whereNull('check_out_time') // Pastikan belum check-out
			->first();
		
		
		
		if (!$attendance) {
			return response()->json(['message' => 'Attendance not found or already checked out'], 404);
		}

		// Ambil data workshop terkait menggunakan workshop_id
		$workshop = Workshop::where('workshop_id', $attendance->workshop_id)->first();

		if (!$workshop) {
			return response()->json(['message' => 'Workshop not found'], 404);
		}

		// Validasi apakah peserta sudah check-in
		if (!$attendance->check_in_time) {
			return response()->json(['message' => 'Check-in time is missing'], 400);
		}

		// Validasi apakah peserta sudah check-out sebelumnya
		if ($attendance->check_out_time) {
			return response()->json(['message' => 'Already checked out'], 400);
		}

		// Validasi apakah waktu saat ini masih dalam jadwal workshop
		$now = Carbon::now();
		if ($now->gt($workshop->end_time)) {
			return response()->json(['message' => 'Check-out is not allowed after workshop has ended'], 400);
		}
		
		

		// Update waktu check-out
		$attendance->update([
			'check_out_time' => now(),
			'updated_at' => now()
		]);
		
		return $attendance;
	}
	
	
}
