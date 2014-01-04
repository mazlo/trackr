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

Route::any( '/', array(
    'as' => 'user/login',
    'uses' => 'UserController@loginAction'
));

Route::any( '/users/register', array(
	'as' => 'users/register',
	'uses' => 'UserController@registerAction'
));

Route::any( '/login', 'UserController@loginAction' );

/*
	Authentication neccessary
*/
Route::group( array( 'before' => 'auth' ), function()
{
	/*
		Routes concerning contexts
	*/
	Route::get( '/contexts', 'ContextController@index' );

	Route::get( '/contexts/{contextName}/distinctTagList', 'ContextController@distinctTagList' );

	Route::post( '/contexts', 'ContextController@add' );

	Route::post( '/contexts/make', 'ContextController@make' );

	Route::delete( '/contexts/{contextName}', 'ContextController@delete' );

	Route::put( '/contexts/{contextName}', 'ContextController@update' );

	/*
		Routes concerning stackrs
	*/

	Route::get( '/contexts/{contextName}/stackrs', 'StackrController@index' );

	Route::post( 'contexts/{contextName}/stackrs', 'StackrController@add' );

	Route::get( '/contexts/{contextName}/stackrs/{eid}', 'StackrController@details' );

	Route::delete( '/contexts/{contextName}/stackrs/{eid}', 'StackrController@delete' );

	Route::put( '/contexts/{contextName}/stackrs/{eid}', 'StackrController@update' );

	/*
		Routes concerning stackr comments
	*/
	Route::get( '/contexts/{contextName}/stackrs/{eid}/comments', 'CommentController@index' );

	Route::post( '/contexts/{contextName}/stackrs/{eid}/comments', 'CommentController@add' );

	Route::delete( '/contexts/{contextName}/stackrs/{eid}/comments/{cid}', 'CommentController@delete' );

	Route::put( '/contexts/{contextName}/stackrs/{eid}/comments', 'CommentController@update' );

    Route::any( '/logout', array(
        'as'   => 'user/logout',
        'uses' => 'UserController@logoutAction'
    ));
});