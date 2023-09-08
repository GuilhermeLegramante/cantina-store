<?php

use Illuminate\Support\Facades\Route;

Route::get('/teste', 'TestController@xml')->name('test');

Route::get('/login', 'AuthController@loginView')->name('loginView');
Route::post('/login', 'AuthController@login')->name('login');
Route::get('/sair', 'AuthController@logout')->name('logout');

Route::get('/find-products', 'MainController@findProductsCode')->name('find-product');

Route::get('/cosmos', 'MainController@findProductFromCosmosApi')->name('cosmos');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'MainController@dashboard')->name('dashboard');

    Route::prefix('/usuario')->group(function () {
        Route::get('/', 'UserController@table')->name('user.table');
        Route::get('/inclusao', 'UserController@form')->name('user.create');
        Route::get('/{id}', 'UserController@form')->name('user.edit');
    });

    Route::prefix('/categoria')->group(function () {
        Route::get('/', 'CategoryController@table')->name('category.table');
    });

    Route::prefix('/fabricante')->group(function () {
        Route::get('/', 'ManufacturerController@table')->name('manufacturer.table');
    });

    Route::prefix('/unidade-de-medida')->group(function () {
        Route::get('/', 'MeasurementUnitController@table')->name('measurementUnit.table');
    });

    Route::prefix('/cest-ncm')->group(function () {
        Route::get('/', 'CestncmController@table')->name('cestncm.table');
    });

    Route::prefix('/cfop')->group(function () {
        Route::get('/', 'CfopController@table')->name('cfop.table');
    });

    Route::prefix('/csosn')->group(function () {
        Route::get('/', 'CsosnController@table')->name('csosn.table');
    });

    Route::prefix('/produto')->group(function () {
        Route::get('/', 'ProductController@table')->name('product.table');
    });

    Route::prefix('/loja')->group(function () {
        Route::get('/', 'StoreController@table')->name('store.table');
    });

    Route::prefix('/tipo-de-saida')->group(function () {
        Route::get('/', 'TypeController@table')->name('type.table');
    });

    Route::prefix('/cliente')->group(function () {
        Route::get('/', 'CustomerController@table')->name('customer.table');
    });
});
