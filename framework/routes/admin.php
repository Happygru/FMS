<?php
Auth::routes();
Route::namespace ('Admin')->group(function () {
    // Route::get('export-events', 'HomeController@export_calendar');

    Route::get('test-login', 'Testcontroller@login');

    Route::get('/migrate', function () {
        \Artisan::call('migrate');
    });

    Route::post("logout", 'HomeController@logout')->name('logout');

    Route::get("/clear_cache", function () {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
    });

    // Route::get('add-permission', function () {
    //     $drivers = App\Model\User::where('user_type', 'D')->get();
    //     foreach ($drivers as $driver) {
    //         $d = App\Model\User::find($driver->id);
    //         $d->givePermissionTo(['VehicleInspection add']);
    //         //$d->givePermissionTo(['Transactions list','Transactions add','Transactions edit','Transactions delete']);
    //     }
    // });
// dd('test');
    Route::get("/", 'HomeController@index')->middleware(['lang_check', 'auth']);
    Route::group(['middleware' => ['lang_check', 'auth', 'officeadmin', 'IsInstalled']], function () {

        Route::resource('crm', 'CRMController');
        
        Route::get('crm-corporate-accounts', 'CRMController@corporate_accounts');
        Route::get('crm-corporate-accounts/create', 'CRMController@create_corporate_account');
        Route::post('crm-corporate-accounts/create', 'CRMController@create_corporate_account');
        Route::get('crm-corporate-accounts/edit/{id}', 'CRMController@edit_corporate_account');
        Route::post('crm-corporate-accounts/edit', 'CRMController@edit_corporate_account');
        Route::post('crm-corporate-accounts/delete', 'CRMController@delete_corporate');

        Route::get('crm-documents', 'CRMController@documents');
        Route::get('crm-documents/create', 'CRMController@create_document');
        Route::post('crm-documents/create', 'CRMController@create_document');
        Route::get('crm-documents/edit/{id}', 'CRMController@edit_document');
        Route::post('crm-documents/edit', 'CRMController@edit_document');
        Route::post('crm-documents/delete', 'CRMController@delete_document');

        Route::get('crm-leads', 'CRMController@leads');
        Route::get('crm-leads/delete', 'CRMController@delete_lead');
        Route::get('crm-leads/create', 'CRMController@create_lead');
        Route::get('crm-leads/edit/{id}', 'CRMController@edit_lead');
        Route::post('crm-leads/edit', 'CRMController@edit_lead');
        Route::post('crm-leads/convertcustomer', 'CRMController@convertcustomer');

        Route::get('crm-contacts', 'CRMController@contacts');
        Route::get('crm-contacts/create', 'CRMController@create_contact');
        Route::post('crm-contacts/create', 'CRMController@create_contact');
        Route::get('crm-contacts/edit/{id}', 'CRMController@edit_contact');
        Route::post('crm-contacts/edit', 'CRMController@edit_contact');
        Route::post('crm-contacts/delete', 'CRMController@delete_contact');

        Route::resource('/thirdmanagers', 'ThirdManagersController');
        Route::post('/thirdmanagers-fetch', 'ThirdManagersController@fetch_data');
        Route::post('/thirdmanagers/ajax_update', 'ThirdManagersController@ajax_update')->name('thirdmanagers.ajax_update');
        Route::post('/thirdmanagers/ajax_store', 'ThirdManagersController@ajax_store')->name('thirdmanagers.ajax_store');
        Route::post('/thirdmanagers-vehicle-fetch', 'ThirdManagersController@fetch_vehicle_data');
        Route::get('/thirdmanagers/event/{id}', 'ThirdManagersController@view_event');

        Route::get('/vehicles-track/{id?}','TrackerController@vehicles_track');
        Route::get('/track/{id?}','TrackerController@track');
        Route::get('/traccar-settings','TrackerController@traccar_settings')->name('traccar.settings');
        Route::post('/traccar-settings','TrackerController@traccar_settings_store')->name('traccar_settings.store');

        Route::get('get-driver-index', 'DriversController@get_driver_index');
        Route::post('transactions-fetch', 'BookingsController@transactions_fetch_data');
        Route::get('transactions', 'BookingsController@transactions');

        Route::get('thirdvehicles', 'VehiclesController@thirdvehicles');
        Route::post('/thirdvehicles-fetch', 'VehiclesController@third_fetch_data');
        Route::get('thirdvehicles/create', 'VehiclesController@create_thirdvehicle');

        Route::get('get-models/{id}', 'VehiclesController@get_models');

        Route::post('vehicle-color-fetch', 'VehicleColorsController@fetch_data');
        Route::resource('vehicle-color', 'VehicleColorsController');
        Route::post('delete-vehicle-color', 'VehicleColorsController@bulk_delete');

        Route::post('vehicle-make-fetch', 'VehicleMakeController@fetch_data');
        Route::resource('vehicle-make', 'VehicleMakeController');
        Route::post('delete-vehicle-make', 'VehicleMakeController@bulk_delete');

        Route::post('vehicle-model-fetch', 'VehicleModelController@fetch_data');
        Route::resource('vehicle-model', 'VehicleModelController');
        Route::post('delete-vehicle-model', 'VehicleModelController@bulk_delete');

        Route::get('firebase', 'FirebaseController@index');

        Route::resource('roles', 'UserAccessController');

        Route::post('/users-fetch', 'UsersController@fetch_data');
        Route::resource('/users', 'UsersController');

        Route::get('twilio-settings', 'TwilioController@index');
        Route::post('twilio-settings', 'TwilioController@update');

        Route::post('reject-quotation', 'BookingQuotationController@reject');

        Route::get('fetch-data', 'Testcontroller@fetch');
        // Route::get('test', function () {
        //     return view('geocode');
        // });
        Route::post('clear-database', 'SettingsController@clear_database');
        Route::post('cancel-booking', 'BookingsController@cancel_booking');
        Route::resource('team', 'TeamController');
        Route::resource('company-services', 'CompanyServicesController');
        Route::get('parts-used/{id}', 'WorkOrdersController@parts_used');
        Route::get('remove-part/{id}', 'WorkOrdersController@remove_part');
        Route::post('add-stock', 'PartsController@add_stock');
        Route::post('booking-quotation-fetch', 'BookingQuotationController@fetch_data');
        Route::resource('booking-quotation', 'BookingQuotationController');
        Route::post('add-booking', 'BookingQuotationController@add_booking');
        Route::post('/booking-quotation-update', 'BookingQuotationController@ajax_update');
        Route::get('booking-quotation/invoice/{id}', 'BookingQuotationController@invoice');
        Route::get('print-quote/{id}', 'BookingQuotationController@print');
        Route::get('booking-quotation/approve/{id}', 'BookingQuotationController@approve');
        Route::post('import-vehicles', 'VehiclesController@importVehicles');
        Route::post('import-drivers', 'DriversController@importDrivers');
        Route::post('import-income', 'IncomeCategories@importIncome');
        Route::post('import-expense', 'ExpenseCategories@importExpense');
        Route::post('import-customers', 'CustomersController@importCutomers');
        Route::post('import-vendors', 'VendorController@importVendors');
        Route::get('frontend-settings', 'SettingsController@frontend');
        Route::post('frontend-settings', 'SettingsController@store_frontend');
        Route::resource('testimonials', 'TestimonialController');
        // routes for bulk delete action
        Route::post('delete-team', 'TeamController@bulk_delete');
        Route::post('delete-company-services', 'CompanyServicesController@bulk_delete');
        Route::post('delete-testimonials', 'TestimonialController@bulk_delete');
        Route::post('delete-reasons', 'ReasonController@bulk_delete');
        Route::post('delete-income', 'IncomeController@bulk_delete');
        Route::post('delete-expense', 'ExpenseController@bulk_delete');
        Route::post('delete-reminders', 'ServiceReminderController@bulk_delete');
        Route::post('delete-service-items', 'ServiceItemsController@bulk_delete');
        Route::post('delete-parts', 'PartsController@bulk_delete');
        Route::post('delete-work-orders', 'WorkOrdersController@bulk_delete');
        Route::post('delete-parts-category', 'PartsCategoryController@bulk_delete');
        Route::post('delete-customer', 'CustomersController@bulk_delete');
        Route::post('delete-users', 'UsersController@bulk_delete');
        Route::post('delete-drivers', 'DriversController@bulk_delete');
        Route::post('delete-vehicles', 'VehiclesController@bulk_delete');
        Route::post('delete-fuel', 'FuelController@bulk_delete');
        Route::post('delete-vendors', 'VendorController@bulk_delete');
        Route::post('delete-bookings', 'BookingsController@bulk_delete');
        Route::post('delete-quotes', 'BookingQuotationController@bulk_delete');
        Route::post('delete-vehicle-types', 'VehicleTypeController@bulk_delete');
        Route::post('delete-vehicle-groups', 'VehicleGroupController@bulk_delete');
        Route::post('delete-vehicle-reviews', 'VehiclesController@bulk_delete_reviews');

        Route::resource('booking-services', 'BookingServicesController');
        Route::get('booking-services/edit/{id}', 'BookingServicesController@edit');
        Route::get('/booking-services-fetch', 'BookingServicesController@fetch_data');
        Route::post('/booking-service-fetch-condition', 'BookingServicesController@fetch_data_condition');
        Route::post('/booking-services-delete', 'BookingServicesController@delete_item');
        Route::post('/booking-services-create', 'BookingServicesController@create_item');
        Route::post('/booking-services-update', 'BookingServicesController@update_item');

        Route::get('rates/hourly', 'RatesController@hourly')->name('rates.hourly');
        Route::get('rates/dailyRentCar', 'RatesController@dailyRentCar')->name('rates.dailyRentCar');
        Route::get('rates/insuranceRates', 'RatesController@insuranceRates')->name('rates.insuranceRates');
        Route::get('rates/rateCalculator','RatesController@rateCalculator')->name('rates.rateCalculator');
        Route::post('/rates-hourly-update', 'RatesController@hourly_update');
        Route::post('/rates-dailyRentCar-update', 'RatesController@dailyRentCar_update');
        Route::post('/rates-insuracne-update', 'RatesController@insurance_update');

        Route::resource('branches', 'BranchesController');
        Route::post('/branch-create', 'BranchesController@branch_create');
        Route::post('/branch-update', 'BranchesController@branch_update');
        Route::post('/branch-delete', 'BranchesController@branch_delete')->name('branches.delete');

        Route::resource('addon', 'AddonController');
        Route::post('/addon-create', 'AddonController@addon_create');
        Route::post('/addon-update', 'AddonController@addon_update');
        Route::post('/addon-delete', 'AddonController@addon_delete');
        Route::post('/get-addon-list', 'AddonController@get_addon_list');

        Route::get('reports/income', 'ReportsController@income');
        Route::post('reports/income', 'ReportsController@income_post');
        Route::post('print-income', 'ReportsController@income_print');

        Route::get('reports/expense', 'ReportsController@expense');
        Route::post('reports/expense', 'ReportsController@expense_post');
        Route::post('print-expense', 'ReportsController@expense_print');

        Route::get('reports/thirdparty_income', 'ReportsController@thirdparty_income');
        Route::post('reports/thirdparty_income', 'ReportsController@thirdparty_income_post');
        Route::post('print-thirdparty-income', 'ReportsController@thirdparty_income_print');

        Route::get('reports/thirdparty_expense', 'ReportsController@thirdparty_expense');
        Route::post('reports/thirdparty_expense', 'ReportsController@thirdparty_expense_post');
        Route::post('print-thirdparty-expense', 'ReportsController@thirdparty_expense_print');

        Route::get('work_order/logs', 'WorkOrdersController@logs');
        Route::resource('parts-category', 'PartsCategoryController');

        Route::post('driver-logs-fetch', 'VehiclesController@driver_logs_fetch_data');
        Route::get('driver-logs', 'VehiclesController@driver_logs');
        Route::post('/vehicle-types-fetch', 'VehicleTypeController@fetch_data');
        Route::resource('/vehicle-types', 'VehicleTypeController');

        Route::get('/vehicle-makes', 'VehiclesController@manage_vehicle_maker');
        Route::get('/vehicle-makes/edit/{id}', 'VehiclesController@edit_vehicle_make');
        Route::get('/vehicle-makes/create', 'VehiclesController@create_vehicle_make');
        Route::post('/vehicle-makes/save', 'VehiclesController@save_vehicle_make');
        Route::post('/vehicle-makes/store', 'VehiclesController@store_vehicle_make');
        Route::post('/vehicle-makes/delete', 'VehiclesController@delete_vehicle_make');

        Route::get('/vehicle-model', 'VehiclesController@manage_vehicle_model');
        Route::get('/vehicle-model/edit/{id}', 'VehiclesController@edit_vehicle_model');
        Route::get('/vehicle-model/create', 'VehiclesController@create_vehicle_model');
        Route::post('/vehicle-model/save', 'VehiclesController@save_vehicle_model');
        Route::post('/vehicle-model/store', 'VehiclesController@store_vehicle_model');
        Route::post('/vehicle-model/delete', 'VehiclesController@delete_vehicle_model');

        Route::post('vehicle-reviews-fetch', 'VehiclesController@vehicle_review_fetch_data');
        Route::get('vehicle-reviews', 'VehiclesController@vehicle_review_index')->name('vehicle_reviews');
        Route::get('print-vehicle-review/{id}', 'VehiclesController@print_vehicle_review');
        Route::get('view-vehicle-review/{id}', 'VehiclesController@view_vehicle_review');
        Route::get('vehicle-reviews-create', 'VehiclesController@vehicle_review');
        Route::get('vehicle-review/{id}/edit', 'VehiclesController@review_edit');
        Route::post('vehicle-review-update', 'VehiclesController@update_vehicle_review');
        Route::post('store-vehicle-review', 'VehiclesController@store_vehicle_review');
        Route::delete('delete-vehicle-review/{id}', 'VehiclesController@destroy_vehicle_review');
        //maps
        Route::get('single-driver/{id}', 'DriversController@single_driver');
        Route::get('driver-maps/', 'DriversController@driver_maps');
        Route::get('markers/', 'DriversController@markers');
        Route::get('track-driver/{id}', 'DriversController@track_driver');

        Route::post('print-users-report', 'ReportsController@print_users');
        Route::post('print-customer-report', 'ReportsController@print_customer');
        Route::get('print-vendor-report', 'ReportsController@print_vendor');
        Route::post('print-driver-report', 'ReportsController@print_driver');
        Route::post('print-yearly-report', 'ReportsController@print_yearly');
        Route::post('print-fuel-report', 'ReportsController@print_fuel');
        Route::post('print-booking-report', 'ReportsController@print_booking');
        Route::post('print-deliquent-report', 'ReportsController@print_deliquent');
        Route::post('print-monthly-report', 'ReportsController@print_monthly');
        // Route::get('print-bookings', 'BookingsController@print_bookings');
        Route::get('reviews', 'ReviewRatings@index');
        Route::get('messages', 'ContactUs@index');
        Route::get('api-settings', 'SettingsController@api_settings');
        Route::post('api-settings', 'SettingsController@store_settings');

        // Route::get('fb', 'SettingsController@fb_create')->name('fb');
        Route::post('firebase-settings', 'SettingsController@firebase');
        Route::get('fare-settings', 'SettingsController@fare_settings');
        Route::post('/fare-fetch', 'SettingsController@fare_fetch_data');
        Route::post('/fare-update', 'SettingsController@fare_update_data');

        Route::post('fare-settings', 'SettingsController@store_fareSettings');
        Route::post('store-key', 'SettingsController@store_key');
        Route::get('test-key', 'SettingsController@test_key');
        Route::post('store-api', 'SettingsController@store_api');
        Route::resource('service-reminder', 'ServiceReminderController');
        Route::resource('service-item', 'ServiceItemsController');
        Route::post('/vehicle-group-fetch', 'VehicleGroupController@fetch_data');
        Route::resource('/vehicle_group', 'VehicleGroupController');
        Route::post('/income_records', 'Income@income_records');
        Route::post('/expense_records', 'ExpenseController@expense_records');
        Route::post('/store_insurance', 'VehiclesController@store_insurance');
        Route::get('vehicle/event/{id}', 'VehiclesController@view_event');
        Route::post('assignDriver', 'VehiclesController@assign_driver');

        Route::post('/work-orders-fetch', 'WorkOrdersController@fetch_data');
        Route::resource('/work_order', 'WorkOrdersController');
        Route::post('/vendors-fetch', 'VendorController@fetch_data');
        Route::resource('/vendors', 'VendorController');
        Route::post('drivers-fetch', 'DriversController@fetch_data');
        Route::resource('/drivers', 'DriversController');
        Route::resource('/parts', 'PartsController');
        Route::post('/vehicles-fetch', 'VehiclesController@fetch_data');
        Route::resource('/vehicles', 'VehiclesController');
        Route::get("/vehicles/enable/{id}", 'VehiclesController@enable');
        Route::get("/vehicles/disable/{id}", 'VehiclesController@disable');
        Route::post('/bookings-fetch', 'BookingsController@fetch_data');
        Route::post('/driver-bookings-fetch', 'DriversController@fetch_bookings_data');
        Route::post('/get-distance', 'BookingsController@get_distance');
        Route::resource('/bookings', 'BookingsController');
        Route::post('/booking-create', 'BookingsController@create_booking');
        Route::post('/booking-update', 'BookingsController@update_booking');
        Route::post('/prev-address', 'BookingsController@prev_address');
        Route::get('f{id}', 'BookingsController@print');
        Route::resource('/acquisition', 'AcquisitionController');
        Route::resource('/income', 'IncomeController');
        Route::get('/thirdparty_income', 'IncomeController@thirdparty')->name('income.thirdparty');
        Route::resource('/settings', 'SettingsController');
        Route::get('/logs', 'SettingsController@logs');
        Route::post('/customers-fetch', 'CustomersController@fetch_data');
        Route::resource('/customers', 'CustomersController');
        Route::resource('/expense', 'ExpenseController');
        Route::get('/thirdparty_expense', 'ExpenseController@thirdparty')->name('expense.thirdparty');
        Route::resource('/expensecategories', 'ExpenseCategories');
        Route::resource('/incomecategories', 'IncomeCategories');
        Route::get('/bookings/complete/{id}', 'BookingsController@complete');
        Route::get('/bookings/receipt/{id}', 'BookingsController@receipt');
        Route::get('/bookings/payment/{id}', 'BookingsController@payment');
        Route::get("/reports/monthly", "ReportsController@monthly")->name("reports.monthly");
        Route::get("/reports/vendors", "ReportsController@vendors")->name("reports.vendors");
        Route::post("/reports/vendors", "ReportsController@vendors_post")->name("reports.vendors");
        Route::get("reports/drivers", "ReportsController@drivers")->name("reports.drivers");
        Route::post("reports/drivers", "ReportsController@drivers_post")->name("reports.drivers");
        Route::get("reports/customers", "ReportsController@customers")->name("reports.customers");
        Route::post("reports/customers", "ReportsController@customers_post")->name("reports.customers");
        Route::get("/reports/booking", "ReportsController@booking")->name("reports.booking");
        Route::get("/reports/delinquent", "ReportsController@delinquent")->name("reports.delinquent");
        Route::get("/reports/users", "ReportsController@users")->name("reports.users");
        Route::post("/reports/users", "ReportsController@users_post")->name("reports.users");
        Route::get('/calendar', 'BookingsController@calendar');
        Route::get('/calendar/event/{id}', 'BookingsController@calendar_event');
        Route::get("/drivers/enable/{id}", 'DriversController@enable');
        Route::get("/drivers/disable/{id}", 'DriversController@disable');
        Route::get("/reports/vehicle", "ReportsController@vehicle")->name("reports.vehicle");
        Route::post("/reports/booking", "ReportsController@booking_post")->name("reports.booking");
        Route::post("/reports/fuel", "ReportsController@fuel_post")->name("reports.fuel");
        Route::get("/reports/fuel", "ReportsController@fuel")->name("reports.fuel");
        Route::get("/reports/yearly", "ReportsController@yearly")->name("reports.yearly");
        Route::post("/reports/yearly", "ReportsController@yearly_post")->name("reports.yearly");
        Route::get("/reports/payments", "ReportsController@drivers_payments")->name("reports.payments");
        Route::post("/reports/payments", "ReportsController@drivers_payments_post")->name("reports.payments");

        Route::post('/customer/ajax_save', 'CustomersController@ajax_store')->name('customers.ajax_store');
        Route::post('/customer/ajax_update', 'CustomersController@ajax_update')->name('customers.ajax_update');
        Route::get("/bookings_calendar", 'BookingsController@calendar_view')->name("bookings.calendar");
        Route::get('/calendar/event/calendar/{id}', 'BookingsController@calendar_event');
        Route::get('/calendar/event/service/{id}', 'BookingsController@service_view');
        Route::get('/calendar', 'BookingsController@calendar');
        Route::post('/get_driver', 'BookingsController@get_driver');
        Route::post('/get_vehicle', 'BookingsController@get_vehicle');
        Route::post('/fetch-vehicle-list-by-type', 'BookingsController@fetch_vehicle_list_by_type');

        Route::post('/bookings/complete', 'BookingsController@complete_post')->name("bookings.complete");
        Route::get('/bookings/complete', 'BookingsController@complete_post')->name("bookings.complete");

        Route::post("/reports/monthly", "ReportsController@monthly_post")->name("reports.monthly");
        Route::post("/reports/booking", "ReportsController@booking_post")->name("reports.booking");
        Route::post("/reports/delinquent", "ReportsController@delinquent_post")->name("reports.delinquent");
        Route::get("/send-email", "SettingsController@send_email");
        Route::post("/email-settings", "SettingsController@email_settings");
        Route::post('enable-mail', 'SettingsController@enable_mail');
        Route::get("/set-email", "SettingsController@set_email");
        Route::post("/set-content/{type}", "SettingsController@set_content");

        Route::get('ajax-api-store/{api}', 'SettingsController@ajax_api_store');

        Route::get('payment-settings', 'SettingsController@payment_settings');
        Route::post('payment-settings', 'SettingsController@payment_settings_post');
    });

    Route::group(['middleware' => ['lang_check', 'auth']], function () {

        // chat routes:
        Route::get('chat', 'MessagesController@index')->name('chat.index');
        Route::get('chat-settings', 'MessageSettingsController@index')->name('chat_settings.index');
        Route::post('chat-settings', 'MessageSettingsController@store')->name('chat_settings.store');
        Route::get('load-latest-messages', 'MessagesController@getLoadLatestMessages');
        Route::post('send', 'MessagesController@postSendMessage');

        Route::post('delete-notes', 'NotesController@bulk_delete');
        Route::get('changepassword/{id}', 'UtilityController@change');
        Route::post('changepassword/{id}', 'UtilityController@change_post');
        Route::get('/change-details/{id}', 'UtilityController@changepass')->name("changepass");
        Route::post('/change-details/{id}', 'UtilityController@changepassword')->name("changepass");
        Route::post('/change_password', 'UtilityController@password_change');
        Route::get('/vehicle_notification/{type}', 'NotificationController@vehicle_notification');
        Route::resource('/notes', 'NotesController');
        Route::get('driver_notification/{type}', 'NotificationController@driver_notification');
        Route::get('/reminder/{type}', 'NotificationController@service_reminder');
        Route::get('/my_bookings', 'DriversController@my_bookings')->name('my_bookings');

//report work order
        Route::get("/reports/work-order", "ReportsController@work_order")->name("reports.work_order");
        Route::post("/reports/work-order", "ReportsController@work_order_post")->name("reports.work_order");
        Route::post('print-workOrder-report', 'ReportsController@print_workOrder_report');
//mechanics  CRUD
        Route::resource('mechanic', 'MechanicController');
        Route::post("/delete-mechanics", "MechanicController@bulk_delete");
// vehicle inspection
        Route::get('vehicle-inspection', 'VehiclesController@vehicle_inspection_index')->name('vehicle_inspection');
        Route::get('print-vehicle-inspection/{id}', 'VehiclesController@print_vehicle_inspection');
        Route::get('vehicle-inspection-create', 'VehiclesController@vehicle_inspection_create');
        Route::post('store-vehicle-review', 'VehiclesController@store_vehicle_review');
        Route::get('view-vehicle-inspection/{id}', 'VehiclesController@view_vehicle_inspection');
// fuel detail
        Route::resource('/fuel', 'FuelController');
//vehicle Expense
        Route::resource('/expense', 'ExpenseController');
        Route::post('/expense_records', 'ExpenseController@expense_records');
        Route::post('/thirdparty_expense_records', 'ExpenseControllers@thirdparty_expense_records');
        Route::post('delete-expense', 'ExpenseController@bulk_delete');
//vehicle income
        Route::resource('/income', 'IncomeController');
        Route::post('delete-income', 'IncomeController@bulk_delete');
        Route::post('/income_records', 'IncomeController@income_records');
        Route::post('/thirdparty_income_records', 'IncomeController@thirdparty_income_records');
// driver reports
        Route::get("/driver-reports/yearly", "DriversController@yearly")->name("dreports.yearly");
        Route::post("/driver-reports/yearly", "DriversController@yearly_post")->name("dreports.yearly");
        Route::get("/driver-reports/monthly", "DriversController@monthly")->name("dreports.monthly");
        Route::post("/driver-reports/monthly", "DriversController@monthly_post")->name("dreports.monthly");
        Route::get('/addresses', 'AddressController@index');

        Route::resource('/cancel-reason', 'ReasonController');
    });

});
