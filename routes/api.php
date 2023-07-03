<?php

use App\Http\Controllers\MainController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/meals', [MainController::class, 'getMeals']);
Route::delete('/meals/{id}', [MainController::class, 'deleteMeal']);
Route::get('/meals/generate', [MainController::class, 'generateData']);

Route::get('/categories', [MainController::class, 'getCategories']);
Route::get('/ingredients', [MainController::class, 'getIngredients']);
Route::get('/tags', [MainController::class, 'getTags']);
