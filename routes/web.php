<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('logout', 'Admin\Auth\LoginController@logout');
Route::resource('notifications', 'NotificationController');
// Get Roles
Route::post('get-roles', 'Admin\Dashboard@get_roles')->name('get-roles');
// Generate Registration Link
Route::post('generate-registeration-link', 'Admin\Dashboard@generate_reg_link')->name('generate-registeration-link');
// Registration Routes...
Route::get('register/{auth_id}/{role_id}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register/{auth_id}/{role_id}', 'Auth\RegisterController@create')->name('register');
// Get Country Code in case of multiple countries
Route::post('get-country-code', 'HomeController@get_country_code')->name('get_country_code');


Route::group(['prefix' => 'admin-dashboard', 'middleware' => ['auth', 'adminAuth']], function() {

    //	Route::get('/create-permission', 'Admin\Dashboard@create_permission');
    Route::get('/', 'Admin\Dashboard@index')->name('admin-dashboard');
    // Notications on header view 5 mins each times
    Route::get('notifications', 'Admin\Dashboard@notification')->name('all-notification');
    Route::post('notifications/read', 'Admin\Dashboard@readAllNotification')->name('read-all-notification');
    // Notifications view all
    Route::get('notify', 'NotificationController@index')->name('notify');
    Route::get('notification', 'Admin\Dashboard@recieveNotification')->name('recieve-notification');
    Route::post('notification/read', 'Admin\Dashboard@readNotification')->name('read-notification');

	//Administrator
	Route::group( [ 'prefix' => 'administrator' ], function () {
		Route::get( '/my-profile', 'Admin\Administrator\Users@my_profile' )->name( "my-profile-admin" );
		Route::post( '/my-profile', 'Admin\Administrator\Users@update_profile' )->name( "update-profile-admin" );
		Route::get( '/change-password', 'Admin\Administrator\Users@change_password' )->name( "change-password-admin" );
		Route::post( '/change-password', 'Admin\Administrator\Users@update_password' )->name( "update-password-admin" );

		    //  Personal Profile
        Route::post( '/update-cc-info', 'Admin\Administrator\Users@change_cc_info' )->name( "update-cc-info" );
        Route::post( '/update-dc-info', 'Admin\Administrator\Users@change_dc_info' )->name( "update-dc-info" );
        Route::post( '/update-bank-info', 'Admin\Administrator\Users@change_bank_info' )->name( "update-bank-info" );


		//Users Roles
		Route::group( [ 'prefix' => 'roles' ], function () {
			Route::get( '/', 'Admin\Administrator\Roles@index' )->name( "role-list" );
			Route::post( '/', 'Admin\Administrator\Roles@data_list' )->name( "role-get-list" );
			Route::delete( '/', 'Admin\Administrator\Roles@delete' )->name( "role-delete" );
			Route::get( '/add', 'Admin\Administrator\Roles@add' )->name( "role-add" );
			Route::post( '/add', 'Admin\Administrator\Roles@save' )->name( "role-save" );
			Route::get( '/edit/{id}', 'Admin\Administrator\Roles@edit' )->where( [ 'id' => '[0-9]+' ] )->name( "role-edit" );
			Route::post( '/edit/{id}', 'Admin\Administrator\Roles@update' )->where( [ 'id' => '[0-9]+' ] )->name( "role-update" );
		} );
		//Users
		Route::group( [ 'prefix' => 'users' ], function () {
			Route::get( '/', 'Admin\Administrator\Users@index' )->name( "user-list" );
			Route::post( '/', 'Admin\Administrator\Users@data_list' )->name( "user-get-list" );
			Route::delete( '/', 'Admin\Administrator\Users@delete' )->name( "user-delete" );
			Route::get( '/add', 'Admin\Administrator\Users@add' )->name( "user-add" );
			Route::post( '/add', 'Admin\Administrator\Users@save' )->name( "user-save" );
			Route::post( '/update-status', 'Admin\Administrator\Users@update_status' )->name( "user-update-status" );
			Route::get( '/edit/{id}', 'Admin\Administrator\Users@edit' )->where( [ 'id' => '[0-9]+' ] )->name( "user-edit" );
			Route::post( '/edit/{id}', 'Admin\Administrator\Users@update' )->where( [ 'id' => '[0-9]+' ] )->name( "user-update" );
		});
        //Records
        Route::group( [ 'prefix' => 'records' ], function () {

            Route::get( '/', 'Admin\Administrator\Records@index' )->name( "record-list" );
            Route::post( '/', 'Admin\Administrator\Records@data_list' )->name( "record-get-list" );
            Route::delete( '/', 'Admin\Administrator\Records@delete' )->name( "record-delete" );
            Route::get('import', 'Admin\Administrator\Records@importExportView')->name('imp-view');
            Route::post('import', 'Admin\Administrator\Records@import')->name('import1');
            Route::get('download_eg', 'Admin\Administrator\Records@download_eg')->name('download-eg');
        });
	});
    //Personal and Business Workbench
    Route::group( [ 'prefix' => 'workbench','middleware' => ['cors'] ], function () {
        Route::group( [ 'prefix' => 'personal' ], function () {
            Route::get( '/', 'Admin\Administrator\Workbench@personal' )->name( "personal-form" );
            Route::post( '/save', 'Admin\Administrator\Workbench@personalSave' )->name( "personal-save" );
            Route::get( '/result', 'Admin\Administrator\Workbench@personalResult' )->name( "personal-result" );
        });
        Route::group( [ 'prefix' => 'business' ], function () {
            Route::get( '/', 'Admin\Administrator\Workbench@business' )->name("business-form");
            Route::post( '/save', 'Admin\Administrator\Workbench@businessSave' )->name( "business-save" );
            Route::get( '/result', 'Admin\Administrator\Workbench@businessResult' )->name( "business-result" );
        });
    });
    //Claim Search
    Route::group( [ 'prefix' => 'claim' ], function () {
        Route::get( '/', 'Admin\Administrator\Workbench@claim' )->name("claim-form");
        Route::post( '/save', 'Admin\Administrator\Workbench@claimSave' )->name( "claim-save" );
        Route::group( [ 'prefix' => 'prior' ], function () {
            Route::get( '/', 'Admin\Administrator\Workbench@claim' )->name("prior-claim-search");
            Route::post( '/save', 'Admin\Administrator\Workbench@claimSave' )->name( "prior-claim-save" );
        });
    });
    //Prior Search
    Route::group( [ 'prefix' => 'prior' ], function () {
        Route::get( '/', 'Admin\Administrator\Users@index' )->name("prior-search");
    });
    //Configuration
    Route::group( [ 'prefix' => 'configuration' ], function () {
        //Countries
        Route::group( [ 'prefix' => 'countries' ], function () {
            Route::get( '/', 'Admin\Administrator\Countries@index' )->name( "countries-list" );
            Route::post( '/', 'Admin\Administrator\Countries@data_list' )->name( "countries-get-list" );
            Route::delete( '/', 'Admin\Administrator\Countries@delete' )->name( "countries-delete" );
            Route::get( '/add', 'Admin\Administrator\Countries@add' )->name( "countries-add" );
            Route::post( '/add', 'Admin\Administrator\Countries@save' )->name( "countries-save" );
            Route::get( '/edit/{id}', 'Admin\Administrator\Countries@edit' )->where( [ 'id' => '[0-9]+' ] )->name( "countries-edit" );
            Route::post( '/edit/{id}', 'Admin\Administrator\Countries@update' )->where( [ 'id' => '[0-9]+' ] )->name( "countries-update" );
        });
        //States
        Route::group( [ 'prefix' => 'state' ], function () {
            Route::get( '/', 'Admin\Administrator\States@index' )->name( "state-list" );
            Route::post( '/', 'Admin\Administrator\States@data_list' )->name( "state-get-list" );
            Route::delete( '/', 'Admin\Administrator\States@delete' )->name( "state-delete" );
            Route::get( '/add', 'Admin\Administrator\States@add' )->name( "state-add" );
            Route::post( '/add', 'Admin\Administrator\States@save' )->name( "state-save" );
            Route::post( '/update-status', 'Admin\Administrator\States@update_status' )->name( "state-update-status" );
            Route::get( '/edit/{id}', 'Admin\Administrator\States@edit' )->where( [ 'id' => '[0-9]+' ] )->name( "state-edit" );
            Route::post( '/edit/{id}', 'Admin\Administrator\States@update' )->where( [ 'id' => '[0-9]+' ] )->name( "state-update" );
        });
        //Cities
        Route::group( [ 'prefix' => 'city' ], function () {
            Route::get( '/', 'Admin\Administrator\Cities@index' )->name( "city-list" );
            Route::post( '/', 'Admin\Administrator\Cities@data_list' )->name( "city-get-list" );
            Route::delete( '/', 'Admin\Administrator\Cities@delete' )->name( "city-delete" );
            Route::get( '/add', 'Admin\Administrator\Cities@add' )->name( "city-add" );
            Route::post( '/add', 'Admin\Administrator\Cities@save' )->name( "city-save" );
            Route::post( '/update-status', 'Admin\Administrator\Cities@update_status' )->name( "city-update-status" );
            Route::get( '/edit/{id}', 'Admin\Administrator\Cities@edit' )->where( [ 'id' => '[0-9]+' ] )->name( "city-edit" );
            Route::post( '/edit/{id}', 'Admin\Administrator\Cities@update' )->where( [ 'id' => '[0-9]+' ] )->name( "city-update" );
        });
    });
    //Email
    Route::get( 'email/', 'Admin\Administrator\Email@index' )->name( "email-send" );
    Route::post( 'email/', 'Admin\Administrator\Email@save' )->name( "email-save" );
    Route::get( 'bulk-email/', 'Admin\Administrator\Email@bulkIndex' )->name( "mass-email-send" );
    Route::post( 'bulk-email/', 'Admin\Administrator\Email@bulkSave' )->name( "mass-email-send" );
});
