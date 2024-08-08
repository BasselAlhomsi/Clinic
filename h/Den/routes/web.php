<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\DatesController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\SpecializationsController;

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
    return view('welcome');
});


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->group(function () {

    Route::prefix('doctors')->group(function () {
        Route::get('/create', [App\Http\Controllers\DoctorsController::class, 'create'])->name('doctors.create');
        Route::post('/show', [App\Http\Controllers\DoctorsController::class, 'store'])->name('doctors.store');
        Route::get('/show', [App\Http\Controllers\DoctorsController::class, 'index'])->name('doctors.index');
        Route::get('/edit/{id}', [App\Http\Controllers\DoctorsController::class, 'edit'])->name('doctors.edit');
        Route::post('/update/{id}', [App\Http\Controllers\DoctorsController::class, 'update'])->name('doctors.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\DoctorsController::class, 'destroy'])->name('doctors.delete');


    });

    Route::prefix('specailzations')->group(function () {
        Route::get('/create', [App\Http\Controllers\SpecializationsController::class, 'create'])->name('specializations.create');
        Route::post('/show', [App\Http\Controllers\SpecializationsController::class, 'store'])->name('specializations.store');
        Route::get('/show', [App\Http\Controllers\SpecializationsController::class, 'index'])->name('specializations.index');
        Route::get('/edit/{id}', [App\Http\Controllers\SpecializationsController::class, 'edit'])->name('specializations.edit');
        Route::post('/update/{id}', [App\Http\Controllers\SpecializationsController::class, 'update'])->name('specializations.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\SpecializationsController::class, 'destroy'])->name('specializations.delete');



    });

    Route::prefix('status')->group(function () {
        Route::get('/create', [App\Http\Controllers\StatusesController::class, 'create'])->name('status.create');
        Route::post('/show', [App\Http\Controllers\StatusesController::class, 'store'])->name('status.store');
        Route::get('/show', [App\Http\Controllers\StatusesController::class, 'index'])->name('status.index');
        Route::get('/edit/{id}', [App\Http\Controllers\StatusesController::class, 'edit'])->name('status.edit');
        Route::post('/update/{id}', [App\Http\Controllers\StatusesController::class, 'update'])->name('status.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\StatusesController::class, 'destroy'])->name('status.delete');


    });
  
    Route::prefix('patients')->group(function () {
        Route::get('/create', [App\Http\Controllers\PatientsController::class, 'create'])->name('patients.create');
        Route::post('/show', [App\Http\Controllers\PatientsController::class, 'store'])->name('patients.store');
        Route::get('/show', [App\Http\Controllers\PatientsController::class, 'index'])->name('patients.index');
        Route::get('/edit/{id}', [App\Http\Controllers\PatientsController::class, 'edit'])->name('patients.edit');
        Route::post('/update/{id}', [App\Http\Controllers\PatientsController::class, 'update'])->name('patients.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\PatientsController::class, 'destroy'])->name('patients.delete');


    });
    Route::prefix('dates')->group(function () {
        Route::get('/create', [App\Http\Controllers\DatesController::class, 'create'])->name('dates.create');
        Route::post('/show', [App\Http\Controllers\DatesController::class, 'store'])->name('dates.store');
        Route::get('/show', [App\Http\Controllers\DatesController::class, 'index'])->name('dates.index');
        Route::get('/edit/{id}', [App\Http\Controllers\DatesController::class, 'edit'])->name('dates.edit');
        Route::post('/update/{id}', [App\Http\Controllers\DatesController::class, 'update'])->name('dates.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\DatesController::class, 'destroy'])->name('dates.delete');


    });

    Route::prefix('ratings')->group(function () {
        Route::get('/create', [App\Http\Controllers\RatingsController::class, 'create'])->name('ratings.create');
        Route::post('/show', [App\Http\Controllers\RatingsController::class, 'store'])->name('ratings.store');
        Route::get('/show', [App\Http\Controllers\RatingsController::class, 'index'])->name('ratings.index');
        Route::get('/edit/{id}', [App\Http\Controllers\RatingsController::class, 'edit'])->name('ratings.edit');
        Route::post('/update/{id}', [App\Http\Controllers\RatingsController::class, 'update'])->name('ratings.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\RatingsController::class, 'destroy'])->name('ratings.delete');


    });

});
