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

Route::get('/', function()
{
	
	if (Auth::check())
	{
	    if (Auth::user()->role == 'Admin' ) {
		    return Redirect::to('admin/dashboard');
		} else {
		    return Redirect::to('dashboard');
		}

	} else {
		return Redirect::to('login');
	}
});

Route::any('login', array( 'uses' => 'UserController@login'));
Route::any('logout', array( 'uses' => 'UserController@logout'));

Route::group(array('before' => 'auth'), function()
{
    if(Auth::check() && Auth::user()->role == 'Admin') {
    	Route::any('admin/dashboard', array( 'uses' => 'DashboardController@dashboard'));
    	Route::any('admin/products', array( 'uses' => 'ProductController@index'));
    	Route::any('admin/categories', array( 'uses' => 'CategoryController@index'));
    	#------------------------------BEGIN PROPERTIES-----------------------------------#
    	Route::any('admin/properties', array( 'uses' => 'PropertiesController@index'));
    	Route::any('admin/properties/properties.json', array( 'uses' => 'PropertiesController@getPropertiesJson'));
    	Route::any('admin/properties/new', array( 'uses' => 'PropertiesController@createNewProperty'));
    	Route::any('admin/properties/save_new_property', array( 'uses' => 'PropertiesController@saveNewProperty'));
    	#------------------------------END PROPERTIES--------------------------------#

    	Route::any('admin/batch', array( 'uses' => 'BatchController@index'));
    	Route::any('admin/shops', array( 'uses' => 'ShopsController@index'));
    	Route::any('admin/reports', array( 'uses' => 'ReportsController@index'));
    } else {
   		return Redirect::to('login');
    }
});


