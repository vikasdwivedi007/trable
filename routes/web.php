<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'HomeController@index')->name('home');
Route::get('refresh-csrf', function(){return csrf_token();});

Route::post('change-theme', 'Controller@changeTheme');
Route::get('change-language', 'Controller@changeLang')->name('change-language');

Route::post('get-country-cities', 'Controller@getCountryCities')->name('getCountryCities');

Route::resource('profile', 'ProfileController')->only(['index', 'update']);

Route::get('profile', 'ProfileController@index')->name('profile.index');
Route::patch('profile', 'ProfileController@update')->name('profile.update');

Route::resource('departments', 'DepartmentController')->except(['show', 'destroy']);
Route::get('departments/{department}/activate', 'DepartmentController@activate')->name('departments.activate');
Route::get('departments/{department}/deactivate', 'DepartmentController@deactivate')->name('departments.deactivate');

Route::get('employees/activate/{employee}', 'EmployeeController@activate')->name('employees.activate');
Route::get('employees/deactivate/{employee}', 'EmployeeController@deactivate')->name('employees.deactivate');
Route::resource('employees', 'EmployeeController')->except(['show','destroy']);

Route::get('notifications', 'NotificationController@index')->name('notifications.index');
Route::get('notifications/read-all', 'NotificationController@readAll')->name('notifications.read-all');
Route::get('notifications/read-one/{id}', 'NotificationController@readOne')->name('notifications.read-one');

Route::resource('reminders', 'ReminderController')->except(['show']);

Route::resource('travel-agents', 'TravelAgentController')->names('travel-agents')->except(['show']);

Route::get('services', 'HomeController@services')->name('services.index');

Route::get('suppliers', 'HomeController@suppliers')->name('suppliers.index');

Route::resource('restaurants', 'RestaurantController')->except(['show']);

Route::resource('hotels', 'HotelController')->except(['show']);
Route::post('hotels/search-by-city', 'HotelController@searchHotelsByCity')->name('hotels.searchHotelsByCity');
Route::get('hotels/{hotel}/rooms-selectors', 'HotelController@getRoomsSelectors')->name('hotels.getRoomsSelectors');

Route::resource('rooms', 'RoomController')->except(['index', 'show']);
Route::post('rooms/get-available-rooms', 'RoomController@getAvailableRooms')->name('rooms.getAvailableRooms');
Route::post('rooms/is-available', 'RoomController@checkIfRoomIsAvailable')->name('rooms.checkIfRoomIsAvailable');

Route::resource('transportations', 'TransportationController')->except(['show']);
Route::post('transportations/search-cars-by-company', 'TransportationController@searchCarsByCompany')->name('searchCarsByCompany');

Route::get('airports', 'MescController@searchAirports')->middleware('auth')->name('airports.search');
Route::resource('flights', 'FlightController')->except(['show']);
Route::post('flights/search', 'FlightController@searchFlights')->name('flights.searchFlights');

Route::resource('sightseeings', 'SightseeingController')->except(['show']);
Route::post('sightseeings/search-by-city', 'SightseeingController@searchSightseeingsByCity')->name('sightseeings.searchSightseeingsByCity');

Route::resource('slshows', 'SLShowController')->parameter('sLShow', 'slshow')->except(['show']);
Route::post('slshows/get-langs-by-place-and-date', 'SLShowController@getLangsByCityAndDate')->name('slshows.getLangsByCityAndDate');
Route::post('slshows/get-times-by-lang-place-and-date', 'SLShowController@getTimesByLangPlaceAndDate')->name('slshows.getTimesByLangPlaceAndDate');

Route::resource('routers', 'RouterController')->except(['show']);
Route::post('routers/available', 'RouterController@getAvailableRouters')->name('routers.getAvailableRouters');

Route::resource('vbnights', 'VBNightController')->parameter('vBNight', 'vbnight')->except(['show']);
Route::post('vbnights/search-by-city', 'VBNightController@searchByCity')->name('vbnights.searchByCity');

Route::resource('lkfriends', 'LKFriendController')->parameter('lKFriend', 'lkfriend')->except(['show']);

Route::resource('shops', 'ShopController')->except(['show']);

Route::resource('train-tickets', 'TrainTicketController')->parameter('train-ticket', 'train_ticket')->except(['show']);
Route::post('train-tickets/search', 'TrainTicketController@searchTrains')->name('train-tickets.searchTrains');

Route::resource('gifts', 'GiftController')->except(['show']);

Route::resource('travel-visas', 'TravelVisaController')->except(['show']);

Route::resource('nile-cruises', 'NileCruiseController')->except(['show']);
Route::post('nile-cruises/get-names-by-date-city', 'NileCruiseController@getCruiseNamesByDateAndCity')->name('nile-cruises.getCruiseNamesByDateAndCity');
Route::post('nile-cruises/get-cruise-by-name-date-city', 'NileCruiseController@getCruiseByNameDateAndCity')->name('nile-cruises.getCruiseByNameDateAndCity');
Route::post('nile-cruises/get-cruises-by-ids', 'NileCruiseController@getCruisesByIDs')->name('nile-cruises.getCruisesByIDs');

Route::resource('guides', 'GuideController')->except(['show']);
Route::post('guides/available', 'GuideController@getAvailableGuides')->name('guides.getAvailableGuides');

Route::post('job-files/search-by-file-no', 'JobFileController@searchByFileNo')->name('job-files.searchByFileNo');
Route::get('job-files/search-by-file-no-and-date', 'JobFileController@searchByFileNoAndDate')->name('job-files.searchByFileNoAndDate');
Route::post('job-files/{job_file}/review/{status}', 'JobFileController@review')->name('job-files.review');
Route::get('job-files/{job_file}/delegate', 'JobFileController@delegatePage')->name('job-files.delegatePage');
Route::post('job-files/{job_file}/delegate', 'JobFileController@delegate')->name('job-files.delegate');
Route::resource('job-files', 'JobFileController')->except(['destroy']);

Route::resource('draft-invoices', 'DraftInvoiceController');
Route::get('invoices/list', 'InvoiceController@list')->name('invoices.list');
Route::resource('invoices', 'InvoiceController');

Route::resource('media', 'MediaLibController')->parameters(['media'=> 'file'])->only(['index', 'destroy']);

Route::get('vouchers', 'HomeController@vouchers')->name('vouchers.index');
Route::get('vouchers/{serial_no}', 'HomeController@showVoucherBySerialNo')->name('vouchers.showVoucherBySerialNo');

Route::resource('traffic-vouchers', 'TrafficVoucherController');
Route::resource('restaurant-vouchers', 'RestaurantVoucherController');
Route::resource('guide-vouchers', 'GuideVoucherController');
Route::resource('hotel-vouchers', 'HotelVoucherController');

Route::resource('police-permissions', 'PolicePermissionController');

Route::resource('payment-monthly-requests', 'PaymentMonthlyRequestController');

Route::get('traffic-monthly-commissions/print', 'TrafficMonthlyCommissionController@print')->name('traffic-monthly-commissions.print');
Route::resource('traffic-monthly-commissions', 'TrafficMonthlyCommissionController')->except(['show']);

Route::get('operating-statements/print', 'OperatingStatementController@print')->name('operating-statements.print');
Route::resource('operating-statements', 'OperatingStatementController')->except(['show']);

Route::resource('daily-sheets', 'DailySheetController');

Route::get('operator-assignments/print', 'OperatorAssignmentController@print')->name('operator-assignments.print');
Route::get('operator-assignments/{operator_assignment}/review/{status}', 'OperatorAssignmentController@review')->name('operator-assignments.review');
Route::resource('operator-assignments', 'OperatorAssignmentController');

Route::get('reports', 'ReportController@index')->name('reports.index');
Route::post('reports/getReport/{report_type}', 'ReportController@getReport')->name('reports.getReport');

Route::resource('work-orders', 'WorkOrderController');

Route::resource('cash-forms', 'CashFormController');

Route::resource('commissions', 'CommissionController')->only(['index']);

Route::resource('activity-logs', 'ActivityLogController')->only(['index']);

\Illuminate\Support\Facades\Auth::routes();

Route::get('/test', 'HomeController@test')->name('test');
