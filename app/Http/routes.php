<?php
/*
|--------------------------------------------------------------------------
| Auth actions
|--------------------------------------------------------------------------
*/
Route::get('/auth/login', [
	'uses' => 'Auth\AuthController@getLogin',
	'as' => 'auth.login',
	'middleware' => ['guest']
]);
Route::post('/auth/login', [
	'uses' => 'Auth\AuthController@postLogin',
	'as' => 'auth.login',
	'middleware' => ['guest']
]);

Route::get('/auth/register', [
	'uses' => '\Mik\Http\Controllers\Auth\AuthController@getRegister',
	'as' => 'register',
	'middleware' => ['guest']
]);
Route::post('/auth/register', [
	'uses' => 'Auth\AuthController@postRegister',
	'as' => 'auth.register',
	'middleware' => ['guest']
]);
Route::get('/auth/logout', [
	'uses' => '\Mik\Http\Controllers\Auth\AuthController@getLogout',
	'as' => 'auth.logout'
]);


/*
|--------------------------------------------------------------------------
| Home actions
|--------------------------------------------------------------------------
*/

    Route::get('/', [
        'uses' => '\Mik\Http\Controllers\HomeController@index',
        'as' => 'home'
    ]);
    Route::get('/news', [
        'uses' => '\Mik\Http\Controllers\NewsController@index',
        'as' => 'news'
    ]);

    Route::get('/services', [
        'uses' => '\Mik\Http\Controllers\ServicesController@index',
        'as' => 'services'
    ]);

    Route::group(['prefix' => 'photos'], function() {
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\PhotosController@index',
            'as' => 'photos'
        ]);
        Route::get('/{slug}', [
            'uses' => '\Mik\Http\Controllers\PhotosController@view',
            'as' => 'photos.view'
        ]);
        Route::get('/loadmore/{id}/{num}', [
            'uses' => '\Mik\Http\Controllers\PhotosController@loadmore',
            'as' => 'photos.loadmore'
        ]);
    });

    Route::get('/about', [
        'uses' => '\Mik\Http\Controllers\AboutController@index',
        'as' => 'about'
    ]);


    Route::get('/contacts', [
        'uses' => '\Mik\Http\Controllers\ContactController@index',
        'as' => 'contacts'
    ]);
    Route::post('/contacts', [
        'uses' => '\Mik\Http\Controllers\ContactController@sendEmail',
        'as' => 'contacts.sendEmail'
    ]);

    Route::post('/upload-image', [
        'uses' => '\Mik\Http\Controllers\UploadController@index'
    ]);


Route::group(['prefix' => 'admin', 'middleware' => 'Mik\Http\Middleware\AdminMiddleware'], function()
{
    Route::get('/', [
		'uses' => '\Mik\Http\Controllers\Admin\HomeController@index',
		'as' => 'admin.home'
	]);
    Route::post('/', [
        'uses' => '\Mik\Http\Controllers\Admin\HomeController@index',
        'as' => 'admin.home'
    ]);

    /*
     * News
     */

    Route::get('/news', [
        'uses' => '\Mik\Http\Controllers\Admin\NewsController@index',
        'as' => 'admin.news'
    ]);
    Route::get('/news/add', [
        'uses' => '\Mik\Http\Controllers\Admin\NewsController@add',
        'as' => 'admin.news.add'
    ]);
    Route::post('/news/add', [
        'uses' => '\Mik\Http\Controllers\Admin\NewsController@postAdd',
        'as' => 'admin.news.add'
    ]);
    Route::get('/news/update/{id}', [
        'uses' => '\Mik\Http\Controllers\Admin\NewsController@update',
        'as' => 'admin.news.update'
    ]);
    Route::post('/news/update{id}', [
        'uses' => '\Mik\Http\Controllers\Admin\NewsController@postUpdate',
        'as' => 'admin.news.postUpdate'
    ]);
    Route::get('/news/delete/{id}', [
        'uses' => '\Mik\Http\Controllers\Admin\NewsController@delete',
        'as' => 'admin.news.delete'
    ]);

    /*
     * People
     */
    Route::group(['prefix' => 'people'], function () {
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\Admin\PeopleController@index',
            'as' => 'admin.people'
        ]);
        Route::get('/add', [
            'uses' => '\Mik\Http\Controllers\Admin\PeopleController@add',
            'as' => 'admin.people.add'
        ]);
        Route::post('/add', [
            'uses' => '\Mik\Http\Controllers\Admin\PeopleController@postAdd',
            'as' => 'admin.people.add'
        ]);
        Route::get('/update/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\PeopleController@update',
            'as' => 'admin.people.update'
        ]);
        Route::post('/update{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\PeopleController@postUpdate',
            'as' => 'admin.people.postUpdate'
        ]);
        Route::get('/delete/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\PeopleController@delete',
            'as' => 'admin.people.delete'
        ]);
    });

    /*
     * Photos
     */
    Route::group(['prefix' => 'photos'], function () {
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@index',
            'as' => 'admin.photos'
        ]);
        Route::get('/create', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@create',
            'as' => 'admin.photos.create'
        ]);
        Route::post('/create', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@postCreate',
            'as' => 'admin.photos.create'
        ]);
        Route::get('/update/{slug}', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@update',
            'as' => 'admin.photos.update'
        ]);
        Route::post('/update/{slug}', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@postUpdate',
            'as' => 'admin.photos.postUpdate'
        ]);

        Route::post('/add', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@addPhotos',
            'as' => 'admin.photos.addPhotos'
        ]);

        Route::get('/edit/{slug}', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@edit',
            'as' => 'admin.photos.edit'
        ]);

        Route::post('/deletemassive/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@deleteMassive',
            'as' => 'admin.photos.deletemassive'
        ]);

        Route::get('/deleteOne/{categoryId}/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@deleteOne',
            'as' => 'admin.photos.deleteOne'
        ]);

        Route::get('/delete/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\PhotoController@delete',
            'as' => 'admin.photos.delete'
        ]);
    });

    /*
     * Works
     */
    Route::group(['prefix' => '/works'], function(){
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\Admin\WorksController@index',
            'as' => 'admin.works'
        ]);
        Route::get('/add', [
            'uses' => '\Mik\Http\Controllers\Admin\WorksController@add',
            'as' => 'admin.works.add'
        ]);
        Route::post('/add', [
            'uses' => '\Mik\Http\Controllers\Admin\WorksController@postAdd',
            'as' => 'admin.works.postAdd'
        ]);
        Route::get('/update/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\WorksController@update',
            'as' => 'admin.works.update'
        ]);
        Route::post('/update/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\WorksController@postUpdate',
            'as' => 'admin.works.postUpdate'
        ]);
        Route::get('/delete/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\WorksController@delete',
            'as' => 'admin.works.delete'
        ]);
    });

    /*
     * Services
     */

    Route::group(['prefix' => '/services'], function(){
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\Admin\ServicesController@index',
            'as' => 'admin.services'
        ]);
        Route::get('/edit/{id?}', [
            'uses' => '\Mik\Http\Controllers\Admin\ServicesController@edit',
            'as' => 'admin.services.edit'
        ]);
        Route::post('/edit/{id?}', [
            'uses' => '\Mik\Http\Controllers\Admin\ServicesController@postEdit',
            'as' => 'admin.services.postEdit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\ServicesController@delete',
            'as' => 'admin.services.delete'
        ]);
    });



    /*
     * Contacts
     */
	
	Route::get('/contacts', [
		'uses' => '\Mik\Http\Controllers\Admin\ContactController@index',
		'as' => 'admin.contacts.index'
	]);
	Route::post('/contacts', [
		'uses' => '\Mik\Http\Controllers\Admin\ContactController@postIndex',
		'as' => 'admin.contacts.index'
	]);

    /*
     * Messages
     */

    Route::group(['prefix'=>'/messages'], function() {
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\Admin\MessagesController@index',
            'as' => 'admin.messages'
        ]);
        Route::get('/read', [
            'uses' => '\Mik\Http\Controllers\Admin\MessagesController@read',
            'as' => 'admin.messages.read'
        ]);
        Route::get('/all', [
            'uses' => '\Mik\Http\Controllers\Admin\MessagesController@all',
            'as' => 'admin.messages.all'
        ]);
        Route::post('/markasread', [
            'uses' => '\Mik\Http\Controllers\Admin\MessagesController@markasread',
            'as' => 'admin.messages.markAsRead'
        ]);
        Route::post('/delete', [
            'uses' => '\Mik\Http\Controllers\Admin\MessagesController@delete',
            'as' => 'admin.messages.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => '\Mik\Http\Controllers\Admin\MessagesController@view'
        ]);
    });

    /*
     * Settings
     */

    Route::group(['prefix' => '/settings'], function() {
        Route::get('/', [
            'uses' => '\Mik\Http\Controllers\Admin\SettingsController@index',
            'as' => 'admin.settings'
        ]);
        Route::post('/', [
            'uses' => '\Mik\Http\Controllers\Admin\SettingsController@postIndex',
            'as' => 'admin.settings.index'
        ]);
    });
});