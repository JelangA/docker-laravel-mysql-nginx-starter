<?php
	
	use App\Http\Controllers\AttendanceController;
	use App\Http\Controllers\authController;
	use App\Http\Controllers\StudentController;
	use App\Http\Controllers\WorkshopController;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	
	Route::prefix('auth')->group(function () {
		Route::post('/login', [authController::class, 'login']);
		Route::post('/register', [authController::class, 'register']);
	});
	
	Route::prefix('profile')->group(function () {
		Route::get('/', [authController::class, 'profile'])->middleware('auth:sanctum');
		Route::post('/logout', [authController::class, 'logout'])->middleware('auth:sanctum');
	});
	
	Route::prefix('students')->group(function () {
		Route::get('/', [StudentController::class, 'index']);
		Route::get('/search', [StudentController::class, 'search']);
		Route::get('/{nim}', [StudentController::class, 'show']);
		
		// belum diubah untuk admin
		Route::post('/', [StudentController::class, 'store'])->middleware('auth:sanctum');
		Route::put('/{nim}', [StudentController::class, 'update'])->middleware('auth:sanctum');
		Route::delete('/{nim}', [StudentController::class, 'destroy'])->middleware('auth:sanctum');
	});
	
	Route::prefix('attendance')->group(function () {
		Route::post('check-in', [AttendanceController::class, 'checkIn'])->middleware('auth:sanctum');
		Route::post('check-out', [AttendanceController::class, 'checkOut'])->middleware('auth:sanctum');
		
		// belum diubah untuk admin
		Route::get('/', [AttendanceController::class, 'index']);
		Route::get('/{id}', [AttendanceController::class, 'show']);
		Route::post('/', [AttendanceController::class, 'store'])->middleware('auth:sanctum');
		Route::put('/{id}', [AttendanceController::class, 'update'])->middleware('auth:sanctum');
		Route::delete('/{id}', [AttendanceController::class, 'destroy'])->middleware('auth:sanctum');
		
	});
	
	Route::prefix('workshops')->group(function () {
		// belum diubah untuk admin
		Route::get('/', [WorkshopController::class, 'index']);
		Route::get('/{workshop_id}', [WorkshopController::class, 'show']);
		Route::post('/', [WorkshopController::class, 'store'])->middleware('auth:sanctum');
		Route::put('/{workshop_id}', [WorkshopController::class, 'update'])->middleware('auth:sanctum');
		Route::delete('/{workshop_id}', [WorkshopController::class, 'destroy'])->middleware('auth:sanctum');
	});



