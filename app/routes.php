<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::get('/convenios', 'ConveniosController@index');
    Route::get('/areas_atuacao', function(){
        return AreaAtuacaoProponente::all();
    });
});
