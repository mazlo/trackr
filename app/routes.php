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

Route::any( '/login', 'UserController@loginAction' );

/*
	Authentication neccessary
*/
Route::group( array( 'before' => 'auth' ), function()
{
	/*
		Routes concerning stackrs
	*/
	Route::get( '/stackr', 'StackrController@show' );

	Route::get( '/stackr/all', 'StackrController@all' );

	Route::post( '/stackr/add', 'StackrController@add' );

	Route::post( '/stackr/{eid}/delete', 'StackrController@delete' );

	Route::post( '/stackr/{eid}/changeTitle', 'StackrController@changeTitle' );

	Route::post( '/stackr/{eid}/changeListTitle', 'StackrController@changeListTitle' );

	/*
		Routes concerning stackr comments
	*/
	Route::get( '/stackr/{eid}/comments', 'CommentController@getAll' );

	Route::post( '/stackr/{eid}/comments/add', 'CommentController@add' );

	Route::post( '/stackr/{eid}/comments/{cid}/delete', 'CommentController@delete' );

	/* 
		change this to ContextController in future
		that this becomes /context/{id}/tagsDistinct
	*/
	Route::get( '/tagsDistinct', 'TagController@getDistinctTagList' );

    Route::any( '/logout', array(
        'as'   => 'user/logout',
        'uses' => 'UserController@logoutAction'
    ));
});