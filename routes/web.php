<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\WeeklyScheduleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {

Route::resource('meetingrooms', MeetingRoomController::class )
->parameters(['meetingrooms'=>'meetingroom:slug']);

});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {

    Route::resource('events', EventController::class )
    ->parameters(['events'=>'event:slug']);

    });

    Route::middleware('auth')->group(function () {
        Route::post('/filter', [FilterController::class, 'filter'])->name('filter');
      //  Route::get('/filter',[FilterController::class,''])->name('event.create');
      Route::get('/filter', function () {
        return Inertia::location(route('dashboard.events.create'));
      });


    });


    Route::middleware('auth')->prefix('dashboard')->group(function () {
        Route::get('/weeklyview', [WeeklyScheduleController::class, 'index'])->name('weeklyview');
        Route::post('/weeklyview', [WeeklyScheduleController::class, 'handlePost'])->name('weeklyview');
    });

require __DIR__.'/auth.php';
