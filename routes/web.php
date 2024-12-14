<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superadmin\{
    EventController,
    ParticipantController,
    CertifController,
    UserController,
    SettingController,
    ProfileController,
};
use App\Http\Controllers\Auth\{
    ForgotPasswordController,
    RegisterController
};
use App\Http\Controllers\HomeController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\{Auth, Mail, Storage};

// Authentication Routes
Auth::routes();

// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', fn() => view('home'));

// Registration Routes
Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/', [RegisterController::class, 'register'])->name('register.post');
});

// Forgot Password Routes

// FAQ Route
Route::get('/faq', fn() => view('faq'))->name('faq');


// Superadmin Routes
Route::group(['middleware' => ['role:super-admin'], 'prefix' => 'superadmin'], function () {
    Route::get('/', [HomeController::class, 'superadmin'])->name('superadmin');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('superadmin.profile.index');
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('superadmin.profile.uploadPhoto');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('superadmin.profile.deletePhoto');

    // Event Routes

    Route::prefix('event')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('superadmin.event');
        Route::get('create', [EventController::class, 'create'])->name('superadmin.event.create');
        Route::post('store', [EventController::class, 'store'])->name('superadmin.event.store');
        Route::get('edit/{id}', [EventController::class, 'edit'])->name('superadmin.event.edit');
        Route::put('update/{id}', [EventController::class, 'update'])->name('superadmin.event.update');
        Route::get('show/{id}', [EventController::class, 'show'])->name('superadmin.event.show');
        Route::get('destroy/{id}', [EventController::class, 'destroy'])->name('superadmin.event.destroy');
    });
    Route::get('event/destroy/{id}', [EventController::class, 'destroy'])->name('superadmin.event.destroy');
    Route::get('participant/destroy_all/{id}', [ParticipantController::class, 'destroy_all'])->name('superadmin.participant.destroy_all');


    // Participant Routes
    Route::prefix('participant')->group(function () {
        Route::get('export', [ParticipantController::class, 'export_template'])->name('superadmin.participant.export_template');
        Route::get('import/create/{id}', [ParticipantController::class, 'import_create'])->name('superadmin.participant.import.create');
        Route::post('import/store', [ParticipantController::class, 'import_store'])->name('superadmin.participant.import.store');
        Route::get('/edit/{id}', [ParticipantController::class, 'edit'])->name('superadmin.participant.edit');
        Route::put('/update/{id}', [ParticipantController::class, 'update'])->name('superadmin.participant.update');
        Route::get('/destroy/{id}', [ParticipantController::class, 'destroy'])->name('superadmin.participant.destroy');
    
    });

    // Certificate Routes
    Route::prefix('certificate')->group(function () {

        Route::get('create/{id}', [CertifController::class, 'create'])->name('superadmin.certificate.create');
        Route::get('store/{id}', [CertifController::class, 'store'])->name('superadmin.certificate.store');
        Route::get('show/{id}', [CertifController::class, 'show'])->name('superadmin.certificate.show');
        Route::get('pdf/{id}', [CertifController::class, 'pdf'])->name('superadmin.certificate.pdf');
        Route::get('createTemplate', [CertifController::class, 'createTemplate'])->name('superadmin.certificate.createTemplate');
        Route::post('storeTemplate', [CertifController::class, 'storeTemplate'])->name('superadmin.certificate.storeTemplate');
        Route::get('editTemplate/{id}', [CertifController::class, 'editTemplate'])->name('superadmin.certificate.editTemplate');
        Route::put('updateTemplate/{id}', [CertifController::class, 'updateTemplate'])->name('superadmin.certificate.updateTemplate');
        Route::get('showTemplate/{id}', [CertifController::class, 'showTemplate'])->name('superadmin.certificate.showTemplate');
    });

    // User Management Routes
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('superadmin.user');
        Route::get('create', [UserController::class, 'create'])->name('superadmin.user.create');
        Route::post('store', [UserController::class, 'store'])->name('superadmin.user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('superadmin.user.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('superadmin.user.update');
        Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('superadmin.user.destroy');
    });


    //bg
    Route::get('/bg', [EventController::class, 'indexBg']);
    Route::post('/remove-bg', [EventController::class, 'removeBackground'])->name('remove.bg');
});

// Admin Routes
Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [HomeController::class, 'admin'])->name('admin.home');

    // Home Admin
    Route::get('/', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.home');

    // route event
    Route::get('/event', [App\Http\Controllers\admin\EventController::class, 'index'])->name('admin.event');
    Route::get('/event/create', [App\Http\Controllers\admin\EventController::class, 'create'])->name('admin.event.create');
    Route::post('/event/store', [App\Http\Controllers\admin\EventController::class, 'store'])->name('admin.event.store');
    Route::get('/event/edit/{id}', [App\Http\Controllers\admin\EventController::class, 'edit'])->name('admin.event.edit');
    Route::put('/event/update/{id}', [App\Http\Controllers\admin\EventController::class, 'update'])->name('admin.event.update');
    Route::get('/event/show/{id}', [App\Http\Controllers\admin\EventController::class, 'show'])->name('admin.event.show');
    Route::get('/event/destroy/{id}', [App\Http\Controllers\admin\EventController::class, 'destroy'])->name('admin.event.destroy');


    // route participant 
    Route::get('/participant/export', [App\Http\Controllers\admin\ParticipantController::class, 'export_template'])->name('admin.participant.export_template');
    Route::get('/participant/import/create/{id}', [App\Http\Controllers\admin\ParticipantController::class, 'import_create'])->name('admin.participant.import.create');
    Route::get('/destroy_all/{id}', [App\Http\Controllers\admin\ParticipantController::class, 'destroy_all'])->name('admin.participant.destroy_all');
    Route::post('/participant/import/store', [App\Http\Controllers\admin\ParticipantController::class, 'import_store'])->name('admin.participant.import.store');
    Route::get('/participant/edit/{id}', [App\Http\Controllers\admin\ParticipantController::class, 'edit'])->name('admin.participant.edit');
    Route::put('/participant/update/{id}', [App\Http\Controllers\admin\ParticipantController::class, 'update'])->name('admin.participant.update');
    Route::get('/participant/destroy/{id}', [App\Http\Controllers\admin\ParticipantController::class, 'destroy'])->name('admin.participant.destroy');

    
    // route certif 
    Route::get('/certificate/create/{id}', [App\Http\Controllers\admin\CertifController::class, 'create'])->name('admin.certificate.create');
    Route::get('/certificate/store/{id}', [App\Http\Controllers\admin\CertifController::class, 'store'])->name('admin.certificate.store');
    Route::get('/certificate/show/{id}', [App\Http\Controllers\admin\CertifController::class, 'show'])->name('admin.certificate.show');
    Route::get('/certificate/pdf/{id}', [App\Http\Controllers\admin\CertifController::class, 'pdf'])->name('admin.certificate.pdf');


});


//setting
Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting');
Route::post('/setting/updateUser/{id}', [App\Http\Controllers\SettingController::class, 'updateUser'])->name('setting.updateUser');


//template bar
Route::group(['middleware' => ['role:super-admin'], 'prefix' => 'superadmin'], function () {
    Route::get('/certificate/template', [CertifController::class, 'template'])->name('certificate.template');
});

//add template
Route::group(['middleware' => ['role:super-admin'], 'prefix' => 'superadmin'], function () {
    Route::post('/certificate/store', [CertifController::class, 'store'])->name('certificate.store');
});
Route::get('/templates', [CertifController::class, 'index'])->name('templates.index');
Route::get('/generate/{template_id}', [CertifController::class, 'generate'])->name('generate');


// Certificate Verification
Route::get('/certificate/verification', fn() => view('check'))->name('certificate.verification');
Route::get('/certificate/result', fn() => view('virified', [
    'certificateHolder' => 'John Doe',
    'uid' => 'Cert1234-5678-ABCD',
    'eventName' => 'UI/UX Design',
    'issuedBy' => 'Maxy Academy',
    'issueDate' => 'November 20, 2024',
]))->name('virified');


Route::get('certificate/verification',[App\Http\Controllers\LandingController::class, 'indexVerification'])->name('certif.verfication');
Route::post('certificate/verification/result',[App\Http\Controllers\LandingController::class, 'storeVerification'])->name('certif.verfication.result');
Route::get('certificate/pdf/{id}',[App\Http\Controllers\admin\CertifController::class, 'pdf'])->name('certif.pdf');

Route::post('/superadmin/certificate/save-margin', [CertifController::class, 'saveMargin']);
