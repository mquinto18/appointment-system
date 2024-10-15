<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//set side bar active dynamic

function set_active($route){
    if(is_array($route)){
        return is_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}


// Public route for the welcome page
Route::get('/', function () {
    return view('home');
});



// Authentication routes (register, login, etc.)
Route::controller(AuthController::class)->group(function () {
    // Register routes
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    // Login routes
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    
    // Logout route (typically a POST request)
    Route::post('logout', 'logout')->name('logout');
});

// User dashboard (protected with middleware)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
});

// Admin dashboard (protected with middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/home', [HomeController::class, 'adminIndex'])->name('admin/home');
    Route::get('admin/profile', [HomeController::class, 'profileSettings'])->name('profile.settings');
    Route::put('admin/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/update-picture', [ProfileController::class, 'profileUpdate'])->name('profile.update_picture');
    Route::get('admin/security', [HomeController::class, 'securitySettings'])->name('security.settings');
    Route::put('profile/update', [ProfileController::Class, 'securityUpdate'])->name('security.update');
    Route::put('profile/security/update', [ProfileController::class, 'changePassword'])->name('changePassword.update');
    Route::delete('profile/security/delete', [ProfileController::class, 'accountDelete'])->name('account.delete');

    Route::get("admin/adminAcc", [AdminController::class, 'adminAcc'])->name('admin');
    Route::post("admin/adminAcc/save", [AdminController::class, 'adminSave'])->name('admin.save');
    Route::delete('admin/adminAcc/destroy/{id}', [AdminController::class, 'adminDestroy'])->name('admin.delete');
    Route::get('admin/adminAcc/edit{id}', [AdminController::class, 'adminEdit'])->name('admin.edit');
    Route::put('admin/adminAcc/update{id}', [AdminController::class, 'adminUpdate'])->name('admin.update');

    Route::get('admin/userAcc', [UserController::class, 'userAcc'])->name('user');
    Route::post('admin/userAcc/save', [UserController::class, 'userSave'])->name('user.save');
    Route::get('admin/userAcc/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');
    Route::put('admin/userAcc/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');

    Route::get('admin/doctorAcc', [DoctorController::class, 'doctorAcc'])->name('doctor');
    Route::post('admin/doctorAcc/save', [DoctorController::class, 'doctorSave'])->name('doctor.save');
    Route::get('admin/doctorAcc/edit/{id}', [DoctorController::class, 'doctorEdit'])->name('doctor.edit');
    Route::put('admin/doctorAcc/update/{id}', [DoctorController::class, 'doctorUpdate'])->name('doctor.update');

    Route::get('admin/appointment', [AppointmentController::class, 'appointment'])->name('appointment');
    Route::post('admin/appointment/save', [AppointmentController::class, 'appointmentSave'])->name('appointment.save');
    // route for approve
    Route::post('admin/appointment/approve/{id}', [AppointmentController::class, 'approve'])->name('appointments.approve');
    // route for completed
    Route::post('admin/appointment/completed/{id}', [AppointmentController::class, 'completed'])->name('appointments.complete');
    // route for rejected
    Route::post('admin/appointment/rejected/{id}', [AppointmentController::class, 'rejected'])->name('appointments.reject');
    

    Route::get('admin/appointments/pending', [AppointmentController::class, 'pending'])->name('appointments.pending');
    Route::get('admin/appointments/approved', [AppointmentController::class, 'approved'])->name('appointments.approved');
    Route::get('admin/appointments/completed', [AppointmentController::class, 'completedAppoint'])->name('appointments.completed');
    Route::get('admin/appointments/rejected', [AppointmentController::class, 'rejectedAppoint'])->name('appointments.rejected');
    Route::get('admin/appointments/canceled', [AppointmentController::class, 'canceledAppoint'])->name('appointments.canceled');

    Route::get('admin/appointments/edit/{id}', [AppointmentController::class, 'appointmentEdit'])->name('appointments.edit');
    Route::put('admin/appointments/update/{id}', [AppointmentController::class, 'appointmentUpdate'])->name('appointments.update');
    Route::delete('admin/appointments/delete/{id}', [AppointmentController::class, 'appointmentDelete'])->name('appointments.destroy');

    Route::get('admin/appointment/emergency', [AppointmentController::class, 'emergency'])->name('emergency');


    Route::get('admin/invoice', [InvoiceController::class, 'invoice'])->name('invoice');
    Route::get('admin/invoice/print/{id}', [InvoiceController::class, 'invoicePrint'])->name('invoince.print');
    Route::put('admin/invoice/save/{id}', [InvoiceController::class, 'invoiceSave'])->name('invoice.items');
    Route::get('admin/invoice/generate/{id}', [InvoiceController::class, 'printInvoice'])->name('invoice.print');

}); 
