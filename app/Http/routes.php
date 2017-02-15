<?php

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Pagina inicial
Route::get('/', function () {
    return view('welcome');
});

//Acesso/token/login
Route::post('oauth/access_token', function() {
	return Response::json(Authorizer::issueAccessToken());
});

//Rotas agrupadas
Route::group(['middleware' => 'oauth'], function(){
	
	//rotas client
	Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
	/* 
	 * resource chama os metodos e funcoes especificas com excecao das informadas
	 * a linha a cima ROute::resource substitui todas as rotas client a baixo
	 * 
	* Route::get('client', ['middleware' => 'oauth', 'uses' => 'ClientController@index']);
	* Route::post('client', 'ClientController@store');
	* Route::get('client/{id}', 'ClientController@show');
	* Route::delete('client/{id}', 'ClientController@destroy');
	* Route::put('client/{id}', 'ClientController@update');
	*/
	
	//Rotas para project - foi agrupada para porject e project notes pois tem o mesmo prefixo
	Route::group(['prefix' => 'project'], function(){
		//rotas project
		Route::resource('', 'ProjectController', ['except' => ['create', 'edit']]);
		
		//rotas project note
		Route::get('{id}/note', 'ProjectNoteController@index');
		Route::post('{id}/note', 'ProjectNoteController@store');
		Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
		Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
		Route::delete('{id}/note/{noteId}', 'ProjectNoteController@delete');
	});
	
	/* rotas project
	* Route::get('project', 'ProjectController@index');
	* Route::post('project', 'ProjectController@store');
	* Route::put('project/{id}', 'ProjectController@update');
	* Route::delete('project/{id}', 'ProjectController@destroy');
	* Route::get('project/{id}', 'ProjectController@show');
	*/
});

