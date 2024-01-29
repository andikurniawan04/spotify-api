<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::middleware('jwt.verify')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/album/{id?}', [AlbumController::class, 'index']);
    Route::get('/artist/{id?}', [ArtistController::class, 'index']);
    Route::get('/song/{id?}', [SongController::class, 'index']);

    Route::post('/me/following/artist', [UserController::class, 'followArtist']);
    Route::delete('/me/following/artist', [UserController::class, 'unfollowArtist']);



    // User
    // Route::resource('album', AlbumController::class);
    // Route::resource('artist', ArtistController::class);



    // Route::prefix('artist')->name('artist.')->group(function () {
    // });

    // Route::get('artist', [ArtistController::class, 'artist']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
