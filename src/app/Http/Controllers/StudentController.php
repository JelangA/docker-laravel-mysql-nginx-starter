<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
	// Menampilkan daftar mahasiswa
	public function index()
	{
		$students = Student::all();
		return StudentResource::collection($students);
		
	}
	
	// Menampilkan detail mahasiswa berdasarkan ID
	public function show($nim)
	{
		$student = Student::findOrFail($nim);
		return new StudentResource($student);
	}
	
	public function search(Request $request)
	{
		$validated = $request->validate([
			'nim' => 'required|string|max:9',
		]);
		
		$query = $validated['nim'];
		
		$students = Student::where('nim', 'like', '%' . $query . '%')->take(10)->get();
		
		Log::alert('Query Results: ' . $students->toJson());
		
		if ($students->isEmpty()) {
			return response()->json([
				'message' => 'No students found for the provided query.'
			], 404);
		}
		
		return StudentResource::collection($students);
	}
	
	
	
	// Menambah data mahasiswa baru
	public function store(Request $request)
	{
		$validated = $request->validate([
			'nim' => 'required|unique:students,nim|max:9',
			'name' => 'required|max:100',
			'major' => 'required|max:100',
			'study_program' => 'required|max:150',
			'year' => 'required|max:4',
			'email' => 'required|email|unique:students,email',
			'status' => 'required|in:active,inactive',
		]);
		
		$student = Student::create($validated);
		return new StudentResource($student);
	}
	
	// Mengupdate data mahasiswa berdasarkan ID
	public function update(Request $request, $nim)
	{
		$validated = $request->validate([
			'nim' => 'required|max:9',
			'name' => 'required|max:100',
			'major' => 'required|max:100',
			'study_program' => 'required|max:150',
			'year' => 'required|max:4',
			'email' => 'required|email',
			'status' => 'required|in:active,inactive',
		]);
		
		$student = Student::findOrFail($nim);
		$student->update($validated);
		
		return new StudentResource($student);
	}
	
	// Menghapus data mahasiswa berdasarkan ID
	public function destroy($nim)
	{
		$student = Student::findOrFail($nim);
		$student->delete();
		
		return response()->json(['message' => 'Student deleted successfully']);
	}
}
