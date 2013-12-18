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
	Route::get( '/contexts', 'ContextController@showAll' );

	/*
		Routes concerning stackrs
	*/
	Route::get( '/stackrs', array(
		'as' => 'landingPage',
		'uses' => 'StackrController@show'
	));

	Route::get( '/contexts/{pcid}/stackrs', 'StackrController@showAll' );

	Route::get( '/contexts/{pcid}/stackrs/all', 'StackrController@all' );

	Route::post( '/stackrs/add', 'StackrController@add' );

	Route::get( '/stackrs/{eid}', 'StackrController@details' );

	Route::post( '/stackrs/{eid}/delete', 'StackrController@delete' );

	Route::post( '/stackrs/{eid}/changeTitle', 'StackrController@changeTitle' );

	Route::post( '/stackrs/{eid}/changeListTitle', 'StackrController@changeListTitle' );

	Route::post( '/stackrs/{eid}/changePinStatus', 'StackrController@changePinStatus' );

	Route::post( '/stackrs/{eid}/changeTags', 'StackrController@changeTags' );

	/*
		Routes concerning stackr comments
	*/
	Route::get( '/stackrs/{eid}/comments', 'CommentController@getAll' );

	Route::post( '/stackrs/{eid}/comments/add', 'CommentController@add' );

	Route::post( '/stackrs/{eid}/comments/{cid}/delete', 'CommentController@delete' );

	Route::post( '/stackrs/{eid}/comments/reorder', 'CommentController@reorder' );

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