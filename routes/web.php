<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSlotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CashierProfileController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\AppointmentSlotController;
use App\Http\Controllers\DoctorSlotController;
use App\Http\Middleware\Cashier;
use App\Http\Middleware\Doctor;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//set side bar active dynamic

// function set_active($route){
//     if(is_array($route)){
//         return is_array(Request::path(), $route) ? 'active' : '';
//     }
//     return Request::path() == $route ? 'active' : '';
// }


// Public route for the welcome page
Route::get('/', function () {
    return view('home');
});

Route::get('user/dashboard/about', [HomeController::class, 'aboutMore'])->name('appointment.aboutMore');

// Authentication routes (register, login, etc.)
Route::controller(AuthController::class)->group(function () {
    // Register routes
    Route::get('register', 'register')->name('register');
    Route::get('forgotPassword', 'forgotPassword')->name('forgotPassword');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('/authentication', 'authentication')->name('authentication');
    Route::post('/verify-pin', 'verifyPin')->name('verify.pin');
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::post('/reset-password', 'updatePassword')->name('password.update');
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');


    // Login routes
    Route::get('login', 'login')->name('login');
    Route::get('otp', 'otp')->name('otp');
    Route::post('login', 'loginAction')->name('login.action');

    // Logout route (typically a POST request)
    Route::post('logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'doctor'])->group(function () {
    Route::get('doctor/home', [DoctorController::class, 'doctorIndex'])->name('doctor/home');

    Route::get('doctor/appointment', [DoctorController::class, 'doctorAppointment'])->name('doctorAppointment');
    Route::get('doctor/appointment/today', [DoctorController::class, 'todayAppointment'])->name('todayAppointment');
    Route::delete('doctor/appointments/delete/{id}', [DoctorController::class, 'appointmentdoctorDelete'])->name('appointments.doctoDestroy');
    Route::get('doctor/profile', [DoctorController::class, 'profiledoctorSettings'])->name('doctorProfile.settings');
    Route::put('doctor/profile-update', [DoctorController::class, 'profiledoctorUpdate'])->name('doctorProfile.update');
    Route::post('/profile/update-picture-doctor', [DoctorController::class, 'profileupdateDoctorPicture'])->name('profile.updateDoctor_picture');
    Route::get('doctor/security', [DoctorController::class, 'securitydoctorSettings'])->name('doctorSecurity.settings');
    Route::put('doctor/update', [DoctorController::class, 'securitydoctorUpdate'])->name('doctorSecurity.update');
    Route::put('doctor/profile/security/update', [DoctorController::class, 'changeuserPassword'])->name('doctorchangePassword.update');
    Route::delete('doctor/profile/security/delete', [DoctorController::class, 'accountDelete'])->name('doctorAccount.delete');
    Route::get('doctor/appointments/edit/{id}', [DoctorController::class, 'appointmentEdit'])->name('appointments.doctorEdit');
    Route::put('doctor/appointments/update/{id}', [DoctorController::class, 'appointmentDoctorUpdate'])->name('appointments.doctorUpdate');
    Route::get('doctor/appointments/follow-up/{id}', [DoctorController::class, 'appointmentdoctorFollowUp'])->name('appointments.doctorfollowUp');
    Route::put('doctor/followup/update/{id}', [DoctorController::class, 'appointmentdoctorFollowUpSave'])->name('appointments.doctorfollowUpPost');
    Route::get('/doctor/monthly-slots', [DoctorSlotController::class, 'getMonthlySlotsDoctor']);
});
Route::middleware(['auth', 'cashier'])->group(function () {
    Route::get('cashier/home', [CashierController::class, 'cashierIndex'])->name('cashier/home');

    Route::get('cashier/invoice', [CashierController::class, 'invoiceCashier'])->name('cashier.invoice');
    Route::get('cashier/invoice/print/{id}', [CashierController::class, 'cashierinvoicePrint'])->name('cashierinvoince.print');
    Route::put('cashier/invoice/save/{id}', [CashierController::class, 'cashierinvoiceSave'])->name('cashierinvoice.items');
    Route::get('cashier/invoice/generate/{id}', [CashierController::class, 'cashierprintInvoice'])->name('invoiceCashier.print');

    Route::get('cashier/reports/generate/{interval?}', [CashierController::class, 'cashierprintReports'])->name('report.print');

    Route::get('cashier/reports', [ReportsController::class, 'reports'])->name('cashierReports');
    Route::get('cashier/profile', [CashierProfileController::class, 'profileSettings'])->name('cashierProfile.settings');
    Route::put('cashier/profile', [CashierProfileController::class, 'profileUpdate'])->name('cashierProfile.update');
    Route::get('cashier/security', [CashierProfileController::class, 'securitySettings'])->name('cashierSecurity.settings');
    Route::put('cashier/update', [CashierProfileController::class, 'securityUpdate'])->name('cashierSecurity.update');
    Route::put('cashier/profile/security/update', [CashierProfileController::class, 'changePassword'])->name('cashierchangePassword.update');
    Route::delete('cashier/profile/security/delete', [CashierProfileController::class, 'accountDelete'])->name('cashierAccount.delete');
    Route::delete('cashier/invoice/delete/{id}', [CashierController::class, 'appointmentDelete'])->name('appointmentsinvoice.destroy');
});

// User dashboard (protected with middleware)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard/appointment', [HomeController::class, 'patient_appointment'])->name('appointment.user');
    Route::post('/dashboard/appointment/store', [HomeController::class, 'patientStore'])->name('appointment.store');

    Route::get('/dashboard/appointment/patientDetails', [HomeController::class, 'patientDetails'])->name('patient.details');
    Route::get('/monthly-slots', [AppointmentSlotController::class, 'getMonthlySlots']);
    Route::post('/dashboard/appointment/storePatient', [HomeController::class, 'storePatientDetails'])->name('appointments.storePatientDetails');
    Route::get('/dashboard/appointment/confirmDetails', [HomeController::class, 'confirmDetails'])->name('appointments.confirmDetails');
    Route::post('/dashboard/appointment/appointment-confirm', [HomeController::class, 'appointConfirm'])->name('appointments.confirm');
    Route::get('/dashboard/appointment/appointment-booked', [HomeController::class, 'appointmentBooked'])->name('appointments.booked');
    Route::post('/dashboard/appointment/appointment-cancelled/{id}', [HomeController::class, 'appointmentCancel'])->name('appointments.cancel');
    Route::post('/dashboard/appointment/appointment-reschedule/{id}', [HomeController::class, 'appointmentReschedule'])->name('appointments.reschedule');
    Route::delete('/dashboard/appointment/appointment-deleted/{id}', [HomeController::class, 'appointmentDelete'])->name('appointments.delete');
    Route::get('/dashboard/appointment/appointment-qrcode/{id}', [HomeController::class, 'appointmentQrcode'])->name('appointments.downloadQR');
    Route::get('/dashboard/appointment/download-qrcode/{appointment}', [HomeController::class, 'downloadQRPdf'])->name('appointments.downloadQRPdf');
    Route::get('/dashboard/appointment/medical-downlaod/{id}', [MedicalController::class, 'medicalDownload'])->name('medicalcert.download');
    Route::post('/dashboard/appointment/rating/{id}', [HomeController::class, 'appointmentRate'])->name('appointments.rate');

    Route::get('/dashboard/appointments/edit/{id}', [HomeController::class, 'appointmentuserEdit'])->name('appointments.userEdit');
    Route::put('/dashboard/appointments/update/{id}', [HomeController::class, 'appointmentuserUpdate'])->name('appointments.userUpdate');
    Route::get('user/profile', [HomeController::class, 'profileuserSettings'])->name('userProfile.settings');
    Route::put('user/profile', [HomeController::class, 'profileuserUpdate'])->name('userProfile.update');
    Route::get('user/security', [HomeController::class, 'securityuserSettings'])->name('userSecurity.settings');
    Route::put('user/update', [HomeController::class, 'securityuserUpdate'])->name('userSecurity.update');
    Route::put('user/profile/security/update', [HomeController::class, 'changeuserPassword'])->name('userchangePassword.update');
    Route::delete('user/profile/security/delete', [HomeController::class, 'accountDelete'])->name('userAccount.delete');
    Route::post('user/dashboard/contactSend', [HomeController::class, 'contactSend'])->name('appointment.contactSend');

    Route::post('/profile/update-picture-User', [HomeController::class, 'updateProfilePictureuser'])->name('profile.updateuser_picture');
});

// Admin dashboard (protected with middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/home', [HomeController::class, 'adminIndex'])->name('admin/home');
    Route::get('admin/profile', [HomeController::class, 'profileSettings'])->name('profile.settings');
    Route::put('admin/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update_picture');

    Route::get('admin/security', [HomeController::class, 'securitySettings'])->name('security.settings');
    Route::put('profile/update', [ProfileController::class, 'securityUpdate'])->name('security.update');
    Route::put('profile/security/update', [ProfileController::class, 'changePassword'])->name('changePassword.update');
    Route::delete('profile/security/delete', [ProfileController::class, 'accountDelete'])->name('account.delete');

    Route::get("admin/adminAcc", [AdminController::class, 'adminAcc'])->name('admin');
    Route::post("admin/adminAcc/save", [AdminController::class, 'adminSave'])->name('admin.save');
    Route::delete('admin/adminAcc/destroy/{id}', [AdminController::class, 'adminDestroy'])->name('admin.delete');
    Route::get('admin/adminAcc/edit{id}', [AdminController::class, 'adminEdit'])->name('admin.edit');
    Route::put('admin/adminAcc/update{id}', [AdminController::class, 'admi  nUpdate'])->name('admin.update');
    Route::get('admin/userAcc', [UserController::class, 'userAcc'])->name('user');
    Route::post('admin/userAcc/save', [UserController::class, 'userSave'])->name('user.save');
    Route::get('admin/userAcc/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');
    Route::put('admin/userAcc/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');

    Route::get('admin/doctorAcc', [DoctorController::class, 'doctorAcc'])->name('doctor');
    Route::post('admin/doctorAcc/save', [DoctorController::class, 'doctorSave'])->name('doctor.save');
    Route::get('admin/doctorAcc/edit/{id}', [DoctorController::class, 'doctorEdit'])->name('doctor.edit');
    Route::put('admin/doctorAcc/update/{id}', [DoctorController::class, 'doctorUpdate'])->name('doctor.update');

    Route::get('admin/cashierAcc', [CashierController::class, 'CashierAcc'])->name('cashier');
    Route::post('admin/cashierAcc/save', [CashierController::class, 'cashierSave'])->name('cashier.save');
    Route::get('admin/cashierAcc/edit/{id}', [CashierController::class, 'cashierEdit'])->name('cashier.edit');
    Route::put('admin/cashierAcc/update/{id}', [CashierController::class, 'cashierUpdate'])->name('cashier.update');

    Route::get('admin/reports', [ReportsController::class, 'reports'])->name('reports');


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

    Route::get('admin/appointments/follow-up/{id}', [AppointmentController::class, 'appointmentFollowUp'])->name('appointments.followUp');
    Route::post('admin/appointments/follow-up/save/{id}', [AppointmentController::class, 'appointmentFollowUpStore'])->name('appointments.followUpPost');
    Route::put('admin/appointments/update/{id}', [AppointmentController::class, 'appointmentUpdate'])->name('appointments.update');
    Route::delete('admin/appointments/delete/{id}', [AppointmentController::class, 'appointmentDelete'])->name('appointments.destroy');

    Route::get('admin/appointment/emergency', [AppointmentController::class, 'emergency'])->name('emergency');


    Route::get('admin/invoice', [InvoiceController::class, 'invoice'])->name('invoice');
    Route::get('admin/invoice/print/{id}', [InvoiceController::class, 'invoicePrint'])->name('invoince.print');
    Route::put('admin/invoice/save/{id}', [InvoiceController::class, 'invoiceSave'])->name('invoice.items');
    Route::get('admin/invoice/generate/{id}', [InvoiceController::class, 'printInvoice'])->name('invoice.print');

    Route::get('admin/medicalcert', [MedicalController::class, 'medicalcert'])->name('medicalcert');
    Route::get('admin/medicalcert/print/{id}', [MedicalController::class, 'medicalcertPrint'])->name('medicalcert.print');

    Route::get('admin/prescription', [PrescriptionController::class, 'prescription'])->name('prescription');
    Route::get('admin/prescription/print/{id}', [PrescriptionController::class, 'prescriptionPrint'])->name('prescription.print');
    Route::put('admin/prescription/save/{id}', [PrescriptionController::class, 'prescriptionSave'])->name('prescription.items');
    Route::get('admin/prescription/generate/{id}', [PrescriptionController::class, 'printPrescription'])->name('prescription.generate');

    Route::get('/admin/monthly-slots', [AdminSlotController::class, 'getMonthlySlotsAdmin']);
});
