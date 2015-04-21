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
    	
    	
        #------------------------------BEGIN PROPERTIES-----------------------------------#
    	Route::any('admin/properties', array( 'uses' => 'PropertiesController@index'));
    	Route::any('admin/properties/properties.json', array( 'uses' => 'PropertiesController@getPropertiesJson'));
    	Route::any('admin/properties/new', array( 'uses' => 'PropertiesController@createNewProperty'));
    	Route::any('admin/properties/edit/{id}', array( 'uses' => 'PropertiesController@editProperty'));
    	Route::any('admin/properties/delete/{id}', array( 'uses' => 'PropertiesController@deleteProperty'));
    	#------------------------------END PROPERTIES--------------------------------#

        #------------------------------BEGIN PROPERTIES-----------------------------------#
        Route::any('admin/shops', array( 'uses' => 'ShopsController@index'));
        Route::any('admin/shops/shops.json', array( 'uses' => 'ShopsController@getShopsJson'));
        Route::any('admin/shops/new', array( 'uses' => 'ShopsController@createNewShop'));
        Route::any('admin/shops/edit/{id}', array( 'uses' => 'ShopsController@editShop'));
        Route::any('admin/shops/delete/{id}', array( 'uses' => 'ShopsController@deleteShop'));
        Route::any('admin/shops/citysuggestions/{query}', array( 'uses' => 'ShopsController@getCitySuggestions'));
        #------------------------------END PROPERTIES--------------------------------#

        #------------------------------BEGIN BATCH-----------------------------------#
    	Route::any('admin/batch', array( 'uses' => 'BatchController@index'));
        Route::any('admin/batch/batch.json', array( 'uses' => 'BatchController@getBatchJson'));
        Route::any('admin/batch/shops.json', array( 'uses' => 'BatchController@getShopJson'));
        Route::any('admin/batch/batch-shop.json/{id}', array( 'uses' => 'BatchController@getBatchShopJson'));
        Route::any('admin/batch/new', array( 'uses' => 'BatchController@createNewBatch'));
        Route::any('admin/batch/edit/{id}', array( 'uses' => 'BatchController@editBatch'));
        Route::any('admin/batch/delete/{id}', array( 'uses' => 'BatchController@deleteBatch'));
        Route::any('admin/batch/citysuggestions/{query}', array( 'uses' => 'BatchController@getCitySuggestions'));
        #------------------------------END BATCH-----------------------------------#

        #------------------------------BEGIN CAGEGORY-----------------------------------#
        Route::any('admin/categories', array( 'uses' => 'CategoryController@index'));
        Route::any('admin/categories/category.json', array( 'uses' => 'CategoryController@getCategoryJson'));
        Route::any('admin/categories/new', array( 'uses' => 'CategoryController@newCategory'));
        Route::any('admin/categories/edit/{id}', array( 'uses' => 'CategoryController@editCategory'));
        Route::any('admin/categories/delete/{id}', array( 'uses' => 'CategoryController@deleteCategory'));
        #------------------------------END CAGEGORY-----------------------------------#

        #------------------------------BEGIN PRODUCT-----------------------------------#
        Route::any('admin/products', array( 'uses' => 'ProductController@index'));
        Route::any('admin/products/product.json', array( 'uses' => 'ProductController@getProductJson'));
        Route::any('admin/products/new', array( 'uses' => 'ProductController@newProduct'));
        Route::any('admin/products/edit/{id}', array( 'uses' => 'ProductController@editProduct'));
        Route::any('admin/products/delete/{id}', array( 'uses' => 'ProductController@deleteCategory'));
        Route::any('admin/products/property_list', array( 'uses' => 'ProductController@getProductProperties'));
        Route::any('admin/products/generate-barcode/{id}', array( 'uses' => 'ProductController@generateBarcode'));
        #------------------------------END PRODUCT-----------------------------------#

    	Route::any('admin/reports', array( 'uses' => 'ReportsController@index'));
    } else {
   		return Redirect::to('login');
    }
});


