<?php

use App\Http\Controllers\FieldController;
use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Forms
Route::prefix('forms')->group(function () {
    Route::get('/', [FormController::class, 'index']);
    Route::get('/{id}', [FormController::class, 'show']);
    Route::post('/', [FormController::class, 'store']);
    Route::put('/{id}', [FormController::class, 'update']);
    Route::delete('/{id}', [FormController::class, 'destroy']);
});

//fields
Route::prefix('fields')->group(function () {
    Route::get('/{id}/reset', [FieldController::class, 'resetFields']);
    Route::put('/{formId}', [FieldController::class, 'updateFieldValue']);
});