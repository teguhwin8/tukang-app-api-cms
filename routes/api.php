<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    Route::post('login', 'AuthApiController@login')->name('login');
    Route::get('login/get', 'AuthApiController@getlogin');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Abilities
    Route::apiResource('abilities', 'AbilitiesController', ['only' => ['index']]);

    // Locales
    Route::get('locales/languages', 'LocalesController@languages')->name('locales.languages');
    Route::get('locales/messages', 'LocalesController@messages')->name('locales.messages');

    // Permissions
    Route::resource('permissions', 'PermissionsApiController');

    // Roles
    Route::resource('roles', 'RolesApiController');

    // Users
    Route::resource('users', 'UsersApiController');

    // Projects
    Route::post('projects/media', 'ProjectsApiController@storeMedia')->name('projects.storeMedia');
    Route::resource('projects', 'ProjectsApiController');
});
