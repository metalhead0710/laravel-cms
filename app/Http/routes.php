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
	'uses' => '\PyroMans\Http\Controllers\Auth\AuthController@getRegister',
	'as' => 'register',
	'middleware' => ['guest']
]);
Route::post('/auth/register', [
	'uses' => 'Auth\AuthController@postRegister',
	'as' => 'auth.register',
	'middleware' => ['guest']
]);
Route::get('/auth/logout', [
	'uses' => '\PyroMans\Http\Controllers\Auth\AuthController@getLogout',
	'as' => 'auth.logout'
]);
Route::get('/auth/check-email', [
    'uses' => '\PyroMans\Http\Controllers\Auth\AuthController@checkEmail',
    'as' => 'auth.checkEmail'
]);
Route::post('/auth/check-email', [
    'uses' => '\PyroMans\Http\Controllers\Auth\AuthController@postCheckEmail',
    'as' => 'auth.checkEmail'
]);
Route::get('/auth/reset-password/{token}', [
    'uses' => '\PyroMans\Http\Controllers\Auth\AuthController@resetPassword',
    'as' => 'auth.resetPassword'
]);
Route::post('/auth/reset-password/{token}', [
    'uses' => '\PyroMans\Http\Controllers\Auth\AuthController@postResetPassword'
]);

/*
|--------------------------------------------------------------------------
| Home actions
|--------------------------------------------------------------------------
*/

    Route::get('/', [
        'uses' => '\PyroMans\Http\Controllers\HomeController@index',
        'as' => 'home'
    ]);
    Route::get('/news', [
        'uses' => '\PyroMans\Http\Controllers\NewsController@index',
        'as' => 'news'
    ]);


    Route::group(['prefix' => 'photos'], function() {
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\PhotosController@index',
            'as' => 'photos'
        ]);
        Route::get('/{slug}', [
            'uses' => '\PyroMans\Http\Controllers\PhotosController@view',
            'as' => 'photos.view'
        ]);
        Route::get('/loadmore/{id}/{num}', [
            'uses' => '\PyroMans\Http\Controllers\PhotosController@loadmore',
            'as' => 'photos.loadmore'
        ]);
    });

    Route::get('/contacts', [
        'uses' => '\PyroMans\Http\Controllers\ContactController@index',
        'as' => 'contacts'
    ]);
    Route::post('/contacts', [
        'uses' => '\PyroMans\Http\Controllers\ContactController@sendEmail',
        'as' => 'contacts.sendEmail'
    ]);

    Route::post('/upload-image', [
        'uses' => '\PyroMans\Http\Controllers\UploadController@index'
    ]);


Route::group(['prefix' => 'dominator', 'middleware' => 'PyroMans\Http\Middleware\AdminMiddleware'], function()
{
    Route::get('/', [
		'uses' => '\PyroMans\Http\Controllers\Admin\HomeController@index',
		'as' => 'admin.home'
	]);
    Route::get('/getData', [
        'uses' => '\PyroMans\Http\Controllers\Admin\HomeController@getData',
        'as' => 'admin.home.getData'
    ]);
    Route::post('/getData', [
        'uses' => '\PyroMans\Http\Controllers\Admin\HomeController@getData',
        'as' => 'admin.home.getData'
    ]);

    /*
     * Banners
     */

    Route::group(['prefix' => 'banners'], function() {
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\BannerController@index',
            'as' => 'admin.banners'
        ]);
        Route::post('/create', [
            'uses' => '\PyroMans\Http\Controllers\Admin\BannerController@create',
            'as' => 'admin.banners.create'
        ]);
        Route::post('/sort-out', [
            'uses' => '\PyroMans\Http\Controllers\Admin\BannerController@sortOut',
            'as' => 'admin.banners.sortout'
        ]);
        Route::get('/delete/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\BannerController@delete',
            'as' => 'admin.banners.delete'
        ]);
    });

    /*
     * News
     */

    Route::get('/news', [
        'uses' => '\PyroMans\Http\Controllers\Admin\NewsController@index',
        'as' => 'admin.news'
    ]);
    Route::get('/news/add', [
        'uses' => '\PyroMans\Http\Controllers\Admin\NewsController@add',
        'as' => 'admin.news.add'
    ]);
    Route::post('/news/add', [
        'uses' => '\PyroMans\Http\Controllers\Admin\NewsController@postAdd',
        'as' => 'admin.news.add'
    ]);
    Route::get('/news/update/{id}', [
        'uses' => '\PyroMans\Http\Controllers\Admin\NewsController@update',
        'as' => 'admin.news.update'
    ]);
    Route::post('/news/update{id}', [
        'uses' => '\PyroMans\Http\Controllers\Admin\NewsController@postUpdate',
        'as' => 'admin.news.postUpdate'
    ]);
    Route::get('/news/delete/{id}', [
        'uses' => '\PyroMans\Http\Controllers\Admin\NewsController@delete',
        'as' => 'admin.news.delete'
    ]);

    /*
     * Photos
     */
    Route::group(['prefix' => 'photos'], function () {
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@index',
            'as' => 'admin.photos'
        ]);
        Route::get('/create', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@create',
            'as' => 'admin.photos.create'
        ]);
        Route::post('/create', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@postCreate',
            'as' => 'admin.photos.create'
        ]);
        Route::get('/update/{slug}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@update',
            'as' => 'admin.photos.update'
        ]);
        Route::post('/update/{slug}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@postUpdate',
            'as' => 'admin.photos.postUpdate'
        ]);

        Route::post('/add', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@addPhotos',
            'as' => 'admin.photos.addPhotos'
        ]);

        Route::get('/edit/{slug}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@edit',
            'as' => 'admin.photos.edit'
        ]);

        Route::post('/deletemassive/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@deleteMassive',
            'as' => 'admin.photos.deletemassive'
        ]);

        Route::get('/deleteOne/{categoryId}/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@deleteOne',
            'as' => 'admin.photos.deleteOne'
        ]);
        Route::post('/sort-out', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@sortOut',
            'as' => 'admin.photos.sortout'
        ]);

        Route::get('/delete/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\PhotoController@delete',
            'as' => 'admin.photos.delete'
        ]);
    });

     /*
     * Services
     */

    Route::group(['prefix' => '/services'], function(){
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\ServicesController@index',
            'as' => 'admin.services'
        ]);
        Route::get('/edit/{id?}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\ServicesController@edit',
            'as' => 'admin.services.edit'
        ]);
        Route::post('/edit/{id?}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\ServicesController@postEdit',
            'as' => 'admin.services.postEdit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\ServicesController@delete',
            'as' => 'admin.services.delete'
        ]);
    });



    /*
     * Contacts
     */
	
	Route::get('/contacts', [
		'uses' => '\PyroMans\Http\Controllers\Admin\ContactController@index',
		'as' => 'admin.contacts.index'
	]);
	Route::post('/contacts', [
		'uses' => '\PyroMans\Http\Controllers\Admin\ContactController@postIndex',
		'as' => 'admin.contacts.index'
	]);

    /*
     * Messages
     */

    Route::group(['prefix'=>'/messages'], function() {
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\MessagesController@index',
            'as' => 'admin.messages'
        ]);
        Route::get('/read', [
            'uses' => '\PyroMans\Http\Controllers\Admin\MessagesController@read',
            'as' => 'admin.messages.read'
        ]);
        Route::get('/all', [
            'uses' => '\PyroMans\Http\Controllers\Admin\MessagesController@all',
            'as' => 'admin.messages.all'
        ]);
        Route::post('/markasread', [
            'uses' => '\PyroMans\Http\Controllers\Admin\MessagesController@markasread',
            'as' => 'admin.messages.markAsRead'
        ]);
        Route::post('/delete', [
            'uses' => '\PyroMans\Http\Controllers\Admin\MessagesController@delete',
            'as' => 'admin.messages.delete'
        ]);
        Route::get('/view/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\MessagesController@view'
        ]);
    });

    /*
     * Settings
     */

    Route::group(['prefix' => '/settings'], function() {
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\SettingsController@index',
            'as' => 'admin.settings'
        ]);
        Route::post('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\SettingsController@postIndex',
            'as' => 'admin.settings.index'
        ]);
    });

    /*
     * Socials
     */
    Route::group(['prefix' => '/socials'], function () {
        Route::get('/', [
            'uses' => '\PyroMans\Http\Controllers\Admin\SocialsController@index',
            'as' => 'admin.socials'
        ]);
        Route::post('/edit', [
            'uses' => '\PyroMans\Http\Controllers\Admin\SocialsController@edit',
            'as' => 'admin.socials.edit'
        ]);
        Route::get('/getOne/{id?}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\SocialsController@getOne',
            'as' => 'admin.socials.getOne'
        ]);
        Route::get('/delete/{id}', [
            'uses' => '\PyroMans\Http\Controllers\Admin\SocialsController@delete',
            'as' => 'admin.socials.delete'
        ]);
    });

    /*
     * Popup Message
     */
    Route::get('/getPopupMsg/{res}', [
        'uses' => '\PyroMans\Http\Controllers\Admin\PopupController@index',
        'as' => 'admin.popup'
    ]);

    /*
     * User Actions
     */
    Route::get('/user', [
        'uses' => '\PyroMans\Http\Controllers\Admin\UserController@edit',
        'as' => 'admin.user'
    ]);
    Route::post('/user', [
        'uses' => '\PyroMans\Http\Controllers\Admin\UserController@postEdit'
    ]);
    Route::get('/user/change-password', [
        'uses' => '\PyroMans\Http\Controllers\Admin\UserController@changePassword',
        'as' => 'admin.user.changePass'
    ]);
    Route::post('/user/change-password', [
        'uses' => '\PyroMans\Http\Controllers\Admin\UserController@postChangePassword'
    ]);
});