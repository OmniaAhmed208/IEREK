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

        

Route::group(array('middleware' => 'forceSSL'), function() {

    Route::get('refresh-csrf', function(){
        return csrf_token();
    });
    




    Route::get('token', 'HomeController@test');

    Route::post('subscribe','NewsletterController@subscribe');

    Route::get('/test/{id}', 'MailController@welcome');

    Route::get('get/{element}', 'GetController@element');

    Route::get('getCalendar/{year}/{month}', 'GetController@calendar');



        Route::get('helper', 'testcontroller@index');


    Route::get('/', 'HomeController@index');
    Route::get('host_conference', 'ConferencesController@hostConf');
    Route::post('host_conference/store', 'ConferencesController@store');
    Route::get('conference_proceedings','HomeController@conference_proceedings');
    Route::get('projects_managemnet','HomeController@projects_managemnet');
    Route::get('scientists_forum','HomeController@scientists_forum');


    Route::get('staffs', 'StaffsController@listAll');
    Route::post('staffs/create', 'StaffsController@create');
    Route::post('staffs/edit', 'StaffsController@edit');
    Route::post('staffs/staffs/save', 'StaffsController@Save');

    Route::get('currencies', 'CurrenciesController@listAll');
    Route::post('currencies/create', 'CurrenciesController@create');
    Route::post('currencies/edit', 'CurrenciesController@edit');
    Route::post('currencies/currencies/save', 'CurrenciesController@Save');

    Route::get('remember','HomeController@remember');
    Route::post('logout', 'HomeController@logout');
   Route::get('conferences', 'ConferencesController@index');
    Route::get('conferences/previous', 'ConferencesController@previous');
//    Route::get('conf-series', 'ConferencesController@advancedSeriesConf');
    Route::get('book-series', 'BookseriesController@index');
    Route::get('workshops', 'WorkshopsController@index');
    Route::get('study_abroad_categories/undergraduate-studies', 'HomeController@undergraduate_studies');
    Route::get('study_abroad_categories/postgraduate-studies', 'HomeController@postgraduate_studies');
    Route::post('study_abroad_categories/register','HomeController@studies_register');
    Route::get('study_abroad_categories', 'StudyabroadsController@index');
    Route::get('study_abroad/application_view/{event_id}/{category}/{sub_category}', 'StudyabroadsController@showApplication');
    Route::post('study_abroad/storeApplication', 'StudyabroadsController@storeApplication');
    Route::get('study_abroad', 'HomeController@study_abroad_intro');
    
    Route::get('events/{slug}', 'EventsController@show');
    Route::get('conference/register/{event_id}', 'EventsController@register');
    Route::get('unregister/{id}', 'EventsController@unregister')->middleware('user');
    Route::post('conference/get/payment', [
    	"middleware" 	=> "user",
    	"uses" 			=> "PaymentController@addpay",
    	"as" 			=> "changePositionConferenceTopics"
    ]);
    //sponsorship
    Route::get('sponsorship_rules/{event_id}','SponsorShipController@index')->middleware('user');
    Route::get('sponsorship_form/{event_id}','SponsorShipController@show')->middleware('user');
    Route::post('sponsor_store','SponsorShipController@store')->middleware('user');

    Route::get('billing','HomeController@billing')->middleware('user');
    Route::get('/event/{slug}/postpone', 'EventsController@postpone')->middleware('user');
    Route::get('file/{type}/{filename}', 'FileController@getFile')->where('filename', '^[^/]+$')->middleware('user');
    //Payment
    Route::get('payment/{slug}', 'PaymentController@index');
    Route::get('payment/check-promo/{promo}/{eventId}', 'PaymentController@checkPromoCode');

    //Payment
    Route::get('custom/payment/{slug}/{amount}', 'PaymentController@custom')->middleware('user');

    //Payment
    Route::get('mobile/payment/{slug}', 'PaymentController@mobile');

    //MyEvents
    Route::get('myevents', 'AbstractController@myevents')->middleware('user');

    //Profile
    Route::get('profile', 'ProfileController@show')->middleware('user');
    Route::post('profile/update', 'ProfileController@update')->middleware('user');

    //Messages
    Route::get('messages', 'MessagesController@show')->middleware('user');
    Route::get('messages/body/{id}', 'MessagesController@body')->middleware('user');
    Route::get('messages/delete/{id}', 'MessagesController@delete')->middleware('user');

    //Notifications
    Route::get('notifications', 'MessagesController@showN')->middleware('user');
    Route::get('notifications/body/{id}', 'MessagesController@bodyN')->middleware('user');
    Route::get('notifications/delete/{id}', 'MessagesController@deleteN')->middleware('user');



    //Abstract & Paper
    Route::get('myabstracts', 'AbstractController@myabstracts')->middleware('user');
    Route::get('abstract/{slug}', 'AbstractController@index')->middleware('user');
    Route::get('abstract/status/{id}', 'AbstractController@status')->middleware('user');
    Route::post('abstract/submit', 'AbstractController@submit')->middleware('user');
    Route::get('fullpaper/status/{id}', 'FullPaperController@status')->middleware('user');
    Route::post('fullpaper/add_coauthor', 'FullPaperController@add_coauthor')->middleware('user');
    Route::post('fullpaper/remove_coauthor/{id}', 'FullPaperController@remove_coauthor')->middleware('user');
    Route::get('upload/fullpaper/{id}', 'FullPaperController@ufp')->middleware('user');
    Route::post('fullpaper/submit/{id}', 'FullPaperController@submit')->middleware('user');
    Route::get('comments/{event_id}/{filename}', 'DownloadsController@comment')->where('filename', '^[^/]+$');
    Route::post('comment/submit/{id}','FullPaperController@comment')->middleware('user');


    //About Us
    Route::get('about-us','HomeController@about_us');
    
    //IEREK’s Additional Services
    Route::get('Additional-Services','HomeController@Additional-Services');

    //ticket
    Route::get('ticket/{id?}','TicketController@index');
   
    //Contact Us
    Route::get('contact-us','HomeController@contact_us');
    Route::post('contact-us/send', 'MailController@contact');

    //IEREK Press
    Route::get('ierek-press','HomeController@ierek_press');

    //Terms & Conditions
    Route::get('terms', 'HomeController@terms');
    Route::get('terms-conditions', 'HomeController@terms');

    //FAQ
    Route::get('faq', 'HomeController@faq');

    //Scientific Committee
    Route::get('scientific-committee','HomeController@sc');
    Route::get('comittee/{slug}','HomeController@sc_profile');

    //Careers
    Route::get('careers', 'HomeController@careers');

    //Suggest
    Route::get('suggest', 'HomeController@suggest');

    //FAQ
    Route::get('feedback', 'HomeController@feedback');

    //Calendar
    Route::get('calendar', 'HomeController@calendar');

    //Translation Service Mew
    Route::get('translation-service-new', 'HomeController@translation_service');
    
        //additionalservices

    Route::get('additionalservices', 'additionalservicesController@index');


    //Payment Routes
    Route::get('pay', 'PaymentController@view');
    Route::post('pay', 'PaymentController@pay');
    Route::post('cpay', 'PaymentController@cPay');
    Route::post('payBank', 'PaymentController@payBank');
    // Route::post('pay', 'HomeController@test');


    //Mail Routes & Verification
    Route::get('mail/verify/{user_id}', 'MailController@welcome');
    Route::get('mail/sc/{user_id}/{pw}', 'MailController@welcome_sc');
    Route::get('mail/re-verify/{user_id}', 'MailController@reverify');
    Route::get('verify/{vcode}', 'ProfileController@verify');
    //Requests
    //Route::get('/speaker/{id}','RequestController@show_speaker')->middleware('user');
    //Route::put('/speaker/store/{id}','RequestController@store_speaker')->middleware('user');

    //Route::get('/sponsor/{id}','RequestController@show_sponsor')->middleware('user');
    //Route::put('/sponsor/store/{id}','RequestController@store_sponsor')->middleware('user');

    //Route::get('/media-coverage/{id}','RequestController@show_media_coverage')->middleware('user');
    //Route::post('/media-coverage/store/{id}','RequestController@store_media_coverage')->middleware('user');


    Route::get('/speaker/{id}','RequestController@show_speaker');
    Route::post('/speaker/store/{id}','RequestController@store_speaker');
    
    Route::get('/add-speaker/{id}','speakerController@show');
    
    Route::get('/sponsor/{id}','RequestController@show_sponsor');
    Route::post('/sponsor/store/{id}','RequestController@store_sponsor');

    Route::get('/media-coverage/{id}','RequestController@show_media_coverage');
    Route::post('/media-coverage/store/{id}','RequestController@store_media_coverage');

    //Route::post('conference/media_coverages/store/{event_id}', 'ConferenceMediaCoveragesController@store');

    Route::auth();

    Route::get('home', function(){
        return redirect('/#login');
    });
    // Authinication Routs
    Route::get('register', function(){
        return redirect('/#register');
    });
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('login', function(){
        return redirect('/#login');
    });
    Route::post('login', 'Auth\LogController@login');

    //Abstract Revision
    Route::get('revision/abstract','RevisionController@abstracts')->middleware('user');
    Route::get('revision/abstract/{id}/reject/{reason}','RevisionController@busy_abstract')->middleware('user');
    Route::get('revision/abstract/{id}/reject','RevisionController@reject_abstract')->middleware('user');
    Route::get('revision/abstract/{id}/accept','RevisionController@accept_abstract')->middleware('user');
    Route::get('revision/abstract/{id}/view', 'RevisionController@abstractx')->middleware('user');

    //Paper Revision
    Route::get('revision/paper','RevisionController@papers')->middleware('user');
    Route::get('revision/paper/{id}/busy','RevisionController@busy_paper')->middleware('user');
    Route::get('revision/paper/{id}/reject','RevisionController@reject_paper')->middleware('user');
    Route::get('revision/paper/{id}/accept','RevisionController@accept_paper')->middleware('user');
    Route::get('revision/paper/{id}/view', 'RevisionController@paper')->middleware('user');
    Route::get('revision/paper/{paper_id}/{reviewer_id}/{rev}/remove', 'RevisionController@remove_paper_reviewer')->middleware('user');
    Route::get('revision/paper/result/{paper_id}/{rev}','RevisionController@paper_result')->middleware('user');
    Route::post('revision/paper/{id}','RevisionController@paper_status')->middleware('user');

    //Compose Msg
    Route::get('admin/message/compose', 'MailController@compose');
    	    		///////////////////////////////////
    	    		//////////// ADMIN ROUTS //////////
    	    		///////////////////////////////////
    Route::get('mail_send','MailController@send');
    Route::get('mail_send_hosting','MailController@sendHostConferenceMail');
    Route::group(['namespace' => 'Admin'], function()
    {    

        //Push Notifications
        Route::get('push', 'NotificationsController@send_notification')->middleware('admin');


        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::get('admin', 'HomeController@index')->middleware('admin');

        Route::group(['prefix' => 'admin'], function () {

        //Admin Logs
        Route::get('logs','HomeController@logs')->middleware('super');
        //hostConference
        Route::get('hostConference','HostConferenceController@index');
        Route::get('hostConference/search','HostConferenceController@search');
        Route::get('hostConference/show/{id}','HostConferenceController@show');
        //sudyabroad applications
        Route::get('studyAbroadApplications','StudyAbroadApplications@index');
        Route::get('studyAbroadApplications/search','StudyAbroadApplications@search');
        Route::get('studyAbroadApplications/show/{id}','StudyAbroadApplications@show');
        //Admin Invoices
        Route::get('invoices','InovicesController@index')->middleware('accountant');
        Route::get('invoices/create','InovicesController@create')->middleware('accountant');
        Route::post('invoices/save','InovicesController@save')->middleware('accountant');
        Route::get('invoices/autocomplete', 'InovicesController@autocomplete')->middleware('accountant');
        Route::post('invoices/approveOrdecline', 'InovicesController@approveOrdecline')->middleware('accountant');
        Route::get('invoices/edit/{id}', 'InovicesController@edit')->middleware('accountant');
        Route::post('invoices/update', 'InovicesController@update')->middleware('accountant');
        Route::get('searchInvoices', 'InovicesController@searchInvoices')->middleware('accountant');
        Route::get('invoices/show/{id}', 'InovicesController@show')->middleware('user');
        Route::post('invoices/fees', 'InovicesController@fees')->middleware('accountant');


        // send_ticket
            Route::get('send_email/{id}','SendTicketfrombutton@index')->middleware('accountant');



            //Messages (Admins)
        Route::get('messages', 'MessagesController@show')->middleware('super');
        Route::get('messages/{id}', 'MessagesController@read')->middleware('super');
        Route::get('messages/body/{id}', 'MessagesController@body')->middleware('super');
        Route::get('messages/delete/{id}', 'MessagesController@delete')->middleware('super');
        
        //Notifications (Admins)
        Route::get('notifications', 'MessagesController@showN')->middleware('super');
        Route::get('notifications/body/{id}', 'MessagesController@bodyN')->middleware('super');
        Route::get('notifications/delete/{id}', 'MessagesController@deleteN')->middleware('super');


        Route::get('get/{element}', 'GetController@element')->middleware('admin');
        
         Route::get('back-users', 'UsersController@index')->middleware('super');

        //Users Admins & Sc
        Route::get('users/{type}', 'UsersManageController@index')->middleware('super');
        Route::get('users/{type}/make', 'UsersManageController@make')->middleware('super');
        Route::post('users/{type}/make', 'UsersManageController@addto')->middleware('super');
        Route::post('users/remove/{id}', 'UsersManageController@remove')->middleware('super');

        //Users Regular
        Route::get('searchUsers', 'RegularUsersController@searchUsers')->middleware('super');
        Route::get('all-users', 'RegularUsersController@index')->middleware('super');
        Route::get('all-users/profile/{id}', 'RegularUsersController@profile')->middleware('super');
        Route::get('all-users/create','RegularUsersController@create')->middleware('super');
        Route::post('all-users/create','RegularUsersController@store')->middleware('super');
        Route::post('all-users/update','RegularUsersController@update')->middleware('super');
        Route::get('all-users/hide/{id}','RegularUsersController@hide')->middleware('super');
        Route::get('all-users/unhide/{id}','RegularUsersController@unhide')->middleware('super');


        //Static Pages
        Route::get('pages/static/{type}', 'StaticPagesController@page')->middleware('super');
        Route::post('pages/static/{id}', 'StaticPagesController@update')->middleware('super');

        // Message to user
        Route::get('message/{user_id}/{event_id}', 'MessagesController@compose')->middleware('super');

        Route::post('message/send','MessagesController@send')->middleware('super');
        Route::post('message/send_group','MessagesController@send_group')->middleware('super');


        // Mail Templates
        Route::get('mail','MailTemplatesController@index')->middleware('super');
        Route::post('mail','MailTemplatesController@update')->middleware('super');
        Route::get('mail/{id}','MailTemplatesController@edit')->middleware('super');

        //Notifications
        Route::post('notifications/read/{id}','NotificationsController@read')->middleware('super');


            // Controllers Within The "App\Http\Controllers\Admin\Payments" Namespace
            Route::group(['namespace' => 'Payments', 'middleware' => 'super'], function()
            {

                    ####################################################
                    ####################|||||||||#######################
                    ##################|||SECTION|||#####################
                    ##################|||PAYMENTS||#####################
                    #####################|||||||########################
                    ####################################################
                    Route::group(['prefix' => 'payments'], function () {

                        Route::get('/','PaymentsController@home');
                        Route::get('create', 'PaymentsController@create');
                        Route::post('create', 'PaymentsController@store');
                        Route::get('approve/{id}', 'PaymentsController@approve');
                        Route::get('decline/{id}', 'PaymentsController@decline');
                    
                    });
            });


    	    // Controllers Within The "App\Http\Controllers\Admin\Events" Namespace
    	    Route::group(['namespace' => 'Events'], function()
    	    {

    				####################################################
    				####################|||||||||#######################
    				##################|||SECTION|||#####################
    				###################|||EVENTS||######################
    				#####################|||||||########################
    				####################################################

    		    	Route::group(['prefix' => 'events'], function () {


    					Route::group(['prefix' => 'conference-details', 'middleware' => 'editor'], function () {
    						// Conference topics controller
    						Route::resource('topics', 'ConferenceTopicsController',
    							[   'except' => "index",
    								'names' =>
    									[
    								 		'show'		=>  'showConferenceTopics',

    								    	'create' 	=>	'createConferenceTopics',
    										'store'  	=>  'storeConferenceTopics',

    										'edit'    	=>  'editConferenceTopics',
    										'update'  	=>  'updateConferenceTopics',

    										'destroy'   =>	'deleteConferenceTopics'
    									]
    							]
    						);


    						Route::post('topics/changeposition', [
    							"uses" => "ConferenceTopicsController@changePosition",
    							"as" => "changePositionConferenceTopics"
    						]);

    						Route::get('topics/order/{event_id}', [
    							"uses" => "ConferenceTopicsController@order",
                                "as" => "orderConferenceTopics"
                            ]);

                    });
                    Route::get('duplicate/{slug}','ConferenceController@duplicate')->middleware('editor');
                        ///////////////////////////////////
                        ////// CONFERENCES ROUTS //////////
                        ///////////////////////////////////
                    Route::group(['middleware' => 'admin'], function()
                    {
                        Route::resource('conference', 'ConferenceController',
                            [   'except' => "show",
                                'names' =>
                                    [
                                         'index'         => 'indexConference',
                                         'create'        => 'createConference',
                                        'store'         => 'storeConference',
                                        'edit'          => 'editConference',
                                        'update'        => 'updateConference',
                                        'destroy'       => 'destroyConference',
                                    ]
                            ]);
                                
                    });


                        Route::post('conference/restore/{id}', 'ConferenceController@restore')->middleware('super');
                        Route::get('conference/filter/{deleted}', 'ConferenceController@filter')->middleware('editor');


                    Route::group(['middleware' => 'editor'], function()
                    {
                        Route::resource('conference/dates', 'ConferenceDatesController',
                            [
                                'names' =>
                                    [
                                        'edit'    =>   'editConferenceDates',
                                        'update'  =>   'updateConferenceDates'
                                    ]
                            ]
                        );
                    });

                        Route::group(['prefix' => 'studies-details', 'middleware' => 'editor'], function () {
                            // Studies topics controller
                            Route::resource('topics', 'StudiesTopicsController',
                                [   'except' => "index",
                                    'names' =>
                                        [
                                            'show'      =>  'showStudiesTopics',

                                            'create'    =>  'createStudiesTopics',
                                            'store'     =>  'storeStudiesTopics',

                                            'edit'      =>  'editStudiesTopics',
                                            'update'    =>  'updateStudiesTopics',

                                            'destroy'   =>  'deleteStudiesTopics'
                                        ]
                                ]
                            );


                            Route::post('topics/changeposition', [
                                "uses" => "StudiesTopicsController@changePosition",
                                "as" => "changePositionStudiesTopics"
                            ]);

                            Route::get('topics/order/{event_id}', [
                                "uses" => "StudiesTopicsController@order",
                                "as" => "orderStudiesTopics"
                            ]);

                    });
                    Route::get('duplicate/{slug}','StudiesController@duplicate')->middleware('super');
                        ///////////////////////////////////
                        ////// CONFERENCES ROUTS //////////
                        ///////////////////////////////////
                    
                    Route::group(['middleware' => 'admin'], function()
                    {

                        Route::resource('studies', 'StudiesController',
                            [   'except' => "show",
                                'names' =>
                                    [
                                        'index'         => 'indexStudies',
                                        'create'        => 'createStudies',
                                        'store'         => 'storeStudies',
                                        'edit'          => 'editStudies',
                                        'update'        => 'updateStudies',
                                        'destroy'       => 'destroyStudies',
                                    ]
                            ]
                        );
                        Route::post('studies/restore/{id}', 'StudiesController@restore');
                        Route::get('studies/filter/{deleted}', 'StudiesController@filter');
                    });

                    Route::group(['middleware' => 'editor'], function()
                    {

                        Route::resource('studies/dates', 'StudiesDatesController',
                            [
                                'names' =>
                                    [
                                        'edit'    =>   'editStudiesDates',
                                        'update'  =>   'updateStudiesDates'
                                    ]
                            ]
                        );
                    });
                        Route::group(['middleware' => 'editor'], function()
                    {
    						Route::resource('section', 'SectionController',
    							[   'except' => "index",
    								'names' =>
    									[
    								 		'show'		=>  'showSection',

    										'create' 	=>	'createSection',
    										'store'  	=>  'storeSection',

    										'edit'    	=>  'editSection',
    										'update'  	=>  'updateSection',

    										'destroy'   =>	'deleteSection'
    									]
    							]
    						);
                    


    						Route::post('section/changeposition', [
    							"uses" => "SectionController@changePosition",
    							"as" => "changePositionSection"
    						]);

    						Route::get('section/order/{event_id}', [
    							"uses" => "SectionController@order",
    							"as" => "orderSection"
    						]);
                                                
                                    });



    				    Route::group(['namespace' => 'Settings', 'middleware' => 'super'], function()
    				    {

    							####################################################
    							####################|||||||||#######################
    							##################|||SECTION|||#####################
    							##################|||SETTINGS||#####################
    							#####################|||||||########################
    							####################################################

    					    	Route::group(['prefix' => 'settings'], function () {



    			    				Route::resource('important_dates', 'ImportantDatesController',
    			    					[
                                            'names' =>
                                                [
                                                    'update' => 'updateImportantDatesSettings'
                                                ]
                                        ]
                                    );


    			    			});


    			    	});
    		    		///////////////////////////////////
    		    		//////// WORKSHOPS ROUTS //////////
    		    		///////////////////////////////////

                          Route::group(['middleware' => 'admin'], function()
                            {
    					Route::resource('workshop', 'WorkshopController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexWorkshop',
                                        'create' 		=> 'createWorkshop',
                                        'store'			=> 'storeWorkshop',
                                        'edit'   		=> 'editWorkshop',
                                        'update'		=> 'updateWorkshop',
                                        'destroy'		=> 'destroyWorkshop',
                                    ]
                            ]
                        );
                            });

                        Route::post('workshop/restore/{id}', 'WorkshopController@restore')->middleware('super');
                        Route::get('workshop/filter/{deleted}', 'WorkshopController@filter')->middleware('admin');

                        Route::post('bookseries/restore/{id}', 'BookseriesController@restore')->middleware('super');
                        Route::get('bookseries/filter/{deleted}', 'BookseriesController@filter')->middleware('admin');



    		    		///////////////////////////////////
    		    		////// STUDY ABROAD ROUTS /////////
    		    		///////////////////////////////////
                        Route::group(['middleware' => 'admin'], function()
                            {

    			    	Route::resource('studyabroad', 'StudyabroadController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexStudyabroad',
                                        'create' 		=> 'createStudyabroad',
                                        'store'			=> 'storeStudyabroad',
                                        'edit'   		=> 'editStudyabroad',
                                        'update'		=> 'updateStudyabroad',
                                        'destroy'		=> 'destroyStudyabroad',
                                    ]
                            ]
                        );
                            });

                        Route::post('studyabroad/restore/{id}', 'StudyabroadController@restore')->middleware('super');
                        Route::get('studyabroad/filter/{deleted}', 'StudyabroadController@filter')->middleware('admin');


                        ///////////////////////////////////
                        //////// BOOKSERIES ROUTS //////////
                        ///////////////////////////////////

Route::group(['middleware' => 'admin'], function()
                            {
                        Route::resource('bookseries', 'BookseriesController',
                            [   'except' => "show",
                                'names' =>
                                    [
                                        'index'         => 'indexBookseries',
                                        'create'        => 'createBookseries',
                                        'store'         => 'storeBookseries',
                                        'edit'          => 'editBookseries',
                                        'update'        => 'updateBookseries',
                                        'destroy'       => 'destroyBookseries',
                                    ]
                            ]
                        );
                            });

                        Route::post('workshop/restore/{id}', 'WorkshopController@restore')->middleware('super');
                        Route::get('workshop/filter/{deleted}', 'WorkshopController@filter')->middleware('admin');

                                    // Conference Expences controller
                        Route::group(['middleware' => 'accountant'], function()
                            {
                                    Route::resource('conference/expences', 'ConferenceExpencesController',
                                        [  
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceExpences'
                                                ]
                                        ]
                                    );
                                    
                        Route::get('conference/expences/create/{event_id}', 'ConferenceExpencesController@create');
                        Route::post('conference/expences/store', 'ConferenceExpencesController@store');
                            });

                                    // Conference Attendance
                                    Route::get('conference/registeredEmails/{event_id}', 'ConferenceAttendanceController@registerdEmails');
                                    Route::get('conference/attendance/{event_id}', 'ConferenceAttendanceController@index')->middleware('admin');
                                    Route::get('conference/attendance/{event_id}/filter/{deleted}', 'ConferenceAttendanceController@filter')->middleware('admin');
                                    Route::post('conference/attendance/export', [
                                        "uses"          => "ConferenceAttendanceController@export",
                                        "as"            => "ConAtteExport"
                                    ])->middleware('admin');

                                    // Workshop Attendance
                                    Route::get('workshop/attendance/{event_id}', 'WorkshopAttendanceController@index')->middleware('admin');
                                    Route::get('workshop/attendance/{event_id}/filter/{deleted}', 'WorkshopAttendanceController@filter')->middleware('admin');
                                    Route::post('workshop/attendance/export', [
                                        "uses"          => "WorkshopAttendanceController@export",
                                        "as"            => "WorkAtteExport"
                                    ])->middleware('admin');

                                    // Study Attendance
                                    Route::get('studyabroad/attendance/{event_id}', 'StudyabroadAttendanceController@index')->middleware('admin');
                                    Route::get('studyabroad/attendance/{event_id}/filter/{deleted}', 'StudyabroadAttendanceController@filter')->middleware('admin');
                                    Route::post('studyabroad/attendance/export', [
                                        "uses"          => "StudyabroadAttendanceController@export",
                                        "as"            => "StudyAtteExport"
                                    ])->middleware('admin');

                                    // Studies Attendance
                                    Route::get('studies/attendance/{event_id}', 'StudiesAttendanceController@index')->middleware('admin');
                                    Route::get('studies/attendance/{event_id}/filter/{deleted}', 'StudiesAttendanceController@filter')->middleware('admin');
                                    Route::post('studies/attendance/export', [
                                        "uses"          => "StudiesAttendanceController@export",
                                        "as"            => "ConAtteExport"
                                    ])->middleware('admin');

                                    Route::get('studies/application/{event_id}/{user_id}','StudiesAttendanceController@application')->middleware('admin');

                                    // Conference Submission
                                    Route::get('conference/submission/{event_id}', 'ConferenceSubmissionController@index')->middleware('admin');

                                    //Abstract

                                    Route::get('conference/abstract/{id}', 'ConferenceSubmissionController@abstractx')->middleware('admin');
                                    Route::post('conference/abstract/sc', 'ConferenceSubmissionController@abstract_reviewer')->middleware('admin');
                                    Route::post('conference/abstract_as/sc', 'ConferenceSubmissionController@abstract_accept_as')->middleware('admin');
                                    Route::get('conference/abstract/approve/{id}', 'ConferenceSubmissionController@abstract_approve')->middleware('editor');
                                    Route::get('conference/abstract/reject/{id}', 'ConferenceSubmissionController@abstract_reject')->middleware('editor');


                                    //Full Paper
                                    Route::get('conference/paper/{id}', 'ConferenceSubmissionController@paper')->middleware('admin');
                                    Route::get('conference/review/{id}', 'ConferenceSubmissionController@review')->middleware('admin');
                                    Route::post('conference/paper/{paper_id}/assign', 'ConferenceSubmissionController@add_reviewer')->middleware('admin');
                                    Route::get('conference/paper/{paper_id}/{reviewer_id}/{rev}/remove', 'ConferenceSubmissionController@remove_paper_reviewer')->middleware('admin');
                                    Route::get('conference/paper/approve/{id}', 'ConferenceSubmissionController@paper_approve')->middleware('admin');
                                    Route::post('conference/reviewer_edition/{id}', 'ConferenceSubmissionController@reviewer_edition')->middleware('admin');
                                    Route::post('conference/final_edition/{id}', 'ConferenceSubmissionController@final_edition')->middleware('admin');
                                    Route::get('conference/paper/reject/{id}', 'ConferenceSubmissionController@paper_reject')->middleware('admin');
                                    Route::post('conference/paper/paper_status/{id}', 'ConferenceSubmissionController@paper_status')->middleware('admin');

                                    // Migrations
                                    Route::get('conference/migration/{event_id}', 'MigrationController@index')->middleware('admin');

                                    Route::post('conference/migration/_abstract', 'MigrationController@_abstract')->middleware('admin');
                                    Route::post('conference/migration/paper', 'MigrationController@paper')->middleware('admin');
                                    Route::post('conference/migration/register', 'MigrationController@register')->middleware('admin');

                                    
                                    Route::group(['middleware' => 'editor'], function()
                            {
    								// Conference Widgets controller
                                    Route::resource('conference/widgets', 'ConferenceWidgetsController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceWidgets',

                                                    'edit'    =>   'editConferenceWidgets',
                                                    'update'  =>   'updateConferenceWidgets',

                                                    'destroy'   => 'deleteConferenceWidgets'
                                                ]
                                        ]
                                    );
                            

                                    Route::post('conference/fees/restore/{id}', 'ConferenceFeesController@restore');
                                    Route::get('conference/fees/create/{event_id}', 'ConferenceFeesController@create');
                                    Route::get('conference/fees/{event_id}/filter/{deleted}', 'ConferenceFeesController@filter');
                                    Route::post('conference/fees/store/{event_id}', 'ConferenceFeesController@store');

                                    //widgets
                                    Route::post('conference/widgets/restore/{id}', 'ConferenceWidgetsController@restore');
                                    Route::get('conference/widgets/create/{event_id}', 'ConferenceWidgetsController@create');
                                    Route::get('conference/widgets/{event_id}/filter/{deleted}', 'ConferenceWidgetsController@filter');
                                    Route::post('conference/widgets/store/{event_id}', 'ConferenceWidgetsController@store');
                                    
                            });
                            
                            Route::group(['middleware' => 'editor'], function()
                            {
    								// Conference Widgets controller
                                    Route::resource('conference/fees', 'ConferenceFeesController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceFees',

                                                    'edit'    =>   'editConferenceFees',
                                                    'update'  =>   'updateConferenceFees',

                                                    'destroy'   => 'deleteConferenceFees'
                                                ]
                                        ]
                                    );
                            

                            });

                            Route::group(['middleware' => 'editor'], function()
                            {
                                    // Studies Widgets controller
                                    Route::resource('studies/widgets', 'StudiesWidgetsController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudiesWidgets',

                                                    'edit'    =>   'editStudiesWidgets',
                                                    'update'  =>   'updateStudiesWidgets',

                                                    'destroy'   => 'deleteStudiesWidgets'
                                                ]
                                        ]
                                    );
  
                                    // Studies Fees controller
                                    Route::resource('studies/fees', 'StudiesFeesController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudiesFees',

                                                    'edit'    =>   'editStudiesFees',
                                                    'update'  =>   'updateStudiesFees',

                                                    'destroy'   => 'deleteStudiesFees'
                                                ]
                                        ]
                                    );

                                    Route::post('studies/fees/restore/{id}', 'StudiesFeesController@restore');
                                    Route::get('studies/fees/create/{event_id}', 'StudiesFeesController@create');
                                    Route::get('studies/fees/{event_id}/filter/{deleted}', 'StudiesFeesController@filter');
                                    Route::post('studies/fees/store/{event_id}', 'StudiesFeesController@store');

                                    //widgets
                                    Route::post('studies/widgets/restore/{id}', 'StudiesWidgetsController@restore');
                                    Route::get('studies/widgets/create/{event_id}', 'StudiesWidgetsController@create');
                                    Route::get('studies/widgets/{event_id}/filter/{deleted}', 'StudiesWidgetsController@filter');
                                    Route::post('studies/widgets/store/{event_id}', 'StudiesWidgetsController@store');

                                    //Categories
                                    Route::post('studyabroad/cateories/restore/{id}', 'ConferenceCategoriesController@restore');
                                    Route::get('studyabroad/cateories/create/{event_id}', 'ConferenceCategoriesController@create');
                                    Route::get('studyabroad/cateories/{event_id}/filter/{deleted}', 'ConferenceCategoriesController@filter');
                                    Route::post('studyabroad/cateories/store/{event_id}', 'ConferenceCategoriesController@store');
                                    
                            });
                            
                            Route::group(['middleware' => 'editor'], function()
                            {

                                    //speakers

                                    // Conference Speakers controller
                                    Route::resource('conference/speakers', 'ConferenceSpeakersController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceSpeakers',

                                                    'edit'    =>   'editConferenceSpeakers',
                                                    'update'  =>   'updateConferenceSpeakers',
                                                    'accept'  =>   'acceptConferenceSpeakers',
                                                    'reject'  =>   'rejectConferenceSpeakers',

                                                    'destroy'   => 'deleteConferenceSpeakers'
                                                ]
                                        ]
                                    );
    								Route::post('conference/speakers/restore/{id}', 'ConferenceSpeakersController@restore');
    								Route::post('conference/speakers/accept/{id}', 'ConferenceSpeakersController@accept');
    								Route::post('conference/speakers/reject/{id}', 'ConferenceSpeakersController@reject');
    								Route::get('conference/speakers/create/{event_id}', 'ConferenceSpeakersController@create');
                                    Route::get('conference/speakers/{event_id}/filter/{deleted}/filterAccepted/{accepted}', 'ConferenceSpeakersController@filter');
                                    Route::post('conference/speakers/store/{event_id}', 'ConferenceSpeakersController@store');

                                    //sponsors

                                    // Conference Sponsors controller
                                    Route::resource('conference/sponsors', 'ConferenceSponsorsController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceSponsors',
                                                   
                                                    'edit'    =>   'editConferenceSponsors',
                                                    'update'  =>   'updateConferenceSponsors',
                                                    'accept'  =>   'acceptConferenceSponsors',
                                                    'reject'  =>   'rejectConferenceSponsors',
                                                    'destroy'   => 'deleteConferenceSponsors'
                                                ]
                                        ]
                                    );
                                    Route::get('conference/sponsors/showSponsor/{id}', 'ConferenceSponsorsController@showSponsor');
    				    Route::post('conference/sponsors/restore/{id}', 'ConferenceSponsorsController@restore');

    				    Route::post('conference/sponsors/accept/{id}', 'ConferenceSponsorsController@accept');
    			            Route::post('conference/sponsors/reject/{id}', 'ConferenceSponsorsController@reject');
                                    Route::get('conference/sponsors/create/{event_id}', 'ConferenceSponsorsController@create');
                                    Route::get('conference/sponsors/{event_id}/filter/{deleted}/filterAccepted/{accepted}', 'ConferenceSponsorsController@filter');
                                    Route::post('conference/sponsors/store/{event_id}', 'ConferenceSponsorsController@store');


    								//media coverages

                                    // Conference MediaCoverages controller
                                    Route::resource('conference/media_coverages', 'ConferenceMediaCoveragesController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceMediaCoverages',

                                                    'edit'    =>   'editConferenceMediaCoverages',
                                                    'update'  =>   'updateConferenceMediaCoverages',
                                                    'accept'  =>   'acceptConferenceSponsors',
                                                    'reject'  =>   'rejectConferenceSponsors',
                                                    'destroy'   => 'deleteConferenceMediaCoverages'
                                                ]
                                        ]
                                    );

    								Route::post('conference/media_coverages/restore/{id}', 'ConferenceMediaCoveragesController@restore');

    								Route::post('conference/media_coverages/accept/{id}', 'ConferenceMediaCoveragesController@accept');
    								Route::post('conference/media_coverages/reject/{id}', 'ConferenceMediaCoveragesController@reject');


                                    Route::get('conference/media_coverages/create/{event_id}', 'ConferenceMediaCoveragesController@create');
                                    Route::get('conference/media_coverages/{event_id}/filter/{deleted}/filterAccepted/{accepted}', 'ConferenceMediaCoveragesController@filter');
                                    Route::post('conference/media_coverages/store/{event_id}', 'ConferenceMediaCoveragesController@store');




    								// Workshop Fees controller
                                    Route::resource('workshop/fees', 'WorkshopFeesController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showWorkshopFees',

                                                    'edit'    =>   'editWorkshopFees',
                                                    'update'  =>   'updateWorkshopFees',

                                                    'destroy'   => 'deleteWorkshopFees'
                                                ]
                                        ]
                                    );
    								// Workshop Widgets controller
                                    Route::resource('workshop/widgets', 'WorkshopWidgetsController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showWorkshopWidgets',

                                                    'edit'    =>   'editWorkshopWidgets',
                                                    'update'  =>   'updateWorkshopWidgets',

                                                    'destroy'   => 'deleteWorkshopWidgets'
                                                ]
                                        ]
                                    );

                                    // Book Series Widgets controller
                                    Route::resource('bookseries/widgets', 'BookseriesWidgetsController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showBookseriesWidgets',

                                                    'edit'    =>   'editBookseriesWidgets',
                                                    'update'  =>   'updateBookseriesWidgets',

                                                    'destroy'   => 'deleteBookseriesWidgets'
                                                ]
                                        ]
                                    );
                                    
                            });
                            
                            Route::group(['middleware' => 'super'], function()
                            {

                                     // Book Series Admins controller
                                    Route::resource('bookseries/admins', 'BookseriesAdminsController',
                                        [   'except' => array("index","create","store","edit"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showBookseriesAdmins',
                                                    'update'  =>   'updateBookseriesAdmins'
                                                ]
                                        ]
                                    );
                            });
                            
                                    Route::group(['middleware' => 'editor'], function()
                            {

                                    Route::post('workshop/fees/restore/{id}', 'WorkshopFeesController@restore');
                                    Route::get('workshop/fees/create/{event_id}', 'WorkshopFeesController@create');
                                    Route::get('workshop/fees/{event_id}/filter/{deleted}', 'WorkshopFeesController@filter');
                                    Route::post('workshop/fees/store/{event_id}', 'WorkshopFeesController@store');

                                    Route::post('workshop/widgets/restore/{id}', 'WorkshopWidgetsController@restore');
                                    Route::get('workshop/widgets/create/{event_id}', 'WorkshopWidgetsController@create');
                                    Route::get('workshop/widgets/{event_id}/filter/{deleted}', 'WorkshopWidgetsController@filter');
                                    Route::post('workshop/widgets/store/{event_id}', 'WorkshopWidgetsController@store');

                                    Route::post('bookseries/widgets/restore/{id}', 'BookseriesWidgetsController@restore');
                                    Route::get('bookseries/widgets/create/{event_id}', 'BookseriesWidgetsController@create');
                                    Route::get('bookseries/widgets/{event_id}/filter/{deleted}', 'BookseriesWidgetsController@filter');
                                    Route::post('bookseries/widgets/store/{event_id}', 'BookseriesWidgetsController@store');

                            });
                                    Route::group(['middleware' => 'super'], function()
                            {
                                    // Workshop Admins controller
                                    Route::resource('workshop/admins', 'WorkshopAdminsController',
                                        [   'except' => array("index","create","store","edit"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showWorkshopAdmins',
                                                    'update'  =>   'updateWorkshopAdmins'
                                                ]
                                        ]
                                    );

                            });
                            
                                   Route::group(['middleware' => 'editor'], function()
                            {
                                    // Studyabroad Fees controller
                                    Route::resource('studyabroad/fees', 'StudyabroadFeesController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudyabroadFees',

                                                    'edit'    =>   'editStudyabroadFees',
                                                    'update'  =>   'updateStudyabroadFees',

                                                    'destroy'   => 'deleteStudyabroadFees'
                                                ]
                                        ]
                                    );
    								// Studyabroad Widgets controller
                                    Route::resource('studyabroad/widgets', 'StudyabroadWidgetsController',
                                        [   'except' => array("index","create","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudyabroadWidgets',

                                                    'edit'    =>   'editStudyabroadWidgets',
                                                    'update'  =>   'updateStudyabroadWidgets',

                                                    'destroy'   => 'deleteStudyabroadWidgets'
                                                ]
                                        ]
                                    );

                                    // Studyabroad Categories controller
                                    Route::resource('studyabroad/categories', 'StudyabroadCategoriesController',
                                        [   'except' => array("index","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudyabroadCategories',

                                                    'edit'    =>   'editStudyabroadCategories',
                                                    'update'  =>   'updateStudyabroadCategories',

                                                    'destroy'   => 'deleteStudyabroadCategories'
                                                ]
                                        ]
                                    );

                                    // Bookseries Categories controller
                                    Route::resource('bookseries/categories', 'BookseriesCategoriesController',
                                        [   'except' => array("index","store"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showBookseriesCategories',

                                                    'edit'    =>   'editBookseriesCategories',
                                                    'update'  =>   'updateBookseriesCategories',

                                                    'destroy'   => 'deleteBookseriesCategories'
                                                ]
                                        ]
                                    );

                                    Route::post('studyabroad/fees/restore/{id}', 'StudyabroadFeesController@restore');
                                    Route::get('studyabroad/fees/create/{event_id}', 'StudyabroadFeesController@create');
                                    Route::get('studyabroad/fees/{event_id}/filter/{deleted}', 'StudyabroadFeesController@filter');
                                    Route::post('studyabroad/fees/store/{event_id}', 'StudyabroadFeesController@store');

                                    Route::post('studyabroad/widgets/restore/{id}', 'StudyabroadWidgetsController@restore');
                                    Route::get('studyabroad/widgets/create/{event_id}', 'StudyabroadWidgetsController@create');
                                    Route::get('studyabroad/widgets/{event_id}/filter/{deleted}', 'StudyabroadWidgetsController@filter');
                                    Route::post('studyabroad/widgets/store/{event_id}', 'StudyabroadWidgetsController@store');

                                    //Categories
                                    Route::post('studyabroad/categories/restore/{id}', 'StudyabroadCategoriesController@restore');
                                    Route::get('studyabroad/categories/create', 'StudyabroadCategoriesController@create');
                                    Route::get('studyabroad/categories/filter/{deleted}', 'StudyabroadCategoriesController@filter');
                                    Route::post('studyabroad/categories/store', 'StudyabroadCategoriesController@store');

                                    //Categories
                                    Route::post('bookseries/categories/restore/{id}', 'BookseriesCategoriesController@restore');
                                    Route::get('bookseries/categories/create', 'BookseriesCategoriesController@create');
                                    Route::get('bookseries/categories/filter/{deleted}', 'BookseriesCategoriesController@filter');
                                    Route::post('bookseries/categories/store', 'BookseriesCategoriesController@store');
                            });
                            
                            Route::group(['middleware' => 'super'], function()
                            {
                                    // Studyabroad Admins controller
                                    Route::resource('studyabroad/admins', 'StudyabroadAdminsController',
                                        [   'except' => array("index","create","store","edit"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudyabroadAdmins',
                                                    'update'  =>   'updateStudyabroadAdmins'
                                                ]
                                        ]
                                    );

                                    // Conference Admins controller
                                    Route::resource('conference/admins', 'ConferenceAdminsController',
                                        [   'except' => array("index","create","store","edit"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceAdmins',
                                                    'update'  =>   'updateConferenceAdmins'
                                                ]
                                        ]
                                    );
                                    
                                    // Studies Admins controller
                                    Route::resource('studies/admins', 'StudiesAdminsController',
                                        [   'except' => array("index","create","store","edit"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showStudiesAdmins',
                                                    'update'  =>   'updateStudiesAdmins'
                                                ]
                                        ]
                                    );
                                    
                            });

                            Route::group(['middleware' => 'editor'], function()
                            {   // Conference SCommittee controller
                                    Route::resource('conference/scommittee', 'ConferenceSCommitteeController',
                                        [   'except' => array("index","create","store","edit"),
                                            'names' =>
                                                [
                                                    'show'  =>   'showConferenceSCommittee',
                                                    'update'  =>   'updateConferenceSCommittee'
                                                ]
                                        ]
                                    );
                                    
                                    
                            });
  
                                    
                            });

    		    	});

    	    	
    	    	//END OF NAMESPACE EVENTS

     		// Controllers Within The "App\Http\Controllers\Admin\Pages\Construction" Namespace
    		    Route::group(['namespace' => 'Pages', 'middleware' => 'admin'], function()
    		    {
    					####################################################
    					####################|||||||||#######################
    					##################|||SECTION|||#####################
    					################|||Pages|||##################
    					#####################|||||||########################
    					####################################################

    				Route::group(['prefix' => 'pages'], function () {

    		    		///////////////////////////////////
    		    		////// CONSTRUCTION ROUTS /////////
    		    		///////////////////////////////////
    					 Route::group(['namespace' => 'Home'], function()
    		    		{
    						####################################################
    						####################|||||||||#######################
    						##################|||SECTION|||#####################
    						################|||Pages|||##################
    						#####################|||||||########################
    						####################################################

    						Route::group(['prefix' => 'home'], function () {

    			    		///////////////////////////////////
    		    			////// CONSTRUCTION ROUTS /////////
    		    			///////////////////////////////////


    						Route::resource('slider', 'SliderController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexSlider',
                                        'create' 		=> 'createSlider',
                                        'store'			=> 'storeSlider',
                                        'edit'   		=> 'editSlider',
                                        'update'		=> 'updateSlider',
                                        'destroy'		=> 'destroySlider',
                                    ]
                            ]
                       		);


                        	Route::post('slider/restore/{id}', 'SliderController@restore');
                        	Route::get('slider/filter/{deleted}', 'SliderController@filter');


                            Route::get('slider/create/', 'SliderController@create');
                            Route::post('slider/store/', 'SliderController@store');


                            Route::resource('video', 'VideoController',
                            [   'except' => "show",
                                'names' =>
                                    [
                                        'index'         => 'indexVideo',
                                        'create'        => 'createVideo',
                                        'store'         => 'storeVideo',
                                        'edit'          => 'editVideo',
                                        'update'        => 'updateVideo',
                                        'destroy'       => 'destroyVideo',
                                    ]
                            ]
                            );


                            Route::post('video/restore/{id}', 'VideoController@restore');
                            Route::get('video/filter/{deleted}', 'VideoController@filter');


                            Route::get('video/create/', 'VideoController@create');
                            Route::post('video/store/', 'VideoController@store');

                                Route::resource('partners', 'PartnersController',
                            [   
                                'names' =>
                                    [
                                        'index'         => 'indexPartners',
                                        'create'        => 'createPartners',
                                        
                                       
                                        'destroy'       => 'destroyPartner',
                                    ]
                            ]
                            );
                            Route::post('partners/store/', 'PartnersController@store');
                            
                            Route::resource('featured_conferences', 'FeaturedConferencesController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexFeaturedConferences',
                                        'create' 		=> 'createFeaturedConferences',
                                        'store'			=> 'storeFeaturedConferences',
                                        'edit'   		=> 'editFeaturedConference',
                                        'update'		=> 'updateFeaturedConference',
                                        'destroy'		=> 'destroyFeaturedConferences',
                                    ]
                            ]
                       		);


                        	Route::post('featured_conferences/restore/{id}', 'FeaturedConferencesController@restore');
                        	Route::get('featured_conferences/filter/{deleted}', 'FeaturedConferencesController@filter');


                            Route::get('featured_conferences/create/', 'FeaturedConferencesController@create');
                            Route::post('featured_conferences/store/', 'FeaturedConferencesController@store');


    						Route::resource('featured_workshops', 'FeaturedWorkshopsController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexFeaturedWorkshops',
                                        'create' 		=> 'createFeaturedWorkshops',
                                        'store'			=> 'storeFeaturedWorkshops',
                                        'edit'   		=> 'editFeaturedWorkshop',
                                        'update'		=> 'updateFeaturedWorkshop',
                                        'destroy'		=> 'destroyFeaturedWorkshops',
                                    ]
                            ]
                       		);


                        	Route::post('featured_workshops/restore/{id}', 'FeaturedWorkshopsController@restore');
                        	Route::get('featured_workshops/filter/{deleted}', 'FeaturedWorkshopsController@filter');


                            Route::get('featured_workshops/create/', 'FeaturedWorkshopsController@create');
                            Route::post('featured_workshops/store/', 'FeaturedWorkshopsController@store');
                            
                            Route::resource('featured_summer_schools', 'FeaturedSummerSchoolsController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexFeaturedSummerSchools',
                                        'create' 		=> 'createFeaturedSummerSchools',
                                        'store'			=> 'storeFeaturedSummerSchools',
                                        'edit'   		=> 'editFeaturedSummerSchools',
                                        'update'		=> 'updateFeaturedSummerSchools',
                                        'destroy'		=> 'destroyFeaturedSummerSchools',
                                    ]
                            ]
                       		);


                        	Route::post('featured_summer_schools/restore/{id}', 'FeaturedSummerSchoolsController@restore');
                        	Route::get('featured_summer_schools/filter/{deleted}', 'FeaturedSummerSchoolsController@filter');


                            Route::get('featured_summer_schools/create/', 'FeaturedSummerSchoolsController@create');
                            Route::post('featured_summer_schools/store/', 'FeaturedSummerSchoolsController@store');

                              

                                Route::resource('featured_winter_schools', 'FeaturedWinterSchoolsController',
                            [	'except' => "show",
                                'names' =>
                                    [
                                    	'index'			=> 'indexFeaturedWinterSchools',
                                        'create'                => 'createFeaturedWinterSchools',
                                        'edit'   		=> 'editFeaturedWinterSchools',
                                        'update'		=> 'updateFeaturedWinterSchools',
                                        'destroy'		=> 'destroyFeaturedWinterSchools',
                                    ]
                            ]
                       		);
                                
                            Route::post('featured_winter_schools/store/', 'FeaturedWinterSchoolsController@store');
                            Route::get('featured_winter_schools/filter/{deleted}', 'FeaturedWinterSchoolsController@filter');
                            Route::post('featured_winter_schools/restore/{id}', 'FeaturedWinterSchoolsController@restore');
    				
                            
                                    Route::resource('announcement', 'AnnouncementController',
                            [	
                                'names' =>
                                    [
                                    	'index'			=>'indexAnnouncement',
                                        'create' 	        =>'createAnnouncement',
                                        'destroy'               =>'deleteAnnouncement',
                                        'edit'    	        =>'editAnnouncement',
                                      
                                    ]
                            ]
                       		);
                                    
                              Route::post('announcement/store', 'AnnouncementController@store');
                              Route::post('announcement/update', 'AnnouncementController@update');
                              Route::get('announcement/order/{event_id}', [
    				"uses" => "AnnouncementController@order",
                                "as" => "orderAnnouncements"
                              ]);
                              
                              Route::post('announcement/changeposition', [
    							"uses" => "AnnouncementController@changePosition",
    							"as" => "changePositionAnnouncements"
    						]);
                                                });
                             //                   
//                           Route::resource('announcements', 'AnnouncementsController',
//                            [	
//                                'names' =>
//                                    [
//                                    	'index'			=> 'indexAnnouncements',
//                                    ]
//                            ]
//                       		);
//                                    
//                              Route::post('announcements/store', 'AnnouncementsController@store');
//                            
//                                                });
    			});


    				    			});
    			//END OF NAMESPACE CONSTRUCTION

    		    // Controllers Within The "App\Http\Controllers\Admin\Construction" Namespace
    		    Route::group(['namespace' => 'Construction', 'middleware' => 'admin'], function()
    		    {
    					####################################################
    					####################|||||||||#######################
    					##################|||SECTION|||#####################
    					################|||CONSTRUCTION|||##################
    					#####################|||||||########################
    					####################################################

    				Route::group(['prefix' => 'construction'], function () {

    		    		///////////////////////////////////
    		    		////// CONSTRUCTION ROUTS /////////
    		    		///////////////////////////////////


    				});
    			});
    			//END OF NAMESPACE CONSTRUCTION
    		//END OF NAMESPACE ADMIN

    	});
        
        });

    });
});
