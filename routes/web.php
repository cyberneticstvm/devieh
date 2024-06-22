<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\CampPatientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Drishti\CustomerController;
use App\Http\Controllers\Drishti\ItemController;
use App\Http\Controllers\Drishti\OrderController as DrishtiOrderController;
use App\Http\Controllers\Drishti\PurchaseController;
use App\Http\Controllers\HeadsController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PharmacyPurchaseController;
use App\Http\Controllers\PharmacyTransferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StorePurchaseController;
use App\Http\Controllers\StoreTransferController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SupplierController;
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
        Route::get('/logout', 'logout')->name('logout');
    });
});

Route::prefix('admin')->middleware(['web', 'auth', 'branch'])->group(function () {

    Route::prefix('/ajax')->controller(AjaxController::class)->group(function () {
        Route::post('/appointment/time', 'getAppointmentTime')->name('ajax.appointment.time');
        Route::get('/fetch/product/{id}', 'fetchProduct')->name('ajax.product.fetch');
        Route::get('/fetch/category/product/{id}', 'fetchProductsByCategory')->name('ajax.product.by.category.fetch');
        Route::get('/fetch/category/not/product/{id}', 'fetchProductsByCategoryNotIn')->name('ajax.product.by.category.not.fetch');
    });

    Route::prefix('/helper')->controller(HelperController::class)->group(function () {
        Route::get('/search', 'search')->name('search');
        Route::post('/search', 'searchFetch')->name('search.fetch');
    });

    Route::prefix('/user')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('user');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/create', 'store')->name('user.save');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::put('/edit/{id}', 'update')->name('user.update');
        Route::get('/delete/{id}', 'destroy')->name('user.delete');
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

    Route::prefix('heads')->controller(HeadsController::class)->group(function () {
        Route::get('/', 'index')->name('heads');
        Route::get('/create', 'create')->name('head.create');
        Route::post('/create', 'store')->name('head.save');
        Route::get('/edit/{id}', 'edit')->name('head.edit');
        Route::put('/edit/{id}', 'update')->name('head.update');
        Route::get('/delete/{id}', 'destroy')->name('head.delete');
    });

    Route::prefix('iande')->controller(IncomeExpenseController::class)->group(function () {
        Route::get('/', 'index')->name('iande');
        Route::get('/create/{category}', 'create')->name('iande.create');
        Route::post('/create', 'store')->name('iande.save');
        Route::get('/edit/{id}', 'edit')->name('iande.edit');
        Route::put('/edit/{id}', 'update')->name('iande.update');
        Route::get('/delete/{id}', 'destroy')->name('iande.delete');
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

    Route::prefix('payment')->controller(PaymentController::class)->group(function () {
        Route::get('/', 'index')->name('payments');
        Route::get('/create', 'create')->name('payment.create');
        Route::post('/create', 'store')->name('payment.save');
        Route::get('/edit/{id}', 'edit')->name('payment.edit');
        Route::put('/edit/{id}', 'update')->name('payment.update');
        Route::get('/delete/{id}', 'destroy')->name('payment.delete');
    });

    Route::prefix('supplier')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('supplier');
        Route::get('/create', 'create')->name('supplier.create');
        Route::post('/create', 'store')->name('supplier.save');
        Route::get('/edit/{id}', 'edit')->name('supplier.edit');
        Route::put('/edit/{id}', 'update')->name('supplier.update');
        Route::get('/delete/{id}', 'destroy')->name('supplier.delete');
    });

    Route::prefix('store/purchase')->controller(StorePurchaseController::class)->group(function () {
        Route::get('/', 'index')->name('store.purchase');
        Route::get('/create', 'create')->name('store.purchase.create');
        Route::post('/create', 'store')->name('store.purchase.save');
        Route::get('/edit/{id}', 'edit')->name('store.purchase.edit');
        Route::put('/edit/{id}', 'update')->name('store.purchase.update');
        Route::get('/delete/{id}', 'destroy')->name('store.purchase.delete');
    });

    Route::prefix('pharmacy/purchase')->controller(PharmacyPurchaseController::class)->group(function () {
        Route::get('/', 'index')->name('pharmacy.purchase');
        Route::get('/create', 'create')->name('pharmacy.purchase.create');
        Route::post('/create', 'store')->name('pharmacy.purchase.save');
        Route::get('/edit/{id}', 'edit')->name('pharmacy.purchase.edit');
        Route::put('/edit/{id}', 'update')->name('pharmacy.purchase.update');
        Route::get('/delete/{id}', 'destroy')->name('pharmacy.purchase.delete');
    });

    Route::prefix('store/transfer')->controller(StoreTransferController::class)->group(function () {
        Route::get('/', 'index')->name('store.transfer');
        Route::get('/create', 'create')->name('store.transfer.create');
        Route::post('/create', 'store')->name('store.transfer.save');
        Route::get('/edit/{id}', 'edit')->name('store.transfer.edit');
        Route::put('/edit/{id}', 'update')->name('store.transfer.update');
        Route::get('/delete/{id}', 'destroy')->name('store.transfer.delete');
    });

    Route::prefix('pharmacy/transfer')->controller(PharmacyTransferController::class)->group(function () {
        Route::get('/', 'index')->name('pharmacy.transfer');
        Route::get('/create', 'create')->name('pharmacy.transfer.create');
        Route::post('/create', 'store')->name('pharmacy.transfer.save');
        Route::get('/edit/{id}', 'edit')->name('pharmacy.transfer.edit');
        Route::put('/edit/{id}', 'update')->name('pharmacy.transfer.update');
        Route::get('/delete/{id}', 'destroy')->name('pharmacy.transfer.delete');
    });

    Route::prefix('ad')->controller(AdController::class)->group(function () {
        Route::get('/', 'index')->name('ads');
        Route::get('/create', 'create')->name('ad.create');
        Route::post('/create', 'store')->name('ad.save');
        Route::get('/edit/{id}', 'edit')->name('ad.edit');
        Route::put('/edit/{id}', 'update')->name('ad.update');
        Route::get('/delete/{id}', 'destroy')->name('ad.delete');

        Route::get('/update/settlement/{id}', 'settlement')->name('ad.settlement');
        Route::put('/update/settlement/{id}', 'settlementUpdate')->name('ad.settlement.update');
        Route::get('/settlement/delete/{id}', 'destroySettlement')->name('ad.settlement.delete');
    });

    Route::prefix('report')->controller(ReportController::class)->group(function () {
        Route::get('/daybook', 'dayBook')->name('report.daybook');
        Route::post('/daybook', 'dayBookFetch')->name('report.daybook.fetch');
    });

    Route::prefix('pdf')->controller(PDFController::class)->group(function () {
        Route::get('/opt/{id}', 'opTicket')->name('pdf.opt');
        Route::get('/certificate/{id}', 'certificate')->name('pdf.certificate');
        Route::get('/service-fee/{id}', 'serviceFee')->name('pdf.service.fee');
        Route::get('/receipt/{id}', 'receipt')->name('pdf.receipt');
    });
});

// Route for Drishti //

Route::prefix('admin/drishti/')->middleware(['web', 'auth', 'branch'])->group(function () {

    Route::prefix('')->controller(AjaxController::class)->group(function () {
        Route::get('/fetch/category/product/{id}', 'fetchDrishtiProductsByCategory')->name('ajax.drishti.product.by.category.fetch');
        Route::get('/fetch/product/{id}', 'fetchProductForDrishti')->name('ajax.drishti.product.fetch');
    });

    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('drishti.customer');
        Route::get('/create', 'create')->name('drishti.customer.create');
        Route::post('/create', 'store')->name('drishti.customer.save');
        Route::get('/edit/{id}', 'edit')->name('drishti.customer.edit');
        Route::put('/edit/{id}', 'update')->name('drishti.customer.update');
        Route::get('/delete/{id}', 'destroy')->name('drishti.customer.delete');
    });

    Route::prefix('item')->controller(ItemController::class)->group(function () {
        Route::get('/', 'index')->name('drishti.item');
        Route::get('/create', 'create')->name('drishti.item.create');
        Route::post('/create', 'store')->name('drishti.item.save');
        Route::get('/edit/{id}', 'edit')->name('drishti.item.edit');
        Route::put('/edit/{id}', 'update')->name('drishti.item.update');
        Route::get('/delete/{id}', 'destroy')->name('drishti.item.delete');
    });

    Route::prefix('order')->controller(DrishtiOrderController::class)->group(function () {
        Route::get('/', 'index')->name('drishti.order');
        Route::get('/create', 'create')->name('drishti.order.create');
        Route::post('/create', 'store')->name('drishti.order.save');
        Route::get('/edit/{id}', 'edit')->name('drishti.order.edit');
        Route::put('/edit/{id}', 'update')->name('drishti.order.update');
        Route::get('/delete/{id}', 'destroy')->name('drishti.order.delete');
    });

    Route::prefix('purchase')->controller(PurchaseController::class)->group(function () {
        Route::get('/', 'index')->name('drishti.purchase');
        Route::get('/create', 'create')->name('drishti.purchase.create');
        Route::post('/create', 'store')->name('drishti.purchase.save');
        Route::get('/edit/{id}', 'edit')->name('drishti.purchase.edit');
        Route::put('/edit/{id}', 'update')->name('drishti.purchase.update');
        Route::get('/delete/{id}', 'destroy')->name('drishti.purchase.delete');
    });

    Route::prefix('pdf')->controller(PDFController::class)->group(function () {
        Route::get('/order/invoice/{id}', 'drishtiOrderInvoice')->name('pdf.drishti.order.invoice');
    });
});
