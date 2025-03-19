<?php

use App\Http\Controllers\CommintController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login',[UserController::class,"login"]);
Route::post("/register", [UserController::class, "register"]);




// Route::prefix('user')->group(function () {
//     Route::get('/getUsers', [UserController::class, 'getUsers']);
//     Route::post("/AddUser", [UserController::class, "AddUser"]);
//     Route::get('/getByIdUser/{id}', [UserController::class, 'getByIdUser']);
//     Route::patch('/updateUser/{id}', [UserController::class, 'updateUser']);
//     Route::delete('/SoftDeleted/{id}', [UserController::class, "SoftDeleted"]);
// });

Route::prefix("userSql")->group(function(){
   Route::get("/GetDataSql",[UserController::class,"GetDataSql"]);
   Route::get("/getUserAndPost",[UserController::class,"getUserAndPost"]);
   Route::get("/GetIdSql/{id}",[UserController::class,"GetIdSql"]);
   Route::get("/getUserName/{id}", [UserController::class, "getUserName"]);
   Route::post("/AddUserSql",[UserController::class,"AddUserSql"]);

});


//->middleware("auth:sanctum")
Route::prefix("PostSql")->group(function () {
    Route::get("/getPosts", [PostController::class, "getPosts"]);
    Route::get("/getByIdPost/{id}", [PostController::class, "getByIdPost"]);
    // Route::get("/getNameUser/{id}", [PostController::class, "getNameUser"]);
    Route::post("/AddPostSql", [PostController::class, "AddPostSql"]);
    Route::put("/UpdatePostSql/{id}", [PostController::class, "UpdatePostSql"]);
    Route::delete("/SoftDeletedPost/{id}", [PostController::class, "SoftDeletedPost"]);
});

Route::prefix("CommintSql")->group(function () {
    Route::get("/getCommint",[CommintController::class,"getCommint"]);
    Route::get("/getCommintsinUser/{id}",[CommintController::class,"getCommintsinUser"]);
    Route::post("/AddCommint",[CommintController::class,"AddCommint"]);
});