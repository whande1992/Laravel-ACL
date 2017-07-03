<?php



Route::group(['middleware' => 'web', 'prefix' => 'grupos', 'namespace' => 'Modules\GruposDeAcesso\Http\Controllers'], function()
{
  /*  Route::get('/', 'GruposDeAcessoController@index');*/
    Route::get('/', ['uses' => 'GruposDeAcessoController@actionIndex', 'as' => 'actionIndexRole']);
    Route::post('/salvar', ['uses' => 'GruposDeAcessoController@actionCreate', 'as' => 'actionCreateRole']);
    Route::match(['get', 'post'],'{id}/editar/', ['uses' => 'GruposDeAcessoController@actionUpdate', 'as' => 'actionUpdateRole']);
    Route::get('{id}/deletar', ['uses' => 'GruposDeAcessoController@actionDelete', 'as' => 'actionDeleteRole']);




});
