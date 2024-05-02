<?php
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/login', 'App\Http\Controllers\AuthController@showLoginForm')->name('login');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/view-face-image/{userId}', function ($userId) {
    $imagePath = storage_path('facces') . '/' . $userId . '.png';

    // Verifica si el archivo existe
    if (File::exists($imagePath)) {
        // Devuelve la imagen al navegador
        return response()->file($imagePath);
    } else {
        // Si el archivo no existe, devuelve una respuesta 404
        abort(404);
    }
})->name('view.face.image');