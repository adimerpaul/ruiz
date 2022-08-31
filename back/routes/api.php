<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::post('/updatePassword/{user}',[\App\Http\Controllers\UserController::class,'updatePassword']);
    Route::resource('producer',\App\Http\Controllers\ProducerController::class);
    Route::post('producerFilter',[\App\Http\Controllers\ProducerController::class,'producerFilter']);
    Route::post('consultaEdades',[\App\Http\Controllers\ConsultaController::class,'consultaEdades']);
    Route::post('consultaUsers',[\App\Http\Controllers\ConsultaController::class,'consultaUsers']);
    Route::post('producerSearch',[\App\Http\Controllers\ProducerController::class,'producerSearch']);
    Route::post('/upload', [\App\Http\Controllers\UploadController::class,'upload']);
    Route::post('/base64', [\App\Http\Controllers\Base64Controller::class,'base64']);

    Route::resource('user',\App\Http\Controllers\UserController::class);
});
