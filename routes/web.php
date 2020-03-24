<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('login', 'UserController@login');
Route::group(["prefix" => "auth"], function () {
    Route::get('/home', function () {
        return view('panelhome');
    })->name('home');
    Route::get('/usuarios', function () {
        return view('users.index');
    });
    //---------------------------------
    Route::get('roles', 'RoleController@index');
    Route::resource('/users', 'UserController')->except([
        'show', 'create', 'edit'
    ]);
    Route::get('users/locked', 'UserController@user_is_locked');
    Route::put('users/available/{id}', 'UserController@available');
    Route::put('users/locked/{id}', 'UserController@locked');
    Route::post('logout', 'UserController@logout')->name('logout');
});