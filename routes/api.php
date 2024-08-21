<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/data_karyawan/sisa-cuti', [KaryawanController::class, 'sisaCuti']);
    Route::get('/data_karyawan/dengan-cuti', [KaryawanController::class, 'getKaryawanWithCuti']);
    Route::get('/data_karyawan/tiga-pertama', [KaryawanController::class, 'getFirstThreeKaryawan']);
    Route::apiResource('data_karyawan', KaryawanController::class);
 });
