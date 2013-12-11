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

Route::any( '/', [
    'as' => 'user/login',
    'uses' => 'UserController@loginAction'
]);

Route::any( '/login', 'UserController@loginAction' );

/*
	Authentication neccessary
*/
Route::group( [ 'before' => 'auth' ], function()
{
	Route::get( '/stackr', 'StackrController@getAll' );

	Route::post( '/stackr/add', 'StackrController@add' );

	/* 
		change this to ContextController in future
		that this becomes /context/{id}/tagsDistinct
	*/
	Route::get( '/tagsDistinct', 'TagController@getDistinctTagList' );

    Route::any( '/logout', [
        'as'   => 'user/logout',
        'uses' => 'UserController@logoutAction'
    ]);
});