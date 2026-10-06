<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homecontroller;
use  App\http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [Homecontroller::class, 'index']);

Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');
