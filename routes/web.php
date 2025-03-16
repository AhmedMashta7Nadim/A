<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Route::get('/', function () {
    return Inertia('Home');
});




// Route::get('/Rigestar', function () {
//     return Inertia::render("Rigestar");
// });
// Route::get('/user', [UserController::class, 'GetDataSql']);
