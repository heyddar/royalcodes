<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Channel\ChannelController;


Route::prefix('/channel')->group(function (){
    Route::get('/index',[
        ChannelController::class,
        'index'
    ])->name('channel.index');

    Route::middleware('can:channel management')->group(function (){
        Route::post('/create',[
            ChannelController::class,
            'create'
        ])->name('channel.create');
        Route::put('/update',[
            ChannelController::class,
            'edit'
        ])->name('channel.update');
        Route::delete('/delete',[
            ChannelController::class,
            'delete'
        ])->name('channel.delete');
    });

});
