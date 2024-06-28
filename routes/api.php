<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserImageController;
use Illuminate\Support\Facades\Route;


Route::middleware("auth:sanctum")->group(function () {
    Route::put("/template", [Controller::class, "template"]); //pronto
    Route::put("/profile", [Controller::class, "profile"]); //pronto
    Route::get("/profile", [Controller::class, "getProfile"]); //pronto
});

Route::middleware("auth:sanctum", "admin")->group(function () {
    Route::get("/users", [Controller::class, "index"]); //pronto
    Route::put("/status/{id}", [Controller::class, "updateStatus"]); //pronto
    Route::delete("/delete/{id}", [Controller::class, "deleteUser"]); //pronto
});

Route::post('/upload-images', [UserImageController::class, 'upload']);//pronto;
Route::get('user/{id}/images', [UserImageController::class, 'getUserImages']);//pronto;
Route::get('/search-users', [Controller::class, 'searchByTag']);
Route::post("/register", [Controller::class, "register"]); //pronto
Route::post("/login", [Controller::class, "login"]); //pronto
Route::get("/buscar", [Controller::class, "buscarOngs"]);
Route::get("/buscar/{id}", [Controller::class, "buscarPorId"]);
Route::middleware("auth:sanctum")->post("/mudarSenha", [Controller::class, "changePassword"]);
