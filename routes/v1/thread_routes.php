<?php

use Illuminate\Support\Facades\Route;


Route::resource('threads' , 'Api\v1\Thread\ThreadController');

Route::prefix('/threads')->group(function (){
    Route::resource('answers' , 'Api\v1\Thread\AnswerController');
});
