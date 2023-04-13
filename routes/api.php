<?php


use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['namespace' => 'Api'], function() {

	// Home Page
	Route::get('home-page', 'HomeController@index');

	// Auth
	
	Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function() {
		
		//	Register
		
		Route::get('register', 'RegisterController@index');

		Route::post('register', 'RegisterController@register');

		// Signin

		Route::post('signin', 'SigninController@signin');

		// Logout

		Route::get('logout', 'LogoutController@logout')->middleware('auth.api');

		// Refresh Token

		Route::get('refresh', 'RefreshTokenController@refresh');


	});

	// User Tools

	Route::group(['namespace' => 'User', 'prefix' => 'user', 'middleware' => 'auth.api'], function() {

		// Test

		Route::get('test', function(){
			return response()->json([
				'test' => 'success'
			]);
		});

		// User Profile

		Route::get('profile', 'ProfileController@index');

		Route::put('profile/update', 'ProfileController@update');

		// User Messages

		Route::get('messages', 'MessagesController@index');

		Route::get('messages/more/{last_message_id}', 'MessagesController@more');

		Route::put('message/{message_id}', 'MessagesController@message');

		Route::delete('message/{message_id}', 'MessagesController@delete');
		
		// User Notificatios
		Route::get('notifications/push', 'NotificationsController@push');

		Route::put('notifications/push/{switch}', 'NotificationsController@toggle_push');

		Route::get('notifications', 'NotificationsController@index');

		Route::get('notifications/more/{last_notification_id}', 'NotificationsController@more');

		Route::put('notification/read/{notification_id}', 'NotificationsController@read');
		
		// push_id

		Route::put('push_id', 'NotificationsController@push_id')->middleware('auth.api');

		// User Events

		Route::get('events', 'EventsController@index');
		
		Route::put('events/unregister/{event_attendence_id}', 'EventsController@unregister');

		// User Submissions

		Route::get('submissions', 'SubmissionsController@index');

	});

	// Events
	Route::group(['namespace' => 'Event', 'prefix' => 'event'], function() {

		// Index
		Route::get('index/{type}', 'IndexsController@index');

		// Conferences
		Route::group(['namespace' => 'Conference', 'prefix' => 'conference'], function() {

			// Index
			Route::get('/','ConferencesController@index');

			// Details
			Route::get('{event_id}', 'ConferencesController@show');

			// Register
			Route::post('/register/{event_id}', 'ConferencesController@register')->middleware('auth.api');

			// Unegister
			Route::post('/unregister/{event_id}', 'ConferencesController@unregister')->middleware('auth.api');

		});

		// Workshops
		Route::group(['namespace' => 'Workshop', 'prefix' => 'workshop'], function() {

			// Index
			Route::get('/','WorkshopsController@index');

			// Details
			Route::get('{event_id}', 'WorkshopsController@show');

			// Register
			Route::post('/register/{event_id}', 'WorkshopsController@register')->middleware('auth.api');

			// Unegister
			Route::post('/unregister/{event_id}', 'WorkshopsController@unregister')->middleware('auth.api');

		});

		// Studyabroads
		Route::group(['namespace' => 'Studyabroad', 'prefix' => 'studyabroad'], function() {

			// Index
			Route::get('/','StudyabroadsController@index');

			// Details
			Route::get('{event_id}', 'StudyabroadsController@show');

			// Register
			Route::post('/register/{event_id}', 'StudyabroadsController@register')->middleware('auth.api');

			// Unegister
			Route::post('/unregister/{event_id}', 'StudyabroadsController@unregister')->middleware('auth.api');

		});

		// Bookseries
		Route::group(['namespace' => 'Bookseries', 'prefix' => 'bookseries'], function() {

			// Index
			Route::get('/', 'BookseriesController@index');

			// Details
			Route::get('{event_id}', 'BookseriesController@show');

		});

	});


	// Pages
	Route::group(['namespace' => 'Page', 'prefix' => 'page'], function() {

		// get page
		Route::get('/{page}','PagesController@page');

		// get SC first 10 A-Z
		Route::get('/get/sc','ScController@index');

		// get More 10 Sc A-Z
		Route::get('/get/sc/{slug}','ScController@profile');

	});


    // Contact Us
    Route::post('contact-us','ContactUsController@contact_us');


});
