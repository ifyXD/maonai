<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\CategoryVehiclesController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\LandingPage;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MechanicsController;
use App\Http\Controllers\TripDestinationController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/contacts_requests/store', [ContactRequestController::class, 'store'])->name('contacts_requests.store');
Route::post('/contacts_requests/update_status', [ContactRequestController::class, 'updateStatus'])->name('update_status');


Route::get('/contacts_requests', [ContactRequestController::class, 'getContactRequests'])->name('contacts_requests');
Route::get('/accepted_requests', [ContactRequestController::class, 'showAcceptedRequests'])->name('accepted_requests');
Route::get('/pending_requests', [ContactRequestController::class, 'showPendingRequests'])->name('pending_requests');
Route::get('/declined_requests', [ContactRequestController::class, 'showDeclinedRequests'])->name('declined_requests');

Route::get('/data_counts', [ContactRequestController::class, 'showDataCounts'])->name('data_counts');
Route::get('/data-counts', [ContactRequestController::class, 'getDataCounts'])->name('data_counts');


// In routes/web.php

Route::get('/export/accepted/requests/pdf', [ContactRequestController::class, 'exportAcceptedRequestsPDF'])->name('export.accepted.requests.pdf');
// Define the route for exporting individual accepted request as PDF
Route::get('/export-individual-accepted-request-pdf/{requestId}', [ContactRequestController::class, 'exportIndividualAcceptedRequestPDF'])
    ->name('export.individual.accepted.request.pdf');


    
// Route for updating a request
Route::put('/update-request/{requestId}', [ContactRequestController::class, 'updateRequest'])->name('update.request');
Route::post('/update-status', [ContactRequestController::class, 'updateStatus'])->name('update_status');
Route::get('/edit-request/{id}', [ContactRequestController::class, 'editRequest'])->name('edit_request');
Route::put('/update-request/{id}', [ContactRequestController::class, 'updateRequest'])->name('update_request');
Route::put('/edit-request/{id}', [ContactRequestController::class, 'updateRequest'])->name('edit_request');

Route::get('/contacts_requests/{id}/edit', [ContactRequestController::class, 'edit'])->name('contacts_requests.edit');
Route::put('/contacts_requests/{id}', [ContactRequestController::class, 'update'])->name('contacts_requests.update');





//JRMS Landing Page Interfaces
Route::get('/', [LandingPage::class, 'index']);


Route::get('/welcome', [ContactRequestController::class, 'create'])->name('welcome');

Route::post('/adminuser/editbyid', [VehicleController::class, 'edit']);

Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::middleware(['isAdmin'])->prefix('admin')->group(function () {


    
Route::post('/contacts_requests/store', [ContactRequestController::class, 'store'])->name('contacts_requests.store');
Route::post('/contacts_requests/update_status', [ContactRequestController::class, 'updateStatus'])->name('update_status');


Route::get('/contacts_requests', [ContactRequestController::class, 'getContactRequests'])->name('contacts_requests');
Route::get('/accepted_requests', [ContactRequestController::class, 'showAcceptedRequests'])->name('accepted_requests');
Route::get('/pending_requests', [ContactRequestController::class, 'showPendingRequests'])->name('pending_requests');
Route::get('/declined_requests', [ContactRequestController::class, 'showDeclinedRequests'])->name('declined_requests');

Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::get('/vehiclesdata', [VehicleController::class, 'datausers']);
Route::post('/addnewvehicle', [VehicleController::class, 'create']);
Route::get('/vehicle', [VehicleController::class, 'index']);
Route::post('/vehicle/deletebyid', [VehicleController::class, 'delete']);


//Maintenances



Route::get('/maintenancedata', [MaintenanceController::class, 'maintenance']);
Route::post('/addmaintenance', [MaintenanceController::class, 'create']);
Route::post('/editbyid', [MaintenanceController::class, 'edit']);
Route::get('/maintenance', [MaintenanceController::class, 'index']);
Route::post('/maintenance/deletebyid', [MaintenanceController::class, 'delete']);


//Mechanics

Route::get('/mechanics', [MechanicsController::class, 'index']);
Route::get('/mechanicsdata', [MechanicsController::class, 'mechanics']);
Route::post('/addmechanics', [MechanicsController::class, 'create']);
Route::post ('/editbyid', [MechanicsController::class, 'edit']);
Route::post('/mechanic/deletebyid', [MechanicsController::class, 'delete']);



//tripdestination



Route::get('/destination', [TripDestinationController::class, 'index']);

Route::post('/tripdestination', [TripDestinationController::class, 'create']);



//partking

Route::get('/fuel', [FuelController::class, 'index']);




//Departments

Route::get('/departments', [DepartmentController::class, 'index']);
Route::post('/admin/datausers', [DepartmentController::class, 'datausers']);
Route::post('/admin/yawa', [DepartmentController::class, 'create']);
Route::post('/admin/edit', [DepartmentController::class, 'edit']);

});

Route::middleware(['isUser'])->prefix('user')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'userdashboard'])->name('user.dashboard');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
});

