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
	Route::get( '/contexts', 'ContextController@view' );

	Route::get( '/contexts/all', 'ContextController@all' );

	Route::get( '/contexts/{contextName}/distinctTagList', 'ContextController@distinctTagList' );

	Route::post( '/contexts/add', 'ContextController@add' );

	/*
		Routes concerning stackrs
	*/

	Route::get( '/contexts/{contextName}/stackrs', 'StackrController@view' );

	Route::get( '/contexts/{contextName}/stackrs/all', 'StackrController@all' );

	Route::post( 'contexts/{contextName}/stackrs/add', 'StackrController@add' );

	Route::get( '/contexts/{contextName}/stackrs/{eid}', 'StackrController@details' );

	Route::post( '/contexts/{contextName}/stackrs/{eid}/delete', 'StackrController@delete' );

	Route::post( '/contexts/{contextName}/stackrs/{eid}/changeTitle', 'StackrController@changeTitle' );

	Route::post( '/contexts/{contextName}/stackrs/{eid}/changeListTitle', 'StackrController@changeListTitle' );

	Route::post( '/contexts/{contextName}/stackrs/{eid}/changePinStatus', 'StackrController@changePinStatus' );

	Route::post( '/contexts/{contextName}/stackrs/{eid}/changeTags', 'StackrController@changeTags' );

	/*
		Routes concerning stackr comments
	*/
	Route::get( '/stackrs/{eid}/comments', 'CommentController@getAll' );

	Route::post( '/stackrs/{eid}/comments/add', 'CommentController@add' );

	Route::post( '/stackrs/{eid}/comments/{cid}/delete', 'CommentController@delete' );

	Route::post( '/stackrs/{eid}/comments/reorder', 'CommentController@reorder' );

    Route::any( '/logout', array(
        'as'   => 'user/logout',
        'uses' => 'UserController@logoutAction'
    ));
});