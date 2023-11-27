<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::multistep('auth/register', 'Auth\Register\RegisterController')
    ->steps(3)
    ->name('auth.register');
