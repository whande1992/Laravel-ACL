<?php



Route::group(['middleware' => 'web', 'prefix' => 'grupos', 'namespace' => 'Modules\GruposDeAcesso\Http\Controllers'], function()
{
  /*  Route::get('/', 'GruposDeAcessoController@index');*/
    Route::get('/', ['uses' => 'GruposDeAcessoController@actionIndex', 'as' => 'actionIndex']);
    Route::post('/salvar', ['uses' => 'GruposDeAcessoController@actionCreate', 'as' => 'actionCreate']);
    Route::match(['get', 'post'],'{id}/editar/', ['uses' => 'GruposDeAcessoController@actionUpdate', 'as' => 'actionUpdate']);
    Route::get('/deletar', ['uses' => '/Helpers/helper@softDelete', 'as' => 'actionDestroy']);




});
