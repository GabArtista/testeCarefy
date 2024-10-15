<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\GuideController;
use Illuminate\Support\Facades\Route;

// Rotas Públicas
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/signin', [HomeController::class, 'signin'])->name('login');
Route::get('/signup', [HomeController::class, 'signup'])->name('register');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/contato', [HomeController::class, 'contato'])->name('contato');
Route::get('/support', [HomeController::class, 'support'])->name('support');
Route::post('/send-email', [MailController::class, 'sendEmail'])->name('send.email');

// Rota para listar todos os pacientes para criar uma nova internação
Route::get('/hospitalization/patients', [GuideController::class, 'listPatients'])->name('hospitalization.listPatients');
// Rota para criar uma nova internação junto com o cadastro de um novo paciente
Route::get('/hospitalization/create-with-patient', [GuideController::class, 'createWithPatient'])->name('hospitalization.createWithPatient');


Route::get('/hospitalization/csv', [GuideController::class, 'csvimport'])->name('hospitalization.csvimport');
Route::get('/guides-import', [GuideController::class, 'confirmImport'])->name('guides.import');
Route::post('/guides-import', [GuideController::class, 'confirmImport'])->name('hospitalization.confirmImport');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->only(['update', 'edit']);
    Route::get('/appointments/load', [AppointmentController::class, 'load'])->name('appointments.load');
    Route::get('/appointments/load-all', [AppointmentController::class, 'loadAll'])->name('appointments.load-all');
    Route::get('/appointments/doctor/load', [AppointmentController::class, 'loadDoctor'])->name('appointments.doctor.load');
    Route::get('/appointments/confirm/{id}', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::get('/appointments/cancel/{id}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::resource('appointments', AppointmentController::class);

    Route::get('/doctors/available', [DoctorController::class, 'getAvailableByDate'])->name('doctors.available');
    Route::resource('doctors', DoctorController::class);

    Route::get('/patients/available', [PatientController::class, 'getAvailableByDate'])->name('patients.available');
    Route::resource('patients', PatientController::class);

    Route::resource('admins', UserController::class);
    Route::get('/users/history', [UserController::class, 'history'])->name('users.history');

    // Rota para listar internações
    Route::get('/hospitalization', [GuideController::class, 'index'])->name('hospitalization.index');

    // Rota para visualizar detalhes da internação
    Route::get('/hospitalization/{id}', [GuideController::class, 'show'])->name('hospitalization.show');

    // Rota para criar uma nova internação para um paciente existente
    Route::get('/hospitalization/create/{patient}', [GuideController::class, 'createForPatient'])->name('hospitalization.createForPatient');



    // Rota para salvar uma nova internação
    Route::post('/hospitalization/store', [GuideController::class, 'store'])->name('hospitalization.store');

    // Rota para salvar um paciente e uma internação
    Route::post('/hospitalization/store-with-patient', [GuideController::class, 'storeWithPatient'])->name('hospitalization.storeWithPatient');

    // Adicione esta linha dentro do grupo de middleware 'auth' em routes/web.php
    Route::post('/hospitalization/import', [GuideController::class, 'import'])->name('hospitalization.import');


});
