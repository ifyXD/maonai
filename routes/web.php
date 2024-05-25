<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\CategoryVehiclesController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\LandingPage;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MechanicsController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\RequestVehicleController;
use App\Http\Controllers\TripDestinationController;
use App\Http\Controllers\userController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ContactController;
use App\Models\Parking;
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*DO NOT TOUCH IT YET*/
use App\Http\Controllers\UserContactController;

Route::get('/users/dashboard', [UserContactController::class, 'showUserContacts'])->name('user.contacts');



// Route to display the form for creating a new contact for a specific user
Route::get('/users/{userId}/contacts/create', [UserContactController::class, 'create'])->name('contacts.create');

// Route to insert a new contact record associated with a specific user
Route::post('/users/{userId}/contacts', [UserContactController::class, 'insert'])->name('contacts.insert');

// Route to display the index of users
Route::get('/users', [UserContactController::class, 'index'])->name('users.index');

// Route to display the form for creating a new contact for the currently logged-in user
Route::get('/contacts/create', [UserContactController::class, 'createForCurrentUser'])->name('contacts.createCurrentUser');

// Route to insert a new contact record associated with the currently logged-in user
Route::post('/contacts', [UserContactController::class, 'insertForCurrentUser'])->name('contacts.insertCurrentUser');


//EDIT AND UPDATE NEW!!!
// Define routes for editing and updating contacts
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');



// Define route for updating contact status
Route::put('contacts/{contact}/update-status', [ContactController::class, 'updateStatus'])->name('contacts.updateStatus');

// Route for displaying the contact creation form
Route::get('/', [ContactController::class, 'create'])->name('welcome');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');


// Route for showing the create contact form
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');

// Route for storing a new contact
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

// Route for updating a contact
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');






use App\Http\Controllers\profileController;
use App\Http\Controllers\reportController;
use App\Models\requestVehicle;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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


Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::middleware(['isAdmin'])->prefix('admin')->group(function () {

        // Route for showing all contacts
        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');




        Route::get('/quartet', [ContactController::class, 'quartetCard'])->name('contacts.cards.quartetCard');

        // Route to display declined contacts
        Route::get('/contacts/declined', [ContactController::class, 'declined'])->name('contacts.declined');
        // Route to display pending contacts
        Route::get('/contacts/pending', [ContactController::class, 'pending'])->name('contacts.pending');
        // Route for displaying accepted contacts
        Route::get('/contacts/accepted', [ContactController::class, 'accepted'])->name('contacts.accept');


        // Define routes for InvoiceController
        Route::get('/invoices/{contact_id}/generateWord', [InvoiceController::class, 'generateWord'])->name('invoices.generateWord');



        // Route for generating and downloading a PDF invoice for a specific contact
        Route::get('/invoices/generate-pdf/{contact_id}', [InvoiceController::class, 'generatePDF'])->name('invoices.generatePDF');


        // Route for displaying invoices associated with a specific contact
        Route::get('/invoices/{contact_id}', [InvoiceController::class, 'index'])->name('invoices.index');

        // Route for displaying the form to add new labor records for a specific contact
        Route::get('/invoices/createLabors/{contact_id}', [InvoiceController::class, 'createLabors'])->name('invoices.createLabors');

        // Route for storing new labor records for a specific contact
        Route::post('/invoices/storeLabors/{contact_id}', [InvoiceController::class, 'storeLabors'])->name('invoices.storeLabors');

        // Route for displaying the form to add new material records for a specific contact
        Route::get('/invoices/createMaterials/{contact_id}', [InvoiceController::class, 'createMaterials'])->name('invoices.createMaterials');

        // Route for storing new material records for a specific contact
        Route::post('/invoices/storeMaterials/{contact_id}', [InvoiceController::class, 'storeMaterials'])->name('invoices.storeMaterials');



        Route::post('/contacts_requests/store', [ContactRequestController::class, 'store'])->name('contacts_requests.store');
        Route::post('/contacts_requests/update_status', [ContactRequestController::class, 'updateStatus'])->name('update_status');


        Route::get('/contacts_requests', [ContactRequestController::class, 'getContactRequests'])->name('contacts_requests');
        Route::get('/accepted_requests', [ContactRequestController::class, 'showAcceptedRequests'])->name('accepted_requests');
        Route::get('/pending_requests', [ContactRequestController::class, 'showPendingRequests'])->name('pending_requests');
        Route::get('/declined_requests', [ContactRequestController::class, 'showDeclinedRequests'])->name('declined_requests');

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



        // Vehicles
        Route::get('/vehicle', [VehicleController::class, 'index']);
        Route::get('/vehiclesdata', [VehicleController::class, 'datausers']);
        Route::post('/addnewvehicle', [VehicleController::class, 'create']);
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
        Route::post('/editbyid', [MechanicsController::class, 'edit']);
        Route::post('/mechanic/deletebyid', [MechanicsController::class, 'delete']);



        //Drivers
        Route::get('/drivers', [DriverController::class, 'index']);
        Route::get('/driverdatatae', [DriverController::class, 'driverdata']);
        Route::post('/addnewDriver', [DriverController::class, 'create']);
        Route::post('/driver/edit', [DriverController::class, 'edit']);
        Route::post('/driver/deletebyid', [DriverController::class, 'delete']);
        //tripdestination



        Route::get('/destination', [TripDestinationController::class, 'index']);

        Route::post('/tripdestination', [TripDestinationController::class, 'create']);



        //fuels

        Route::get('/fuel', [FuelController::class, 'index']);
        Route::get('/fueldata', [FuelController::class, 'datafuels']);
        Route::post('/addnewfuel', [FuelController::class, 'create']);
        Route::post('fuel/edit', [FuelController::class, 'edit']);
        Route::post('/fuel/deletebyid', [FuelController::class, 'delete']);



        //Departments

        Route::get('/departments', [DepartmentController::class, 'index']);
        Route::get('/departmentdata', [DepartmentController::class, 'datausers']);
        Route::post('/addnewdepartment', [DepartmentController::class, 'create']);
        Route::post('/editbyid', [DepartmentController::class, 'edit']);
        Route::post('/department/deletebyid', [DepartmentController::class, 'delete']);





        //User Managements

        Route::get('/create', [userController::class, 'index']);
        Route::get('/users', [userController::class, 'store']);
        Route::get('/recovery', [userController::class, 'destory']);
        Route::post('/addnewuser', [userController::class, 'create']);
        Route::get('/usersdata', [userController::class, 'tableusers']);
        Route::post('user/editbyid', [userController::class, 'edit']);
        Route::post('/users/deletebyid', [userController::class, 'delete']);




        Route::get('/profile', [profileController::class, 'index']);




//Reports
Route::get('/reports', [reportController::class, 'index']);





//RequestVehicle












//Technical Request




        // Parking area

        Route::get('/parking', [ParkingController::class, 'index'])->name('parking.index');
        Route::get('/parkingtae', [ParkingController::class, 'store']);
    });

    Route::middleware(['isUser'])->prefix('user')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'userdashboard'])->name('user.dashboard');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


        Route::get('/vehiclesdata', [VehicleController::class, 'datausers']);



        Route::get('/profile', [profileController::class, 'index']);
    });
});
