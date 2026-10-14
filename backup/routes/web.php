<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MetaDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CSVUploadController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\OurClientController;
use App\Http\Controllers\Citygroupcontroller;
use App\Http\Controllers\Categoriescontroller;
use App\Http\Controllers\Subcategoriescontroller;
use App\Http\Controllers\membershipplanscontroller;
use App\Http\Controllers\memberscontroller;
use App\Http\Controllers\Renewalhistorycontroller;
use App\Http\Controllers\Products_servicecontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryDetailController;
use App\Http\Controllers\VideogalleryController;
use App\Http\Controllers\Eventcontroller;
use App\Http\Controllers\Businesscontroller;
use App\Http\Controllers\memberblogcontroller;
use App\Http\Controllers\MemberProductscontroller;
use App\Http\Controllers\MemberBusinesscontroller;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Overteemcontroller;
use App\Http\Controllers\Bannercontroller;
use App\Http\Controllers\Adminfrontimagecontroller;
use App\Http\Controllers\Adminusercontroller;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontinquiryController;
use App\Http\Controllers\ContectinquiryController;
use App\Http\Controllers\MemberrequestController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\Referencecontroller;
use App\Http\Controllers\AdminReferencecontroller;
use App\Http\Controllers\Membersearchcontroller;
use App\Http\Controllers\Membermeetingcontroller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClusterfestFeedbackController;

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

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');

    return '✅ Config and cache cleared successfully!';
});
Route::middleware(['check_approval'])->group(function () {

    Route::get('AnnouncementDetail/{id?}', [FrontController::class, 'Announcement_Detail'])->name('AnnouncementDetail');

    Route::prefix('admin')->name('podcast.')->middleware('auth')->group(function () {
        Route::get('/podcast/podcastindex', [FrontController::class, 'podcastindex'])->name('podcastindex');
        Route::post('/podcast/store', [FrontController::class, 'podcaststore'])->name('store');
        Route::get('/podcast/memberweek', [FrontController::class, 'memberweek'])->name('memberweek');
        Route::post('/podcast/weekstore', [FrontController::class, 'weekstore'])->name('weekstore');

        Route::post('/checkdate', [FrontController::class, 'checkDate'])->name('checkdate');
    });
    //User memeber route 
    Route::prefix('admin')->name('Usermember.')->middleware('auth')->group(function () {
        Route::get('/Usermember/blogindex', [memberblogcontroller::class, 'blogindex'])->name('blogindex');
        Route::get('/Usermember/blogcreate', [memberblogcontroller::class, 'createview'])->name('blogcreate');
        Route::post('/Usermember/blogadd', [memberblogcontroller::class, 'create'])->name('blogadd');
        Route::get('/Usermember/blogedit/{id?}', [memberblogcontroller::class, 'editview'])->name('blogedit');
        Route::post('/Usermember/update', [memberblogcontroller::class, 'update'])->name('update');
        Route::post('/Usermember/status/{id?}', [memberblogcontroller::class, 'status'])->name('status');
        Route::delete('/Usermember/delete', [memberblogcontroller::class, 'delete'])->name('delete');
        Route::get('/Usermember/indexuser', [memberblogcontroller::class, 'indexuser'])->name('indexuser');
    });
    //Member Products_service
    Route::prefix('admin')->name('MemberProducts.')->middleware('auth')->group(function () {
        Route::get('/MemberProducts/Productindex', [MemberProductscontroller::class, 'Productindex'])->name('Productindex');
        Route::get('/MemberProducts/ProductStoreview/{id?}', [MemberProductscontroller::class, 'ProductStoreview'])->name('ProductStoreview');
        Route::post('/MemberProducts/Store', [MemberProductscontroller::class, 'create'])->name('Store');
        Route::get('/MemberProducts/productedit/{id?}', [MemberProductscontroller::class, 'editview'])->name('productedit');
        Route::post('/MemberProducts/update', [MemberProductscontroller::class, 'update'])->name('update');
        Route::delete('/MemberProducts/delete', [MemberProductscontroller::class, 'delete'])->name('delete');
        Route::get('/check/MemberProducts/', [MemberProductscontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
        Route::get('/edit/check/MemberProducts/', [MemberProductscontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
    });

    //Member Business route    
    Route::prefix('admin')->name('MemberBusiness.')->middleware('auth')->group(function () {
        Route::any('MemberBusiness/index', [MemberBusinesscontroller::class, 'index'])->name('index');
        Route::get('MemberBusiness/storeview', [MemberBusinesscontroller::class, 'storeview1'])->name('storeview');
        Route::get('MemberBusiness/edit', [MemberBusinesscontroller::class, 'editview'])->name('edit');
        Route::post('MemberBusiness/create', [MemberBusinesscontroller::class, 'create'])->name('create');
        Route::get('MemberBusiness/{Id}', [MemberBusinesscontroller::class, 'editview'])->name('edit');
        Route::post('/MemberBusiness/update', [MemberBusinesscontroller::class, 'update'])->name('update');
        Route::delete('/MemberBusiness/delete', [MemberBusinesscontroller::class, 'delete'])->name('delete');
        Route::get('Received', [MemberBusinesscontroller::class, 'Received1'])->name('Received');
        Route::post('/MemberBusiness/status/{id?}', [MemberBusinesscontroller::class, 'status'])->name('status');

        Route::get('/Memberlist/{id?}', [MemberBusinesscontroller::class, 'member_listing'])->name('Memberlist');
    });

    //Member Reference route start 
    Route::prefix('admin')->name('Reference.')->middleware('auth')->group(function () {
        Route::any('Reference/index', [Referencecontroller::class, 'index'])->name('index');
        Route::get('Reference/storeview', [Referencecontroller::class, 'storeview1'])->name('storeview');
        Route::get('Reference/edit', [Referencecontroller::class, 'editview'])->name('edit');
        Route::post('Reference/create', [Referencecontroller::class, 'create'])->name('create');
        Route::get('Reference/{Id}', [Referencecontroller::class, 'editview'])->name('edit');
        Route::post('/Reference/update', [Referencecontroller::class, 'update'])->name('update');
        Route::delete('/Reference/delete', [Referencecontroller::class, 'delete'])->name('delete');
        Route::get('ReceivedReference', [Referencecontroller::class, 'Received1'])->name('ReceivedReference');
        Route::post('/Reference/status/{id?}', [Referencecontroller::class, 'status'])->name('status');
    });
    Route::view('/Referencestatus', '/Referencestatus');
    Route::view('/Referencerejectedcom', '/Referencerejectedcom');
    Route::view('/Referencerejects', '/Referencerejects');
    Route::post('/statuscomment1', [Referencecontroller::class, 'statusadd'])->name('statuscomment1');
    Route::post('/Refupdatestatus', [Referencecontroller::class, 'updatestatus'])->name('Refupdatestatus');
    // Route::get('/newstatusapprove', [Referencecontroller::class, 'newstatusapprove'])->name('newstatusapprove');

});
//REFERENCE EMAIL ROUTE START
Route::get('/Ref_approve/{gu_id}', [Referencecontroller::class, 'approveReference'])->name('Ref_approve');
Route::get('/Ref_reject/{gu_id}', [Referencecontroller::class, 'rejectReference'])->name('Ref_reject');
// REFERENCE EMAIL ROUTE END

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/auth/Memberlogin', function () {
    return view('/auth/Memberlogin');
})->name('Memberlogin');
Route::group(['middleware' => 'check_user_status'], function () {
    // Routes that require active users
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
Auth::routes(['register' => false]);

Route::get('/Memberhome', [App\Http\Controllers\HomeController::class, 'index'])->name('Memberhome');
Route::get('/Adminuserhome', [App\Http\Controllers\HomeController::class, 'index'])->name('Adminuserhome');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
    Route::get('/user-edit', [HomeController::class, 'UserEditProfile'])->name('UserEditProfile');
    Route::post('/user-update', [HomeController::class, 'UserupdateProfile'])->name('Userupdate');
});



Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::post('/password-update/{Id?}', [UserController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});
//city master
Route::prefix('admin')->name('serviceprovider.')->middleware('auth')->group(function () {
    Route::get('/serviceprovider/index', [ServiceProviderController::class, 'index'])->name('index');
    Route::post('/serviceprovider/store', [ServiceProviderController::class, 'create'])->name('store');
    Route::get('/serviceprovider/edit/{id?}', [ServiceProviderController::class, 'editview'])->name('edit');
    Route::post('/serviceprovider/update', [ServiceProviderController::class, 'update'])->name('update');
    Route::delete('/serviceprovider/delete', [ServiceProviderController::class, 'delete'])->name('delete');
    Route::get('/check/serviceprovider/', [ServiceProviderController::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/serviceprovider/', [ServiceProviderController::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
    //City Group master     
    Route::get('/serviceprovider/citygroupindex', [Citygroupcontroller::class, 'index'])->name('citygroupindex');
    Route::post('/serviceprovider/citygroupstore', [Citygroupcontroller::class, 'create'])->name('citygroupstore');
    Route::get('/serviceprovider/citygroupedit/{id?}', [Citygroupcontroller::class, 'editview'])->name('citygroupedit');
    Route::post('/serviceprovider/citygroupupdate', [Citygroupcontroller::class, 'update'])->name('citygroupupdate');
    Route::delete('/serviceprovider/citygroupdelete', [Citygroupcontroller::class, 'delete'])->name('citygroupdelete');
    Route::get('/citygroupcheck/serviceprovider/', [Citygroupcontroller::class, 'checkserviceprovider'])->name('citygroupcheckserviceprovider');
    Route::get('/citygroupedit/check/serviceprovider/', [Citygroupcontroller::class, 'editcheckserviceprovider'])->name('citygroupeditcheckserviceprovider');
});
//category master
Route::prefix('admin')->name('categories.')->middleware('auth')->group(function () {
    Route::any('/categories/index', [Categoriescontroller::class, 'index'])->name('index');
    Route::post('/categories/store', [Categoriescontroller::class, 'create'])->name('store');
    Route::get('/categories/edit/{id?}', [Categoriescontroller::class, 'editview'])->name('edit');
    Route::post('/categories/update', [Categoriescontroller::class, 'update'])->name('update');
    Route::delete('/categories/delete', [Categoriescontroller::class, 'delete'])->name('delete');
    Route::get('/check/categories/', [Categoriescontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/categories/', [Categoriescontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});

//Sub category master
Route::prefix('admin')->name('subcategories.')->middleware('auth')->group(function () {
    Route::get('/subcategories/index', [Subcategoriescontroller::class, 'index'])->name('index');
    Route::post('/subcategories/store', [Subcategoriescontroller::class, 'create'])->name('store');
    Route::get('/subcategories/edit/{id?}', [Subcategoriescontroller::class, 'editview'])->name('edit');
    Route::post('/subcategories/update', [Subcategoriescontroller::class, 'update'])->name('update');
    Route::delete('/subcategories/delete', [Subcategoriescontroller::class, 'delete'])->name('delete');
    Route::get('/check/subcategories/', [Subcategoriescontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/subcategories/', [Subcategoriescontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});
//membership plans master
Route::prefix('admin')->name('membershipplans.')->middleware('auth')->group(function () {
    Route::get('/membershipplans/index', [membershipplanscontroller::class, 'index'])->name('index');
    Route::post('/membershipplans/store', [membershipplanscontroller::class, 'create'])->name('store');
    Route::get('/membershipplans/edit/{id?}', [membershipplanscontroller::class, 'editview'])->name('edit');
    Route::post('/membershipplans/update', [membershipplanscontroller::class, 'update'])->name('update');
    Route::delete('/membershipplans/delete', [membershipplanscontroller::class, 'delete'])->name('delete');
    Route::get('/check/membershipplans/', [membershipplanscontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/membershipplans/', [membershipplanscontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});

//Members route master 
Route::prefix('admin')->name('members.')->middleware('auth')->group(function () {
    Route::any('/members/index', [memberscontroller::class, 'index'])->name('index');
    Route::get('/members/storeview', [memberscontroller::class, 'storeview'])->name('storeview');
    Route::post('/members/store', [memberscontroller::class, 'create'])->name('store');
    Route::get('/members/edit/{id?}', [memberscontroller::class, 'editview'])->name('edit');
    Route::post('/members/update/{id?}', [memberscontroller::class, 'update'])->name('update');
    Route::delete('/members/delete', [memberscontroller::class, 'delete'])->name('delete');
    Route::get('/check/members/', [memberscontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/members/', [memberscontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
    Route::get('/members/cityid', [memberscontroller::class, 'cityid'])->name('cityid');
    Route::get('/members/categoryid', [memberscontroller::class, 'categoryid'])->name('categoryid');
    Route::get('/members/report', [memberscontroller::class, 'report'])->name('report');
    Route::post('members/changepassword', [memberscontroller::class, 'changePassword'])->name('changepassword');
    Route::get('/update/status/{user_id}/{status}', [memberscontroller::class, 'updateStatus'])->name('status');
    Route::any('/members/Memberexport/{first_name?}/{category_id?}', [memberscontroller::class, 'MemberexportToexcel'])->name('Memberexport');
    Route::view('/members/Memberexportdata', '/members/Memberexportdata')->name('Memberexportdata');
    Route::get('/Arrival/{user_id?}', [memberscontroller::class, 'Arrival'])->name('Arrival');
    Route::any('/Archive', [memberscontroller::class, 'Archive_index'])->name('Archive');
    Route::get('/Arrival_member/{user_id?}', [memberscontroller::class, 'Arrival_member_back'])->name('Arrival_member');
});

//Products_service master
Route::prefix('admin')->name('Products_service.')->middleware('auth')->group(function () {
    Route::get('/Products_service/index/{id?}', [Products_servicecontroller::class, 'index'])->name('index');
    Route::get('/Products_service/Storeview/{id?}', [Products_servicecontroller::class, 'Storeview'])->name('Storeview');
    Route::post('/Products_service/Store', [Products_servicecontroller::class, 'create'])->name('Store');
    Route::get('/Products_service/edit/{id?}', [Products_servicecontroller::class, 'editview'])->name('edit');
    Route::post('/Products_service/update', [Products_servicecontroller::class, 'update'])->name('update');
    Route::delete('/Products_service/delete', [Products_servicecontroller::class, 'delete'])->name('delete');
    Route::get('/check/Products_service/', [Products_servicecontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/Products_service/', [Products_servicecontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});

//Renewal History route 
Route::prefix('admin')->name('Renewalhistory.')->middleware('auth')->group(function () {
    // dd('hello');
    Route::get('/Renewalhistory/index/{id?}', [Renewalhistorycontroller::class, 'index'])->name('index');
    Route::get('/Renewalhistory/Storeview/{id?}', [Renewalhistorycontroller::class, 'Storeview'])->name('Storeview');
    Route::post('/Renewalhistory/store', [Renewalhistorycontroller::class, 'create'])->name('store');
    Route::get('/Renewalhistory/edit/{id?}', [Renewalhistorycontroller::class, 'editview'])->name('edit');
    Route::post('/Renewalhistory/update', [Renewalhistorycontroller::class, 'update'])->name('update');
    Route::delete('/Renewalhistory/delete', [Renewalhistorycontroller::class, 'delete'])->name('delete');
    Route::get('/check/Renewalhistory/', [Renewalhistorycontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/Renewalhistory/', [Renewalhistorycontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});

// payment-report route master
Route::prefix('admin')->name('reports.')->middleware('auth')->group(function () {
    Route::any('/reports/report', [ReportController::class, 'report'])->name('report');
    Route::any('/reports/Export/To/Excel/{FromDate?}/{ToDate?}/{ServiceProvider?}/{SerialNo?}', [ReportController::class, 'exportToexcel'])->name('exportToexcel');
    Route::any('/reports/export/{fromdate?}/{todate?}/{first_name?}', [ReportController::class, 'exportToexcel'])->name('export');
    Route::any('/reports/businessexport/{fromdate?}/{todate?}/{first_name?}', [ReportController::class, 'BusinessexportToexcel'])->name('businessexport');
    Route::view('/reports/exportdata', '/reports/exportdata')->name('exportdata');
    // Upcoming renualhistry report master
    Route::any('/reports/upcomingrenual', [ReportController::class, 'upcomingrenual'])->name('upcomingrenual');
    Route::any('/reports/BusinessAnalysis', [ReportController::class, 'Analysisindex'])->name('BusinessAnalysis');
    Route::view('/reports/businessexportdata', '/reports/businessexportdata')->name('businessexportdata');

    //30-7-25
    Route::any('/Member-reports-detail/{id?}', [ReportController::class, 'Member_reports_detail'])->name('Member_reports_detail');
    Route::any('/reports-recived-detail/{id?}', [ReportController::class, 'DirectBuiness_Given'])->name('reports_recived_detail');
    Route::any('/refBusiness-given-detail/{id?}', [ReportController::class, 'RefBusiness_given'])->name('refbusiness_given');
    Route::any('/refBusiness-received-detail/{id?}', [ReportController::class, 'RefBusiness_Received'])->name('refbusiness_received');
});

//Blog route master
Route::prefix('admin')->name('Blog.')->middleware('auth')->group(function () {
    Route::get('/Blog/index', [BlogController::class, 'index'])->name('index');
    Route::get('/Blog/create', [BlogController::class, 'createview'])->name('create');
    Route::post('/Blog/add', [BlogController::class, 'create'])->name('add');
    Route::get('/Blog/edit/{id?}', [BlogController::class, 'editview'])->name('edit');
    Route::post('/Blog/update', [BlogController::class, 'update'])->name('update');
    Route::post('/Blog/status/{id?}', [BlogController::class, 'status'])->name('status');
    Route::delete('/Blog/delete', [BlogController::class, 'delete'])->name('delete');
    Route::get('/Blog/indexuser', [BlogController::class, 'indexuser'])->name('indexuser');
});

//Gallery master
Route::prefix('admin')->name('gallery.')->middleware('auth')->group(function () {
    Route::get('gallery/index', [GalleryController::class, 'index'])->name('index');
    Route::get('gallery/create', [GalleryController::class, 'createview'])->name('gallery.add');
    Route::post('gallery/create', [GalleryController::class, 'create'])->name('create');
    Route::get('gallery/{Id}', [GalleryController::class, 'editview'])->name('edit');
    Route::post('/gallery/update', [GalleryController::class, 'update'])->name('update');
    Route::delete('/gallery-delete', [GalleryController::class, 'delete'])->name('delete');
});
//Gallery Detail master
Route::any('gallerydetail/index/{id}', [GalleryDetailController::class, 'index'])->name('gallerydetail.index');
Route::get('gallerydetail/create', [GalleryDetailController::class, 'createview'])->name('gallerydetail.add');
Route::post('gallerydetail/create', [GalleryDetailController::class, 'create'])->name('gallerydetail.create');
Route::delete('/gallerydetail-delete', [GalleryDetailController::class, 'delete'])->name('gallerydetail.delete');
Route::DELETE('/gallerydetail-deleteselected', [GalleryDetailController::class, 'deleteselected'])->name('gallerydetail.deleteselected');


//video_gallery master
Route::prefix('admin')->name('videogallery.')->middleware('auth')->group(function () {
    Route::get('videogallery/index', [VideogalleryController::class, 'index'])->name('index');
    Route::get('videogallery/create', [VideogalleryController::class, 'createview'])->name('videogallery.add');
    Route::post('videogallery/create', [VideogalleryController::class, 'create'])->name('create');
    Route::get('videogallery/{Id}', [VideogalleryController::class, 'editview'])->name('edit');
    Route::post('/videogallery/update', [VideogalleryController::class, 'update'])->name('update');
    Route::delete('/videogallery-delete', [VideogalleryController::class, 'delete'])->name('delete');
});


//New and Event master
Route::prefix('admin')->name('Event.')->middleware('auth')->group(function () {
    Route::get('Event/index', [Eventcontroller::class, 'index'])->name('index');
    Route::get('Event/storeview', [Eventcontroller::class, 'storeview'])->name('storeview');
    Route::get('Event/edit', [Eventcontroller::class, 'editview'])->name('Event.edit');
    Route::post('Event/create', [Eventcontroller::class, 'create'])->name('create');
    Route::get('Event/{Id}', [Eventcontroller::class, 'editview'])->name('edit');
    Route::post('/Event/update', [Eventcontroller::class, 'update'])->name('update');
    Route::delete('/Event/delete', [Eventcontroller::class, 'delete'])->name('delete');
});



//Business master  
Route::prefix('admin')->name('Business.')->middleware('auth')->group(function () {
    Route::any('Business/index', [Businesscontroller::class, 'index'])->name('index');
    Route::get('Business/storeview', [Businesscontroller::class, 'storeview'])->name('storeview');
    Route::get('Business/edit', [Businesscontroller::class, 'editview'])->name('edit');
    Route::post('Business/create', [Businesscontroller::class, 'create'])->name('create');
    Route::get('Business/{Id}', [Businesscontroller::class, 'editview'])->name('edit');
    Route::post('/Business/update', [Businesscontroller::class, 'update'])->name('update');
    Route::delete('/Business/delete', [Businesscontroller::class, 'delete'])->name('delete');
    Route::delete('/Business/deleteapprove', [Businesscontroller::class, 'deleteapprove'])->name('deleteapprove');
    Route::delete('/Business/deleterejected', [Businesscontroller::class, 'deleterejected'])->name('deleterejected');
    Route::post('/Business/status/{id?}', [Businesscontroller::class, 'status'])->name('status');
    Route::post('/Business/chengedapprovestatus/{id?}', [Businesscontroller::class, 'chengedapprovestatus'])->name('chengedapprovestatus');
    Route::any('approve_list', [Businesscontroller::class, 'approvelist'])->name('approve_list');
    Route::any('rejected_list', [Businesscontroller::class, 'rejected'])->name('rejected_list');
    // panding
    Route::any('exportbusiness/{fromdate?}/{todate?}', [Businesscontroller::class, 'exportToexcel_list'])->name('exportbusiness');
    Route::view('/Business/exportlist', '/Business/exportlist')->name('exportlist');
    //approve
    Route::any('exportapprove/{fromdate?}/{todate?}', [Businesscontroller::class, 'exportapprove'])->name('exportapprove');
    Route::view('/Business/exportapprove_list', '/Business/exportapprove')->name('exportapprove_list');
    //reject
    Route::any('exportrejected/{fromdate?}/{todate?}', [Businesscontroller::class, 'exportrejected'])->name('exportrejected');
    Route::view('/Business/exportrejected_list', '/Business/exportrejected_list')->name('exportrejected_list');
    Route::post('Business/search', [Businesscontroller::class, 'search'])->name('search');
    Route::get('/Business/statusget/{id?}', [Businesscontroller::class, 'statusget'])->name('statusget');
    Route::any('Business-resendReminder', [Businesscontroller::class, 'Business_resend_Reminder'])->name('resendReminder');
});

//Product Master old
Route::prefix('admin')->name('product.')->middleware('auth')->group(function () {
    Route::any('/product/index', [ProductController::class, 'index'])->name('index');
    Route::get('/product/create', [ProductController::class, 'createview'])->name('create');
    Route::post('/product/store', [ProductController::class, 'create'])->name('store');
    Route::get('/product/edit/{id?}', [ProductController::class, 'editview'])->name('edit');
    Route::post('/product/update/{id?}', [ProductController::class, 'update'])->name('update');
    Route::delete('/product/delete', [ProductController::class, 'delete'])->name('delete');
    Route::get('/product/check/serialno', [ProductController::class, 'checkserialno'])->name('checkserialno');
    Route::get('/product/edit/check/serialno', [ProductController::class, 'editcheckserialno'])->name('editcheckserialno');
    Route::any('/product/ProductInquirylist', [ProductController::class, 'Inquirylist'])->name('ProductInquirylist');
    Route::delete('/product/Inquirydelete', [ProductController::class, 'Inquirydelete'])->name('Inquirydelete');
});

//Finance old
Route::prefix('admin')->name('finance.')->middleware('auth')->group(function () {
    Route::any('/Financed', [FinanceController::class, 'Financed'])->name('Financed');
    Route::any('/Non-Financed', [FinanceController::class, 'NonFinanced'])->name('NonFinanced');
    Route::any('/Non-Financed/To/Financed/{id?}', [FinanceController::class, 'NonFinancedToFinanced'])->name('NonFinancedToFinanced');
    Route::any('/Financed/To/Non-Financed/{id?}', [FinanceController::class, 'FinancedToNonFinanced'])->name('FinancedToNonFinanced');
    Route::any('/Non-Financed/Export/To/Excel/{FromDate?}/{ToDate?}/{ServiceProvider?}/{SerialNo?}', [FinanceController::class, 'exportToexcelnonfinanced'])->name('exportToexcelnonfinanced');
    Route::any('/Financed/Export/To/Excel/{FromDate?}/{ToDate?}/{ServiceProvider?}/{SerialNo?}', [FinanceController::class, 'exportToexcelfinanced'])->name('exportToexcelfinanced');
});

//Upload CSV old
Route::prefix('admin')->name('csvupload.')->middleware('auth')->group(function () {
    Route::any('/CSV/index', [CSVUploadController::class, 'index'])->name('index');
    Route::post('/CSV/store', [CSVUploadController::class, 'create'])->name('store');
});


//member user 
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::view('auth/forgetPassword', 'auth/forgetPassword');
Route::post('forgetpasswordpost', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forgetpasswordpost');
Route::view('/resetpasswordform', '/resetpasswordform');
Route::get('resetpassword/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('resetpassword');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// });  


Route::prefix('admin')->name('overteem.')->middleware('auth')->group(function () {
    Route::get('overteem/index', [Overteemcontroller::class, 'index'])->name('index');
    Route::get('overteem/create', [Overteemcontroller::class, 'createview'])->name('overteem.add');
    Route::post('overteem/create', [Overteemcontroller::class, 'create'])->name('create');
    Route::get('overteem/{Id}', [Overteemcontroller::class, 'editview'])->name('edit');
    Route::post('/overteem/update', [Overteemcontroller::class, 'update'])->name('update');
    Route::delete('/overteem-delete', [Overteemcontroller::class, 'delete'])->name('delete');
});


Route::prefix('admin')->name('overteem.')->middleware('auth')->group(function () {
    Route::get('overteem/index', [Overteemcontroller::class, 'index'])->name('index');
    Route::get('overteem/create', [Overteemcontroller::class, 'createview'])->name('overteem.add');
    Route::post('overteem/create', [Overteemcontroller::class, 'create'])->name('create');
    Route::get('overteem/{Id}', [Overteemcontroller::class, 'editview'])->name('edit');
    Route::post('/overteem/update', [Overteemcontroller::class, 'update'])->name('update');
    Route::delete('/overteem-delete', [Overteemcontroller::class, 'delete'])->name('delete');
});

Route::prefix('admin')->name('Banner.')->middleware('auth')->group(function () {
    Route::get('Banner/index', [Bannercontroller::class, 'index'])->name('index');
    Route::get('Banner/create', [Bannercontroller::class, 'createview'])->name('Banner.add');
    Route::post('Banner/create', [Bannercontroller::class, 'create'])->name('create');
    Route::get('Banner/{Id}', [Bannercontroller::class, 'editview'])->name('edit');
    Route::post('/Banner/update', [Bannercontroller::class, 'update'])->name('update');
    Route::delete('/Banner-delete', [Bannercontroller::class, 'delete'])->name('delete');
});
// Admin User
Route::prefix('admin')->name('Adminuser.')->middleware('auth')->group(function () {
    Route::get('/Adminuser/index', [Adminusercontroller::class, 'index'])->name('index');
    Route::post('/Adminuser/store', [Adminusercontroller::class, 'create'])->name('store');
    Route::get('/Adminuser/edit/{id?}', [Adminusercontroller::class, 'editview'])->name('edit');
    Route::post('/Adminuser/update', [Adminusercontroller::class, 'update'])->name('update');
    Route::delete('/Adminuser/delete', [Adminusercontroller::class, 'delete'])->name('delete');
    Route::get('/check/Adminuser/', [Adminusercontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/Adminuser/', [Adminusercontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});


Route::prefix('admin')->name('Userpermission.')->middleware('auth')->group(function () {
    Route::get('/Userpermission/index/{id?}', [Adminusercontroller::class, 'permissionindex'])->name('index');
    Route::post('/Userpermission/store', [Adminusercontroller::class, 'permissioncreate'])->name('store');
    Route::get('/Userpermission/edit/{id?}', [Adminusercontroller::class, 'editview'])->name('edit');
    Route::post('/Userpermission/update', [Adminusercontroller::class, 'update'])->name('update');
    Route::delete('/Userpermission/delete', [Adminusercontroller::class, 'delete'])->name('delete');
    Route::get('/check/Userpermission/', [Adminusercontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/Userpermission/', [Adminusercontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});

// Admin frontview image and title add modules route   
Route::prefix('admin')->name('Adminfrontimage.')->middleware('auth')->group(function () {
    Route::get('/Adminfrontimage/index', [Adminfrontimagecontroller::class, 'index'])->name('index');
    Route::post('/Adminfrontimage/store', [Adminfrontimagecontroller::class, 'create'])->name('store');
    Route::get('/Adminfrontimage/edit/{id?}', [Adminfrontimagecontroller::class, 'editview'])->name('edit');
    Route::post('/Adminfrontimage/update', [Adminfrontimagecontroller::class, 'update'])->name('update');
    Route::delete('/Adminfrontimage/delete', [Adminfrontimagecontroller::class, 'delete'])->name('delete');
    Route::get('/check/Adminfrontimage/', [Adminfrontimagecontroller::class, 'checkserviceprovider'])->name('checkserviceprovider');
    Route::get('/edit/check/Adminfrontimage/', [Adminfrontimagecontroller::class, 'editcheckserviceprovider'])->name('editcheckserviceprovider');
});

// login member user pending statuus check route 
Route::prefix('admin')->name('pendinglogincheck.')->middleware('auth')->group(function () {
    Route::get('pendinglogincheck/index', [MemberBusinesscontroller::class, 'indexpending'])->name('index');
    Route::post('/pendinglogincheck/statuspendinglogin/{id?}', [MemberBusinesscontroller::class, 'statuspendinglogin'])->name('statuspendinglogin');
});
Route::prefix('admin')->name('Youngleaders.')->middleware('auth')->group(function () {
    Route::get('/Young-leaders', [FrontController::class, 'Young_leaders_index'])->name('index');
});


//front route
Route::any('/', [FrontController::class, 'index'])->name('FrontIndex');
Route::get('/GRYD', [FrontController::class, 'Youngleaders'])->name('Youngleaders');
Route::post('/YoungleadersAdd', [FrontController::class, 'Young_leaders_store'])->name('YoungleadersAdd');
Route::get('/frontlogout', [FrontController::class, 'frontlogout'])->name('frontlogout');
Route::get('/aboutus', [FrontController::class, 'about'])->name('FrontAbout');
Route::get('/contact-us', [FrontController::class, 'contactus'])->name('FrontContactUs');
Route::post('/submit/contact_us', [FrontController::class, 'contact_us'])->name('contact_us');
Route::get('/exploreus', [FrontController::class, 'explore'])->name('Frontexploreus');
Route::get('/tcf', [FrontController::class, 'tcf'])->name('Fronttcf');
Route::get('/learning', [FrontController::class, 'learning'])->name('Frontlearning');
Route::get('/dicoverus', [FrontController::class, 'dicover'])->name('Frontdicoverus');
//  Route::get('/product', [FrontController::class, 'product'])->name('Frontproduct');
Route::get('/news', [FrontController::class, 'news'])->name('Frontnews');
Route::get('/photo-album', [FrontController::class, 'photoalbum'])->name('Frontphoto-album');
Route::get('/photo-gallery/{Id?}', [FrontController::class, 'photogallery'])->name('Frontphoto-gallery');
Route::get('/video-gallery', [FrontController::class, 'videogallery'])->name('Frontvideo-gallery');
Route::get('/blog', [FrontController::class, 'frontblog'])->name('Frontblog');
Route::get('/contact-us', [FrontController::class, 'contactusindex'])->name('Frontcontact-us');
Route::get('/user-login', [FrontController::class, 'frontlogin'])->name('Frontfront-login');
Route::get('/blog-detail/{Id?}', [FrontController::class, 'blogdetail'])->name('Frontblog-detail');
Route::any('/news-detail/{Id?}', [FrontController::class, 'newsdetail'])->name('Frontnews-detail');
Route::get('refresh_captcha', [FrontController::class, 'refreshCaptcha'])->name('refresh_captcha');
Route::get('ContactThankyou', [FrontController::class, 'contectthankyou'])->name('ContactThankyou');
Route::post('/blogcomment', [FrontController::class, 'blogcomment'])->name('blogcomment');
Route::any('/newscomment', [FrontController::class, 'newscomment'])->name('newscomment');
Route::get('/getdatanews/{id}', [FrontController::class, 'getNewsData'])->name('getdatanews'); //comment getdata
Route::get('/register', [FrontController::class, 'frontregister'])->name('frontregister');
Route::post('/store', [FrontController::class, 'registerstore1'])->name('frontstore');
Route::get('/category-detail/{id?}', [FrontController::class, 'category_detail'])->name('frontcategorydetail');
//26-06-2024
Route::get('/Privacy-Policy', [FrontController::class, 'Privacy_Policy'])->name('PrivacyPolicy');
Route::get('/TermCondition', [FrontController::class, 'TermCondition'])->name('TermCondition');
//27-06-2024
Route::get('/Refund-Policy', [FrontController::class, 'Refund_Policy'])->name('RefundPolicy');
Route::get('/Delivery-Policy', [FrontController::class, 'delivery_Policy'])->name('DeliveryPolicy');

Route::get('/Thankyou', [FrontController::class, 'THANK_YOU'])->name('Thankyou');
Route::get('/emailer', [FrontController::class, 'emailer'])->name('emailer');


// front search 
Route::any('Search/{id?}', [FrontController::class, 'adminsearch'])->name('Search');
Route::post('ProductInquiry', [FrontController::class, 'ProductInquiry'])->name('ProductInquiry');
Route::any('productInquirylist', [FrontController::class, 'ProductInquiry_list'])->name('productInquirylist');
Route::delete('Productinquirydelete', [FrontController::class, 'ProductInquiry_delete'])->name('Productinquirydelete');
Route::get('/visitor-registration-free', [FrontController::class, 'induction_morning_index'])->name('induction');
Route::get('/cluster-visitor-registration', [FrontController::class, 'visitor_index'])->name('induction');
Route::get('/Cluster-meet', [FrontController::class, 'induction_evening_index'])->name('induction');
Route::any('/inductionstore', [FrontController::class, 'induction_store'])->name('inductionstore');
Route::any('/clustervisitorstore', [FrontController::class, 'cluster_visitor_store'])->name('clustervisitorstore');
Route::post('/clustermeet', [FrontController::class, 'clustermeet_store'])->name('clustermeet');

//18-10-2025
Route::get('/Opportunity-meet', [FrontController::class, 'Opportunity_meet'])->name('Opportunitymeet');
Route::any('/Opportunity-meet-store', [FrontController::class, 'Opportunity_meet_store'])->name('Opportunitymeetstore');
Route::post('Opportunity-paysuccess', [RazorpayPaymentController::class, 'Opportunity_PaySuccess'])->name('Opportunity_PaySuccess');
Route::get('Opportunity-fail', [RazorpayPaymentController::class, 'Opportunity_Fail'])->name('Opportunity_Fail');
Route::get('/visitor-registration', [FrontController::class, 'induction_morning_index_paid'])->name('induction_paid');
Route::any('/induction-store-add', [FrontController::class, 'induction_store_paid'])->name('inductionstore_add');

//Activity route member
Route::prefix('admin')->name('Activity.')->middleware('auth')->group(function () {
    Route::get('/Activity/index', [FrontController::class, 'activity_index'])->name('index');
    Route::post('Activity/create', [FrontController::class, 'activity_create'])->name('create');
    Route::get('/Activity/getdata/{id?}', [FrontController::class, 'Activity_editview'])->name('getdata');
    Route::post('/Activity/update', [FrontController::class, 'Activity_update'])->name('update');
    Route::delete('/Activity/delete', [FrontController::class, 'Activity_delete'])->name('delete');
});


// front register inquery admin display route 
Route::prefix('admin')->name('inquiry.')->middleware('auth')->group(function () {
    Route::get('/inquiry/index', [FrontinquiryController::class, 'index'])->name('index');
    Route::get('/inquiry/edit/{id?}', [FrontinquiryController::class, 'edit'])->name('edit');
    Route::post('/inquiry/statuspending', [FrontinquiryController::class, 'statuspending'])->name('statuspending');
    Route::delete('/inquiry/delete', [FrontinquiryController::class, 'delete'])->name('delete');
});
// front contact inquery admin display Contectinquiry
Route::prefix('admin')->name('Contactinquiry.')->middleware('auth')->group(function () {
    Route::get('/Contactinquiry/index', [ContectinquiryController::class, 'index'])->name('index');
    Route::delete('/Contactinquiry/delete', [ContectinquiryController::class, 'delete'])->name('delete');
});

// front Event inquiry admin display Eventinquiry
Route::prefix('admin')->name('Eventinquiry.')->middleware('auth')->group(function () {
    Route::get('/Eventinquiry/index/{id?}', [Eventcontroller::class, 'Eventindex'])->name('index');
    Route::delete('/Eventinquiry/delete', [Eventcontroller::class, 'Eventdelete'])->name('delete');
});
//DASHBORAD EXPRIED ROUTE
Route::prefix('admin')->name('Subscriptionexp.')->middleware('auth')->group(function () {
    Route::get('/Subscriptionexp/index', [HomeController::class, 'subindex'])->name('index');
    Route::post('/Subscriptionexp/update', [HomeController::class, 'subupdate'])->name('update');
});

// front Member Request admin display member request
Route::prefix('admin')->name('Memberrequest.')->middleware('auth')->group(function () {
    Route::get('/Memberrequest/index', [MemberrequestController::class, 'index'])->name('index');
    Route::get('/Memberrequest/statusget/{id?}', [MemberrequestController::class, 'statusget'])->name('statusget');
    Route::post('/Memberrequest/status', [MemberrequestController::class, 'addstatus'])->name('status');
});

// front Member Request admin display member request
Route::prefix('admin')->name('Memberrequest.')->middleware('auth')->group(function () {
    Route::get('/Memberrequest/Memberweekindex', [MemberrequestController::class, 'Memberweekindex'])->name('Memberweek');
    Route::get('/Memberrequest/statusget1/{id?}', [MemberrequestController::class, 'statusget'])->name('statusget1');
    Route::post('/Memberrequest/addstatus', [MemberrequestController::class, 'addstatus1'])->name('addstatus');
    Route::delete('/Memberrequest/delete', [MemberrequestController::class, 'delete'])->name('delete');
    Route::delete('/Memberrequest/delete_week', [MemberrequestController::class, 'delete_week'])->name('delete_week');
});
Route::get('razorpay-payment', [RazorpayPaymentController::class, 'index']);
Route::post('razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');

//reference route master  
Route::prefix('admin')->name('Admin-Reference.')->middleware('auth')->group(function () {
    Route::any('Admin-Reference/index', [AdminReferencecontroller::class, 'index'])->name('index');
    Route::get('Admin-Reference/storeview', [AdminReferencecontroller::class, 'storeview'])->name('storeview');
    Route::get('Admin-Reference/edit', [AdminReferencecontroller::class, 'editview'])->name('edit');
    Route::post('Admin-Reference/create', [AdminReferencecontroller::class, 'create'])->name('create');
    Route::get('Admin-Reference/{Id}', [AdminReferencecontroller::class, 'editview'])->name('edit');
    Route::post('/Admin-Reference/update', [AdminReferencecontroller::class, 'update'])->name('update');
    Route::delete('/Admin-Reference/delete', [AdminReferencecontroller::class, 'delete'])->name('delete');
    Route::delete('/Admin-Reference/deleteapprove', [AdminReferencecontroller::class, 'deleteapprove'])->name('deleteapprove');
    Route::delete('/Admin-Reference/deleterejected', [AdminReferencecontroller::class, 'deleterejected'])->name('deleterejected');
    Route::post('/Admin-Reference/status/{id?}', [AdminReferencecontroller::class, 'status'])->name('status');
    Route::any('Approve_list', [AdminReferencecontroller::class, 'approvelist'])->name('Approve_list');
    Route::any('Rejected_list', [AdminReferencecontroller::class, 'rejected'])->name('Rejected_list');
    Route::any('exportReference/{fromdate?}/{todate?}', [AdminReferencecontroller::class, 'exportToexcel_list'])->name('exportReference');
    Route::view('/Admin-Reference/exportlist', '/Admin-Reference/exportlist')->name('exportlist');
    Route::any('exportapprove_ref/{fromdate?}/{todate?}', [AdminReferencecontroller::class, 'exportapprove'])->name('exportapprove_ref');
    Route::view('/Admin-Reference/exportapprove_list', '/Admin-Reference/exportapprove')->name('exportapprove_list');
    Route::get('/Admin-Reference/statusget/{id?}', [AdminReferencecontroller::class, 'statusget'])->name('statusget');
    //28-07-25
    Route::post('Admin-Reference/resend-reminder', [AdminReferencecontroller::class, 'resendReferenceReminder'])->name('resendReminder');
});

// Member Deshboard serach 
Route::prefix('admin')->name('Membersearch.')->middleware('auth')->group(function () {
    Route::any('Membersearch/index', [Membersearchcontroller::class, 'index'])->name('index');
    Route::get('Membersearch/Detail/{id?}', [Membersearchcontroller::class, 'Detail'])->name('Detail');
});


Route::get('/product', function () {
    return redirect('/');
});


//Member subscription expried
Route::prefix('auth')->name('Membersub.')->middleware('auth')->group(function () {
    Route::get('Membersub/index', [FrontController::class, 'membersub'])->name('index');
});
//Member metting
Route::prefix('admin')->name('Membermeeting.')->middleware('auth')->group(function () {
    Route::get('/Membermeeting/index', [Membermeetingcontroller::class, 'index'])->name('index');
    Route::post('/Membermeeting/store', [Membermeetingcontroller::class, 'create'])->name('store');
    Route::delete('/Membermeeting/delete', [Membermeetingcontroller::class, 'delete'])->name('delete');
    Route::get('/Membermeeting/edit/{id?}', [Membermeetingcontroller::class, 'editview'])->name('edit');
    Route::post('/Membermeeting/update', [Membermeetingcontroller::class, 'update'])->name('update');
    Route::get('/Membermeeting/Memberindex/{id?}', [Membermeetingcontroller::class, 'Memberindex'])->name('Memberindex');
    Route::post('/Membermeeting/memberstore', [Membermeetingcontroller::class, 'memberstore'])->name('memberstore');
    Route::get('/Membermeeting-comment/{id?}', [Membermeetingcontroller::class, 'Membermeeting_comment'])->name('Membercomment');
    Route::post('/comments-store', [Membermeetingcontroller::class, 'comments_store'])->name('commentsstore');
    Route::get('/get-available-members/{meeting_id?}', [Membermeetingcontroller::class, 'getAvailableMembers'])->name('get_available_members');
    Route::post('/Meeting-member-store', [Membermeetingcontroller::class, 'Meeting_add_member'])->name('Meeting_add_member');
});
Route::prefix('admin')->name('induction.')->middleware('auth')->group(function () {
    Route::get('induction/index', [FrontController::class, 'Admin_induction_index'])->name('index');
    Route::get('induction/clustermetting', [FrontController::class, 'clustermetting'])->name('clustermetting');
    Route::delete('/induction/clustermeetdelete', [FrontController::class, 'clustermeet_delete'])->name('clustermeetdelete');
});


// Admin Announcement
Route::prefix('admin')->name('Announcement.')->middleware('auth')->group(function () {
    Route::get('Announcement/index', [FrontController::class, 'Announce_index'])->name('index');
    Route::get('Announcement/storeview', [FrontController::class, 'Announcement_storeview'])->name('storeview');
    Route::post('Announcement/create', [FrontController::class, 'Announcement_create'])->name('Announcementcreate');
    Route::get('Announcement/edit/{id?}', [FrontController::class, 'Announcement_editview'])->name('edit');
    Route::post('/Announcement/update', [FrontController::class, 'Announcement_update'])->name('update');
    Route::delete('/Announcement/delete', [FrontController::class, 'Announcement_delete'])->name('delete');
});
Route::prefix('admin')->name('metaData.')->middleware('auth')->group(function () {
    Route::get('/seo/index', [MetaDataController::class, 'index'])->name('index');
    Route::get('seo/{id}/edit', [MetaDataController::class, 'edit'])->name('edit');
    Route::put('seo/{id}', [MetaDataController::class, 'update'])->name('update');
});

// memberuser approve status route
Route::view('/newstatus', '/newstatus');
Route::view('/rejectedcom', '/rejectedcom');
Route::view('/rejectstatus', '/rejectstatus');
Route::post('/statuscomment', [MemberBusinesscontroller::class, 'statusadd'])->name('statuscomment');
Route::any('/updatestatus', [MemberBusinesscontroller::class, 'updatestatus'])->name('updatestatus');
Route::get('/newstatusapprove', [MemberBusinesscontroller::class, 'newstatusapprove'])->name('newstatusapprove');
Route::get('/approve/{gu_id}', [MemberBusinesscontroller::class, 'approveBusiness'])->name('approve');
Route::get('/reject/{gu_id}', [MemberBusinesscontroller::class, 'rejectBusiness'])->name('reject');

Route::get('/reference_approve/{gu_id?}', [Referencecontroller::class, 'reference_approve_'])->name('reference_approve');
Route::get('/reference_reject/{gu_id?}', [Referencecontroller::class, 'reference_reject'])->name('reference_reject');
Route::any('/ref_updatestatus', [Referencecontroller::class, 'ref_updatestatus'])->name('ref_updatestatus');

//28-07-25

//28-07-25

// paymentgetway route
// Route::get('/razorpay-payment', [RazorpayPaymentController::class, 'index']);
// Route::post('/razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');
Route::get('/razorpay-payment', [RazorpayPaymentController::class, 'index']);
Route::post('/razorpay-payment', [RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');
Route::post('paysuccess', [RazorpayPaymentController::class, 'razorPaySuccess'])->name('razprpay.success');

Route::get('payment/success', [RazorpayPaymentController::class, 'RazorThankYou'])->name('razorpay.thankyou');
Route::get('payment/fail', [RazorpayPaymentController::class, 'RazorFail'])->name('razorpay.RazorFail');

//Clusterfish payment getway
Route::get('/Clusterfest', [FrontController::class, 'Clusterfish_index'])->name('induction');
//Route::get('/preprgistration', [FrontController::class, 'preregistration_index'])->name('induction');
Route::any('/Clusterfeststore', [FrontController::class, 'Clusterfish_store'])->name('Clusterfishstore');
Route::post('Clusterfestsuccess', [RazorpayPaymentController::class, 'Clusterfishsuccess'])->name('razprpay.Clusterfishsuccess');

//event payment getway
Route::post('eventpaymentsuccess', [RazorpayPaymentController::class, 'event_payment_success'])->name('razprpay.eventpaymentsuccess');
Route::get('eventpayment/fail', [RazorpayPaymentController::class, 'event_payment_Fail'])->name('razorpay.event_payment_Fail');
Route::get('clusterfestpayment/fail', [RazorpayPaymentController::class, 'clusterfish_payment_Fail'])->name('razorpay.clusterfish_payment_Fail');

//admin route
Route::prefix('admin')->name('Clusterfish.')->middleware('auth')->group(function () {
    Route::any('Clusterfest/index', [FrontController::class, 'Admin_Clusterfish_index'])->name('index');
    Route::delete('/Clusterfest/delete', [FrontController::class, 'Clusterfish_delete'])->name('delete');
    Route::any('/Clusterfest/Clusterfestexport/{fromdate?}/{todate?}', [FrontController::class, 'ClusterfesteToexcel'])->name('Clusterfestexport');
    Route::view('/Clusterfest/Clusterfestexportdata', '/Clusterfest/Clusterfestexportdata')->name('Clusterfestexportdata');
    Route::post('Clusterfest/ClusterfestpaymentStatus', [FrontController::class, 'Clusterfest_paymentStatus'])->name('ClusterfestpaymentStatus');
});


Route::get('/ClusterfestFeedback', [ClusterfestFeedbackController::class, 'Clusterfishfeedback_index'])->name('induction');
Route::get('/ClusterfestThankyou', [ClusterfestFeedbackController::class, 'Clusterfishfeedback_thankyou'])->name('induction');
Route::any('/ClusterfestFeedbackstore', [ClusterfestFeedbackController::class, 'Clusterfestfeedback_store'])->name('ClusterfestFeedbackstore');
Route::get('/ClusterfestFeedbackCount', [ClusterfestFeedbackController::class, 'feedbackCount'])->name('ClusterfestFeedbackCount');

Route::prefix('admin')->name('ClusterfestFeedback.')->middleware('auth')->group(function () {
    Route::any('ClusterfestFeedback/index', [ClusterfestFeedbackController::class, 'Admin_Clusterfishfeedback_index'])->name('index');
    Route::delete('/ClusterfestFeedback/delete/{id}', [ClusterfestFeedbackController::class, 'destroy'])->name('delete');
});
