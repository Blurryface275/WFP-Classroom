<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index2');
});

Route::get('/contoh/{id}/nama/{nama}', function ($id, $nama) {
    return "Parameter dengan id : " . $id . ", Nama : " . $nama;
})->name("contoh");

Route::view('/welcome', "Selamat Datang di Portal Kesehatan.");

Route::get('/menu', function () {
    return "Pilih Konsultasi Online atau Buat Janji Temu";
})->name("menu");

Route::get('/menu/{jenis}', function ($jenis) {
    $layanan = [
        'konsultasi' => "Daftar Layanan Konsultasi Online",
        'janji' => "Daftar Layanan Janji Temu Dokter",
    ];
    return $layanan[$jenis] ?? "Layanan tidak ada";
});

Route::get('/admin/{administrasi?}', function ($administrasi = "home") {
    $admin = [
        'categories' => "Portal Manajemen: Daftar Kategori Layanan",
        'order' => "Portal Manajemen: Daftar Konsultasi dan Janji Temu",
        'members' => "Portal Manajemen: Daftar Pasien",
        'home' => "Silahkan pilih menu administrasi"

    ];
    return $admin[$administrasi] ?? $admin['home'];
});

Route::get('greetings', function () {
    return view('welcome', ['name' => "Edward"]);
})->name("greetings");

Route::resource('services', App\Http\Controllers\ServiceController::class);
Route::resource('category', App\Http\Controllers\CategoryController::class);
Route::resource('doctor', App\Http\Controllers\DoctorController::class);
Route::resource('transaction', App\Http\Controllers\TransactionController::class);
Route::resource('article', App\Http\Controllers\ArticleController::class);

Route::get('/category/showExpensiveServices/{id}', [App\Http\Controllers\CategoryController::class, 'showExpensiveServices'])->name('category.showExpensiveServices');
Route::post("/category/showInfo", [CategoryController::class, 'showInfo'])->name("category.showInfo");
