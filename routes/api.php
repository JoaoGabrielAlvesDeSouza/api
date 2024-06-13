<?php

use App\Http\Controllers\Controller;
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

Route::post("/register", [Controller::class, "register"]); //pronto
Route::post("/login", [Controller::class, "login"]); //pronto
Route::get("/buscar", [Controller::class, "buscarOngs"]);
Route::get("/buscar/{id}", [Controller::class, "buscarPorId"]);