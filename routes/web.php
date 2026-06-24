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
})->middleware('auth'); // -> kalau tidak ada username yang tersimpan (udah logout), maka akan diarahkan ke halaman login

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

Route::middleware(["auth"])->group(function () {
    Route::resource('services', App\Http\Controllers\ServiceController::class);
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('doctor', App\Http\Controllers\DoctorController::class);
    Route::resource('transaction', App\Http\Controllers\TransactionController::class);
    Route::resource('article', App\Http\Controllers\ArticleController::class);
});

Route::get('/category/showExpensiveServices/{id}', [App\Http\Controllers\CategoryController::class, 'showExpensiveServices'])->name('category.showExpensiveServices');
Route::post("/category/showInfo", [CategoryController::class, 'showInfo'])->name("category.showInfo");
Route::post('/ajax/category/getEditForm', [CategoryController::class, 'getEditForm'])->name('category.getEditForm');

Route::post('/ajax/services/getEditFormB', [ServiceController::class, 'getEditFormB'])->name('services.getEditFormB');
Route::post('/ajax/services/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])->name('services.saveDataUpdate');
Route::post('/ajax/services/deleteData', [ServiceController::class, 'deleteData'])->name('services.deleteData');

Route::post('/ajax/transactions/getEditFormB', [App\Http\Controllers\TransactionController::class, 'getEditFormB'])->name('transactions.getEditFormB');
Route::post('/ajax/transactions/saveDataUpdate', [App\Http\Controllers\TransactionController::class, 'saveDataUpdate'])->name('transactions.saveDataUpdate');
Route::post('/ajax/transactions/deleteData', [App\Http\Controllers\TransactionController::class, 'deleteData'])->name('transactions.deleteData');

Route::post('/ajax/doctors/getEditFormB', [App\Http\Controllers\DoctorController::class, 'getEditFormB'])->name('doctors.getEditFormB');
Route::post('/ajax/doctors/saveDataUpdate', [App\Http\Controllers\DoctorController::class, 'saveDataUpdate'])->name('doctors.saveDataUpdate');
Route::post('/ajax/doctors/deleteData', [App\Http\Controllers\DoctorController::class, 'deleteData'])->name('doctors.deleteData');

Route::post('/ajax/articles/getEditFormB', [App\Http\Controllers\ArticleController::class, 'getEditFormB'])->name('articles.getEditFormB');
Route::post('/ajax/articles/saveDataUpdate', [App\Http\Controllers\ArticleController::class, 'saveDataUpdate'])->name('articles.saveDataUpdate');
Route::post('/ajax/articles/deleteData', [App\Http\Controllers\ArticleController::class, 'deleteData'])->name('articles.deleteData');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
