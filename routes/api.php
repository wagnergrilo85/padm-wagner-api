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

Route::prefix('v1')->group(function (){
    Route::resources([
        'user' => 'UserController',
        'access-level' => 'AccessLevelController',
        'client' => 'ClientController',
        'client-category' => 'ClientCategoryController',
        'client-group' => 'ClientGroupController',
        'branch-activity' => 'BranchActivityController',
        'product' => 'ProductController',
        'plan' => 'PlanController',
        'city' => 'CityController',
        'state' => 'StateController',
    ]);

    // Datatables
    Route::post('product-datatables', 'ProductController@datatables');
    Route::post('client-group-datatables', 'ClientGroupController@datatables');
    Route::post('client-datatables', 'ClientController@datatables');
    Route::post('client-category-datatables', 'ClientCategoryController@datatables');
    Route::post('access-level-datatables', 'AccessLevelController@datatables');
    Route::post('branch-activity-datatables', 'BranchActivityController@datatables');
    Route::post('plan-datatables', 'PlanController@datatables');
    Route::post('city-datatables', 'CityController@datatables');
    Route::post('state-datatables', 'StateController@datatables');

    // Reports - jasper
    Route::get('report-tests', 'ReportController@index');
    Route::get('report-city/{folder_tmp}', 'ReportController@generateReport');
    Route::get('reports-clean/{folder_tmp}', 'ReportController@clearReport');
    Route::get('get-pdf', 'ReportController@getPdf');

});
