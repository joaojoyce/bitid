<?php

/**
 *
 * BITID routes
 *
 */


Route::group(['middleware' => ['web']], function () {
    Route::get('/authenticate','\JoaoJoyce\BitId\Controllers\AuthController@showLoginPage');
    Route::post('/authenticate','\JoaoJoyce\BitId\Controllers\AuthController@verifySignature');
    Route::get('/check', '\JoaoJoyce\BitId\Controllers\AuthController@check');

    Route::get('/sign_request', function(){
        return view('bitid::sign_request');
    });

    Route::get('/user',function(){
        $user = \Auth::user();
        if($user) {
            echo "Hi: " . $user->bit_id;
        } else {
            echo "Sorry! You're not logged in";
        }
    });

    Route::get('/logout',function(){
        \Auth::logout();
    });

});

