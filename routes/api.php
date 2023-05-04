<?php

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

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::apiResource('documents', 'API\DocumentController', ['parameters' => [
        'documents' => 'id'
    ], 'as' => 'api'])->middleware('api.guard');

    Route::apiResource('images', 'API\ImageController', ['parameters' => [
        'images' => 'id'
    ], 'as' => 'api'])->middleware('api.guard');

    Route::apiResource('account', 'API\AccountController', ['only' => [
        'index'
    ], 'as' => 'api'])->middleware('api.guard');

    Route::fallback(function () {
        return response()->json(['message' => __('Resource not found.'), 'status' => 404], 404);
    });
});
