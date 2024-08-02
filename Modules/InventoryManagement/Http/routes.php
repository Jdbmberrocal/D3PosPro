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

// Route::prefix('inventorymanagement')->group(function() {
Route::group(['middleware' => ['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'inventorymanagement', 'namespace' => 'Modules\InventoryManagement\Http\Controllers'], function () {

    Route::get('install', 'InstallController@index');
    Route::post('install', 'InstallController@install');
    Route::get('install/uninstall', 'InstallController@uninstall');
    Route::get('install/update', 'InstallController@update');
    
    Route::get('/', 'InventoryManagementController@index');

    Route::post("createNewInventory" , "InventoryManagementController@createNewInventory");
    Route::get("showInventoryList" , "InventoryManagementController@showInventoryList")->name("showInventoryList");
    Route::get("makeInventory/{id}" , "InventoryManagementController@makeInevtory");
    Route::get("getProductData" , "InventoryManagementController@getProductData");
    Route::get("inventory/get_products/{id}" , "InventoryManagementController@getProducts");
    Route::post("inventory/get_purchase_entry_row" , "InventoryManagementController@getPurchaseEntryRow");
    Route::post("updateProductQuantity" , "InventoryManagementController@updateProductQuantity");
    Route::post("saveInventoryProducts" , "InventoryManagementController@saveInventoryProducts");
    Route::put("update/status/{id}" , "InventoryManagementController@updateStatus");
    Route::get("showInventoryReports/{id}/{branch_id}" , "InventoryManagementController@showInventoryReports");
    Route::get("inventoryIncreaseReports/{inventory_id}/{branch_id}" , "InventoryManagementController@inventoryIncreaseReports");
    Route::get("inventoryDisabilityReports/{inventory_id}/{branch_id}" , "InventoryManagementController@inventoryDisabilityReports");

});
