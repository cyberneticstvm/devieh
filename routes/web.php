<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\CampPatientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('web.index');
})->name('index');

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login');

Route::middleware(['web'])->group(function () {
    Route::prefix('admin/')->controller(UserController::class)->group(function () {
        Route::post('login', 'login')->name('signin');
    });
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('admin/')->controller(UserController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::post('/user/branch/update', [UserController::class, 'updateBranch'])->name('user.branch.update');
    });
});

Route::prefix('admin')->middleware(['web', 'auth', 'branch'])->group(function () {

    Route::prefix('/ajax')->controller(AjaxController::class)->group(function () {
        Route::post('/appointment/time', 'getAppointmentTime')->name('ajax.appointment.time');
        Route::get('/fetch/product/{id}', 'fetchProduct')->name('ajax.product.fetch');
        Route::get('/fetch/category/product/{id}', 'fetchProductsByCategory')->name('ajax.product.by.category.fetch');
    });


    Route::prefix('/user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/create', 'store')->name('user.save');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::put('/edit/{id}', 'update')->name('user.update');
        Route::get('/delete/{id}', 'destroy')->name('user.delete');
        Route::get('/logout', 'logout')->name('logout');
    });

    Route::prefix('branch')->controller(BranchController::class)->group(function () {
        Route::get('/', 'index')->name('branch');
        Route::get('/create', 'create')->name('branch.create');
        Route::post('create', 'store')->name('branch.save');
        Route::get('/edit/{id}', 'edit')->name('branch.edit');
        Route::put('/edit/{id}', 'update')->name('branch.update');
        Route::get('/delete/{id}', 'destroy')->name('branch.delete');
    });

    Route::prefix('role')->controller(RoleController::class)->group(function () {
        Route::get('/', 'index')->name('role');
        Route::get('/create', 'create')->name('role.create');
        Route::post('/create', 'store')->name('role.save');
        Route::get('/edit/{id}', 'edit')->name('role.edit');
        Route::put('/edit/{id}', 'update')->name('role.update');
        Route::get('/delete/{id}', 'destroy')->name('role.delete');
    });

    Route::prefix('doctor')->controller(DoctorController::class)->group(function () {
        Route::get('/', 'index')->name('doctor');
        Route::get('/create', 'create')->name('doctor.create');
        Route::post('/create', 'store')->name('doctor.save');
        Route::get('/edit/{id}', 'edit')->name('doctor.edit');
        Route::put('/edit/{id}', 'update')->name('doctor.update');
        Route::get('/delete/{id}', 'destroy')->name('doctor.delete');
    });

    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->name('category');
        Route::get('/create', 'create')->name('category.create');
        Route::post('/create', 'store')->name('category.save');
        Route::get('/edit/{id}', 'edit')->name('category.edit');
        Route::put('/edit/{id}', 'update')->name('category.update');
        Route::get('/delete/{id}', 'destroy')->name('category.delete');
    });

    Route::prefix('subcategory')->controller(SubcategoryController::class)->group(function () {
        Route::get('/', 'index')->name('subcategory');
        Route::get('/create', 'create')->name('subcategory.create');
        Route::post('/create', 'store')->name('subcategory.save');
        Route::get('/edit/{id}', 'edit')->name('subcategory.edit');
        Route::put('/edit/{id}', 'update')->name('subcategory.update');
        Route::get('/delete/{id}', 'destroy')->name('subcategory.delete');
    });

    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('product');
        Route::get('/create', 'create')->name('product.create');
        Route::post('/create', 'store')->name('product.save');
        Route::get('/edit/{id}', 'edit')->name('product.edit');
        Route::put('/edit/{id}', 'update')->name('product.update');
        Route::get('/delete/{id}', 'destroy')->name('product.delete');
    });

    Route::prefix('appointment')->controller(AppointmentController::class)->group(function () {
        Route::get('/', 'index')->name('appointment');
        Route::get('/create', 'create')->name('appointment.create');
        Route::post('/create', 'store')->name('appointment.save');
        Route::get('/edit/{id}', 'edit')->name('appointment.edit');
        Route::put('/edit/{id}', 'update')->name('appointment.update');
        Route::get('/delete/{id}', 'destroy')->name('appointment.delete');
    });

    Route::prefix('consultation')->controller(MedicalRecordController::class)->group(function () {
        Route::get('/', 'index')->name('consultation');
        Route::get('/create/{type}/{review}/{type_id}', 'create')->name('consultation.create');
        Route::post('/create', 'store')->name('consultation.save');
        Route::get('/edit/{id}', 'edit')->name('consultation.edit');
        Route::put('/edit/{id}', 'update')->name('consultation.update');
        Route::get('/delete/{id}', 'destroy')->name('consultation.delete');
    });

    Route::prefix('camp')->controller(CampController::class)->group(function () {
        Route::get('/', 'index')->name('camp');
        Route::get('/create', 'create')->name('camp.create');
        Route::post('/create', 'store')->name('camp.save');
        Route::get('/edit/{id}', 'edit')->name('camp.edit');
        Route::put('/edit/{id}', 'update')->name('camp.update');
        Route::get('/delete/{id}', 'destroy')->name('camp.delete');
    });

    Route::prefix('camp/patient')->controller(CampPatientController::class)->group(function () {
        Route::get('/{id}', 'index')->name('camp.patient');
        Route::get('/create/{id}', 'create')->name('camp.patient.create');
        Route::post('/create', 'store')->name('camp.patient.save');
        Route::get('/edit/{id}', 'edit')->name('camp.patient.edit');
        Route::put('/edit/{id}', 'update')->name('camp.patient.update');
        Route::get('/delete/{id}', 'destroy')->name('camp.patient.delete');
    });

    Route::prefix('order/store')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('store.order');
        Route::get('/create/{id}', 'create')->name('store.order.create');
        Route::post('/create/{id}', 'store')->name('store.order.save');
        Route::get('/edit/{id}', 'edit')->name('store.order.edit');
        Route::put('/update/{id}', 'update')->name('store.order.update');
        Route::get('/delete/{id}', 'destroy')->name('store.order.delete');
    });

    Route::prefix('order/pharmacy')->controller(PharmacyController::class)->group(function () {
        Route::get('/', 'index')->name('pharmacy.order');
        Route::get('/create/{id}', 'create')->name('pharmacy.order.create');
        Route::post('/create/{id}', 'store')->name('pharmacy.order.save');
        Route::get('/edit/{id}', 'edit')->name('pharmacy.order.edit');
        Route::put('/update/{id}', 'update')->name('pharmacy.order.update');
        Route::get('/delete/{id}', 'destroy')->name('pharmacy.order.delete');
    });
});
