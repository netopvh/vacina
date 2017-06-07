<?php

Route::get('/','HomeController@index')->name('index');
Route::post('/login','HomeController@postUser')->name('index.login');
Route::get('/home','RegisterController@index')->name('register.home');
Route::post('/dependente','RegisterController@postDependente')->name('register.dependente');
Route::get('/logout','RegisterController@logout')->name('register.logout');
Route::patch('/atualiza/{id}','RegisterController@postAtualiza')->name('register.atualiza');
Route::delete('/delete/{id}','RegisterController@deleteDependente')->name('register.delete');
Route::get('/termo/{id}','RegisterController@generatePdf')->name('register.termo');