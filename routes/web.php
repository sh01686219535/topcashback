<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AdvertiseBannerController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SubModuleController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SiteConfigController;
use App\Http\Controllers\CreateAdminController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FootermenuController;
use App\Http\Controllers\TearmsConditionController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ChildCategoryController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserCommissionController;
use App\Http\Controllers\MerchantApproveController;
use App\Http\Controllers\PayoutDashboardController;
use App\Http\Controllers\PermissionAssignController;
use App\Http\Controllers\MerchantCommissionController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\RateOffPlaceController;
use App\Http\Controllers\FooterDetailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MerchantAdvertisementController;





//  Start FrontEnd Route

// Route::get('/', function () {
//     return to_route('showLogin');
// });
// Route::redirect('/', '/home');

Route::group(['middleware' => ['authAdmin']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Merchant Start
    Route::get('/merchant', [MerchantController::class, 'merchant'])->name('merchant');
    Route::get('/edit-merchant/{id}', [MerchantController::class, 'editMerchant'])->name('edit.merchant');
    Route::post('/update-merchant', [MerchantController::class, 'updateMerchant'])->name('update.merchant');
    Route::get('/delete-merchant/{id}', [MerchantController::class, 'deleteMerchant'])->name('delete.merchant');
    Route::get('/add-merchant', [MerchantController::class, 'addMerchant'])->name('add.merchant');
    Route::post('/save-merchant', [MerchantController::class, 'saveMerchant'])->name('save.merchant');



    // Merchant End

    //merchant Advertisement
    Route::get('/merchant-advertisement', [MerchantAdvertisementController::class, 'merchantAdvertisement'])->name('merchant.advertisement');
    Route::get('/add-merchant-rate', [MerchantAdvertisementController::class, 'addMerchantRate'])->name('add.merchant.rate');
    Route::get('/save-merchant-rate', [MerchantAdvertisementController::class, 'saveMerchantRate'])->name('save.merchant.rate');
    Route::get('/edit-merchant-rate/{id}', [MerchantAdvertisementController::class, 'editMerchantRate'])->name('edit.merchant.rate');
    Route::post('/update-merchant-rate', [MerchantAdvertisementController::class, 'updateMerchantRate'])->name('update.merchant.rate');
    Route::get('/delete-merchant-rate/{id}', [MerchantAdvertisementController::class, 'deleteMerchantRate'])->name('delete.merchant.rate');
    Route::post('/payment-merchant-add', [MerchantAdvertisementController::class, 'paymentMerchantAdd'])->name('payment.merchant.add');


    // Merchant Approve By
    Route::get('/approve', [MerchantApproveController::class, 'showApprove'])->name('showApprove');
    Route::get('approve/{imageId}/{status}', [MerchantApproveController::class, 'approveOffer'])->name('approveOffer');
    // Merchant Approve By End

    //Merchant physicallyApprove
    Route::get('/physicallyApprove', [MerchantApproveController::class, 'showPhysicallyApprove'])->name('showPhysicallyApprove');
    Route::post('/physicallyApprove', [MerchantApproveController::class, 'physicallyApprove'])->name('physicallyApprove');
    //Merchant Approve_update
    Route::get('/approveUpdate', [MerchantApproveController::class, 'showApproveUpdate'])->name('showApproveUpdate');
    //Merchant Approve_update
    //physically verification
    Route::get('/verification/{id}', [MerchantApproveController::class, 'showVerification'])->name('showVerification');
    Route::post('/verification/{id}', [MerchantApproveController::class, 'verification'])->name('verification');
    Route::post('/verification-payment/{id}', [MerchantApproveController::class, 'verificationPayment'])->name('verification.payment');


    //merchant.area
    Route::get('/merchant-area', [AreaController::class,'merchantArea'])->name('merchant-area');
    Route::get('/add-area', [AreaController::class,'addArea'])->name('add.area');
    Route::post('/store-area', [AreaController::class,'storeArea'])->name('store.area');
    Route::get('/edit-area/{id}', [AreaController::class,'editArea'])->name('edit.area');
    Route::post('/update-area', [AreaController::class,'updateArea'])->name('update.area');
    Route::get('/delete-area/{id}', [AreaController::class,'deleteArea'])->name('delete.area');
    // Customer
    route::get('/customer', [CustomerController::class, 'customer'])->name('customer');
    route::get('/edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('edit.customer');
    route::post('/store-customer', [CustomerController::class, 'store'])->name('store.customer');
    route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->name('update.customer');
    route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete.customer');
    route::get('/pdf-customer', [CustomerController::class, 'pdfCustomer'])->name('pdf.customer');
    route::get('/print-customer', [CustomerController::class, 'printCustomer'])->name('print.customer');
    route::get('/excel-customer', [CustomerController::class, 'excelCustomer'])->name('excel.customer');
    route::get('/csv-customer', [CustomerController::class, 'csvCustomer'])->name('csv.customer');
    //pay.advertisement
    Route::get('/pay-advertisement',[AdvertisementController::class,'payAdvertisement'])->name('pay.advertisement');
    Route::post('/store.advertisement',[AdvertisementController::class,'storeAdvertisement'])->name('store.advertisement');
    Route::get('/advertisement-list',[AdvertisementController::class,'list'])->name('advertisement.list');
    //advertise Banner
    Route::get('/advertise-banner',[AdvertiseBannerController::class,'showAdvertiseBanner'])->name('showAdvertiseBanner');
    Route::post('/advertise-banner',[AdvertiseBannerController::class,'advertiseBanner'])->name('advertiseBanner');
    //Category Route
    Route::get('/category', [CategoryController::class, 'category'])->name('category');
    Route::post('/add-category', [CategoryController::class, 'addCategory'])->name('add.category');
    Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
    Route::get('/edit-category/{id}', [CategoryController::class, 'showEditCategory'])->name('showEdit.category');
    Route::post('/edit-category/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
    Route::get('/pdf-category', [CategoryController::class, 'pdfCategory'])->name('pdf.category');

    //Sub Category Route
    Route::get('/subCategory', [SubCategoryController::class, 'subCategory'])->name('subCategory');
    Route::post('/add-subCategory', [SubCategoryController::class, 'storeSubCustomer'])->name('add.subCategory');
    Route::get('/edit-subCategory/{id}', [SubCategoryController::class, 'showEditSubCategory'])->name('showEdit.subCategory');
    Route::post('/edit-subCategory/{id}', [SubCategoryController::class, 'editSubCategory'])->name('edit.subCategory');
    Route::get('/delete.subCategory/{id}', [SubCategoryController::class, 'deleteSubCategory'])->name('delete.subCategory');
    Route::get('/pdf-subCategory', [SubCategoryController::class, 'pdfSubCategory'])->name('pdf.subCategory');

    // childCategory route
    Route::get('/childCategory', [ChildCategoryController::class, 'childCategory'])->name('childCategory');
    Route::post('/add-childCategory', [ChildCategoryController::class, 'storeChildCategory'])->name('add.childCategory');
    Route::get('/delete-childCategory/{id}', [ChildCategoryController::class, 'deleteChildCategory'])->name('delete-childCategory');
    Route::get('/pdf-childCategory', [ChildCategoryController::class, 'pdfChildCategory'])->name('pdf.childCategory');

    // Offer Route
    route::get('/offer', [OfferController::class, 'offer'])->name('offer');
    route::get('/add-offer', [OfferController::class, 'addOffer'])->name('add.offer');
    route::post('/save-offer', [OfferController::class, 'saveOffer'])->name('save.offer');
    route::get('/delete-offer/{id}', [OfferController::class, 'deleteOffer'])->name('delete.offer');
    route::get('/edit-offer/{id}', [OfferController::class, 'editOffer'])->name('edit.offer');
    route::post('/update-offer', [OfferController::class, 'updateOffer'])->name('update.offer');
    route::get('/pdf-product', [OfferController::class, 'pdfProduct'])->name('pdf.product');
    //merchant offer
    Route::get('/merchant-offer', [OfferController::class, 'merchantOffer'])->name('merchant.offer');
    Route::post('/save-merchant-offer', [OfferController::class, 'saveMerchantOffer'])->name('save.merchant.offer');
    Route::get('/Approve-offer', [OfferController::class, 'approveOffer'])->name('approve.offer');
    Route::get('/approve-edit-offer/{id}', [OfferController::class, 'approveEditOffer'])->name('approve.edit.offer');




    //location
    Route::get('/convert-address-to-coordinates', 'LocationsController@convertAddressToCoordinates');
    Route::post('/find-nearest-offer', 'LocationsController@findNearestOffer');

    //
    // //QR code
    Route::get('/generate_qr_code', [QRCodeController::class, 'showQRCodeGenerator'])->name('generate_qr_code');
    Route::post('/generate_qr_code', [QRCodeController::class, 'generateAndSendQRCode'])->name('generate_qr_code.post');
    Route::post('/generate_qr_code_decline', [QRCodeController::class, 'generateAndSendDeclineQRCode'])->name('generate_qr_code_decline.post');

    // Order Route
    Route::get('/order', [OrderController::class, 'order'])->name('order');
    Route::get('/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('delete.order');
    Route::get('/edit-order/{id}', [OrderController::class, 'editOrder'])->name('edit.order');
    Route::post('/update-order', [OrderController::class, 'updateOrder'])->name('update.order');
    Route::get('/pdf-order', [OrderController::class, 'pdfOrder'])->name('pdf.order');

    // Inventory Route
    Route::get('/inventory', [InventoryController::class, 'inventory'])->name('inventory');
    Route::get('/add-inventory', [InventoryController::class, 'addInventory'])->name('add.inventory');
    Route::get('/pdf-inventory', [InventoryController::class, 'pdfInventory'])->name('pdf.inventory');
    Route::post('/save-inventory', [InventoryController::class, 'saveInventory'])->name('save.inventory');
    Route::get('/edit-inventory/{id}', [InventoryController::class, 'editInventory'])->name('edit.inventory');
    Route::post('/update-inventory', [InventoryController::class, 'updateInventory'])->name('update.inventory');
    Route::get('/delete-inventory/{id}', [InventoryController::class, 'deleteInventory'])->name('delete.inventory');
    // Site Configuration
    //site info
    Route::get('/site-info', [SiteConfigController::class, 'siteInfo'])->name('site.info');
    Route::post('/site-info', [SiteConfigController::class, 'siteInfoPost'])->name('site.info.post');
     //edit site info
     Route::get('/edit-site-info/{id}', [SiteConfigController::class, 'showEditSiteInfo'])->name('showEditSiteInfo');
     Route::post('/edit-site-info', [SiteConfigController::class, 'editSiteInfo'])->name('editSiteInfo');
    //Slider
    Route::get('/slider', [SliderController::class, 'slider'])->name('slider');
    Route::get('/add-slider', [SliderController::class, 'addSlider'])->name('add.slider');
    Route::post('/store-slider', [SliderController::class, 'storeSlider'])->name('store.slider');
    Route::get('/edit-slider/{id}', [SliderController::class, 'editSlider'])->name('edit.slider');
    Route::post('/update-slider', [SliderController::class, 'updateSlider'])->name('update.slider');
    Route::get('/delete-slider/{id}', [SliderController::class, 'deleteSlider'])->name('delete.slider');
    //banner
    Route::get('/banner', [BannerController::class, 'banner'])->name('banner');
    Route::get('/add-banner', [BannerController::class, 'addBanner'])->name('add.banner');
    Route::post('/store-banner', [BannerController::class, 'storeBanner'])->name('store.banner');
    Route::get('/edit-banner/{id}', [BannerController::class, 'editBanner'])->name('edit.banner');
    Route::get('/delete.banner/{id}', [BannerController::class, 'deleteBanner'])->name('delete.banner');
    Route::post('/update-banner', [BannerController::class, 'updateBanner'])->name('update.banner');
    //privacy_policy
    Route::get('/privacy_policy', [PrivacyPolicyController::class, 'privacyPolicy'])->name('privacy_policy');
    Route::post('/privacy_policy', [PrivacyPolicyController::class, 'storePrivacyPolicy'])->name('storePrivacyPolicy');
    //terms & Condition
    Route::get('/terms_conditions', [TearmsConditionController::class, 'termsConditions'])->name('terms_conditions');
    Route::post('/terms_conditions', [TearmsConditionController::class, 'storeTermsConditions'])->name('storeTermsConditions');
     //Social links & logos
     Route::get('/socialLinks', [SocialLinkController::class, 'showSocialLinks'])->name('showSocialLinks');
     Route::get('/addSocialLinks', [SocialLinkController::class, 'addSocialLinks'])->name('addSocialLinks');
     Route::post('/addSocialLinks', [SocialLinkController::class, 'socialLinks'])->name('socialLinks');
     Route::get('/editSocialLinks/{id}', [SocialLinkController::class, 'showEditSocialLinks'])->name('showEditSocialLinks');
     Route::post('/editSocialLinks/{id}', [SocialLinkController::class, 'editSocialLinks'])->name('editSocialLinks');
     Route::get('/deleteSocialLinks/{id}', [SocialLinkController::class, 'showDeleteSocialLinks'])->name('showDeleteSocialLinks');
     //about Route
    Route::get('/about',[AboutController::class,'about'])->name('about');
    Route::get('/add-about',[AboutController::class,'addAbout'])->name('add.about');
    Route::post('/store.about',[AboutController::class,'storeAbout'])->name('store.about');
    Route::get('/delete.abouts/{id}',[AboutController::class,'deleteAbout'])->name('delete.abouts');
    Route::get('/edit-abouts/{id}',[AboutController::class,'editAbout'])->name('edit.abouts');
    Route::post('/update-about',[AboutController::class,'updateAbout'])->name('update.about');

    //role and permission
    // role route
    Route::get('/role', [RoleController::class, 'role'])->name('role');
    Route::get('/add-role', [RoleController::class, 'addRole'])->name('add.role');
    Route::post('/store-role', [RoleController::class, 'storeRole'])->name('store.role');
    Route::get('/edit-role/{id}', [RoleController::class, 'editRole'])->name('edit.role');
    Route::post('/update-role', [RoleController::class, 'updateRole'])->name('update.role');
    Route::get('/delete-role/{id}', [RoleController::class, 'deleteRole'])->name('delete.role');
    // module route
    Route::get('/module', [ModuleController::class, 'module'])->name('module');
    Route::get('/add-module', [ModuleController::class, 'addModule'])->name('add.module');
    Route::post('/store-module', [ModuleController::class, 'storeModule'])->name('store.module');
    Route::get('/edit-module/{id}', [ModuleController::class, 'editModule'])->name('edit.module');
    Route::post('/update-module', [ModuleController::class, 'updateModule'])->name('update.module');
    Route::get('/delete-module/{id}', [ModuleController::class, 'deleteModule'])->name('delete.module');
    // sub Module route
    Route::get('/subModule', [SubModuleController::class, 'subModule'])->name('subModule');
    Route::get('/add-subModule', [SubModuleController::class, 'addSubModule'])->name('add.subModule');
    Route::post('/store-subModule', [SubModuleController::class, 'storeSubModule'])->name('store.subModule');
    Route::get('/edit-subModule/{id}', [SubModuleController::class, 'editSubModule'])->name('edit.subModule');
    Route::post('/update-subModule', [SubModuleController::class, 'updateSubModule'])->name('update.subModule');
    Route::get('/delete-subModule/{id}', [SubModuleController::class, 'deleteSubModule'])->name('delete.subModule');

    // Permission Route
    Route::get('/permission', [RolePermissionController::class, 'permission'])->name('permission');
    Route::get('/add-permission', [RolePermissionController::class, 'addPermission'])->name('add-permission');
    Route::post('/store-permission', [RolePermissionController::class, 'storePermission'])->name('store.permission');
    Route::get('/edit-permission/{id}', [RolePermissionController::class, 'editPermission'])->name('edit.permission');
    Route::post('/update-permission', [RolePermissionController::class, 'updatePermission'])->name('update.permission');
    Route::get('/delete-permission/{id}', [RolePermissionController::class, 'deletePermission'])->name('delete.permission');

    //access-control
    Route::get('/access-control', [PermissionAssignController::class, 'showAccessControl'])->name('access-control');
    Route::post('/access-control', [PermissionAssignController::class, 'accessControl'])->name('accessControl');
    Route::get('/add-assign-permission', [PermissionAssignController::class, 'addAssignPermission'])->name('add-assign-permission');
    Route::get('/edit-assign-permission/{id}', [PermissionAssignController::class, 'showEditAssignPermission'])->name('showEdit-assign-permission');
    Route::post('/edit-assign-permission', [PermissionAssignController::class, 'editAssignPermission'])->name('edit-assign-permission');
    Route::get('/delete-assign-permission/{id}', [PermissionAssignController::class, 'deleteAssignPermission'])->name('delete-assign-permission');
    //creating admin

    Route::get('/admin-list', [CreateAdminController::class, 'adminList'])->name('adminList');
    Route::post('/admin-list', [CreateAdminController::class, 'list'])->name('list');

    Route::get('/create-admin', [CreateAdminController::class, 'createAdmin'])->name('create-admin');
    Route::post('/create-admin', [CreateAdminController::class, 'adminCreate'])->name('adminCreate');

    Route::get('/edit-admin/{id}', [CreateAdminController::class, 'showEditAdmin'])->name('showEditAdmin');
    Route::post('/edit-admin/{id}', [CreateAdminController::class, 'editAdmin'])->name('editAdmin');

    Route::get('/delete-admin/{id}', [CreateAdminController::class, 'deleteAdmin'])->name('deleteAdmin');

    // Location and offer route

    Route::get('/geocode', [LocationController::class, 'showGeocode'])->name('showGeocode');
    Route::post('/geocode', [LocationController::class, 'geocode'])->name('geocode');
    // Route::get('/find-near-location', [LocationController::class, 'index']);

    // Route::get('/find-nearest-location', [LocationController::class, 'findNearestLocation']);
    // Route::get('find-places', [LocationController::class, 'index']);

    // Language Route
    Route::get('/lang-home', [LangController::class, 'index']);
    Route::get('/lang-change', [LangController::class, 'change'])->name('changeLang');
    //Commission
    Route::get('/commission', [CommissionController::class, 'showCommission'])->name('showCommission');
    Route::get('/showCommissionDetails/{id}', [CommissionController::class, 'showCommissionDetails'])->name('showCommissionDetails');
    Route::post('/commissions', [CommissionController::class, 'calculateAndDistributeCommission'])->name('commission.calculate');

    //Currency Route
    Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
    Route::get('/add-currency', [CurrencyController::class, 'addCurrency'])->name('add.currency');
    Route::post('/store-currency', [CurrencyController::class, 'storeCurrency'])->name('store.currency');
    Route::get('/edit-currency/{id}', [CurrencyController::class, 'editCurrency'])->name('edit.currency');
    Route::get('/delete-currency/{id}', [CurrencyController::class, 'deleteCurrency'])->name('delete.currency');
    Route::post('/update-currency/{id}', [CurrencyController::class, 'updateCurrency'])->name('update.currency');
    Route::post('/currency-load', [CurrencyController::class, 'loadCurrency'])->name('currency.load');


    Route::post('/currency_status', [CurrencyController::class, 'currencyStatus'])->name('currency.status');
    //default route
    Route::post('/get-category', [DefaultController::class, 'getCategory'])->name('get-category');
    Route::post('/commission', [DefaultController::class, 'commission'])->name('commission');
    Route::post('/get-merchant', [DefaultController::class, 'getMerchant'])->name('get-merchant');
    Route::post('/get-merchant_id', [DefaultController::class, 'getMerchantName'])->name('getMerchantName');
    Route::post('/get-permission', [DefaultController::class, 'getPermission'])->name('get-permission');
    Route::get('/search', [DefaultController::class, 'search'])->name('search');
    Route::post('/merchant', [DefaultController::class, 'searchMerchant'])->name('merchant');
    Route::post('/user', [DefaultController::class, 'user'])->name('user');
    Route::post('/user_name', [DefaultController::class, 'userName'])->name('userName');
    Route::post('/fixed_amount', [DefaultController::class, 'fixedAmount'])->name('fixedAmount');
    Route::post('/percentage_amount', [DefaultController::class, 'percentageAmount'])->name('percentageAmount');
    Route::post('/offer', [DefaultController::class, 'userCommissionOffer'])->name('offer');
    Route::post('/getCategory', [DefaultController::class, 'getCategoryNew'])->name('getCategoryNew');
    Route::post('/gotOffer', [DefaultController::class, 'gotOffer'])->name('gotOffer');
    Route::post('/get-offers', [DefaultController::class, 'getOffers'])->name('get-offers');
    Route::post('/get-areas', [DefaultController::class, 'getAreas'])->name('get-areas');
    Route::post('/get-placeName', [DefaultController::class, 'getPlaceName'])->name('get-placeName');
    Route::post('/get-fixedAmount', [DefaultController::class, 'getFixedAmount'])->name('get.fixedAmount');
    Route::post('/get-percentageAmount', [DefaultController::class, 'getPercentageAmount'])->name('get-percentageAmount');
    Route::get('/get-price', [DefaultController::class, 'getPrice'])->name('get-price');
    Route::post('/get-place-rate', [DefaultController::class, 'getPlaceRate'])->name('get-place-rate');
    Route::get('/offerFind', [DefaultController::class, 'findOffer'])->name('findOffer');
    Route::post('/minimum-purchase', [DefaultController::class, 'minimumPurchase'])->name('minimum-purchase');
    Route::post('/minimum', [DefaultController::class, 'minimum'])->name('minimum');
    Route::post('/placeName', [DefaultController::class, 'placeName'])->name('placeName');
    Route::get('/offerToFixed', [DefaultController::class, 'offerToFixed'])->name('offerToFixed');
    Route::get('/offerToPercentage', [DefaultController::class, 'offerToPercentage'])->name('offerToPercentage');
    Route::get('/offerToPurchaseAmount', [DefaultController::class, 'offerToPurchaseAmount'])->name('offerToPurchaseAmount');




    Route::get('/merchant-commission-store', [MerchantCommissionController::class, 'showMerchantCommissionStore'])->name('showMerchantCommissionStore');
    Route::post('/merchant-commission-store', [MerchantCommissionController::class, 'merchantCommissionStore'])->name('merchantCommissionStore');
    Route::get('/show-merchant-wise-commission/{id}', [MerchantCommissionController::class, 'Merchant_wise_commission'])->name('show.merchant_wise.commission');

    //Commission list
    Route::get('/list-commission', [UserCommissionController::class, 'showCommissionList'])->name('show.list.commission');
    Route::post('/list-commission', [UserCommissionController::class, 'commissionStoreList'])->name('commissionStoreList');

    Route::get('/user-commission/{id}', [UserCommissionController::class, 'showUserCommission'])->name('show.user.commission');
    Route::post('/user-commission/{id}', [UserCommissionController::class, 'userCommissionStore'])->name('userCommissionStore');
    Route::post('user.payment/{id}', [UserCommissionController::class, 'userPayment'])->name('user.payment');

    //payouts
    Route::get('/payout', [PayoutController::class, 'showPayout'])->name('showPayout');
    Route::post('/payout', [PayoutController::class, 'payout'])->name('payout');
    Route::get('/payoutDashboard', [PayoutDashboardController::class, 'showPayoutDashboard'])->name('showPayoutDashboard');
    //approve Payout
    Route::get('/approvePayout/{payoutId}/{status}', [PayoutDashboardController::class, 'approvePayout'])->name('approvePayout');
    //pay.withdraw
    route::get('/pay.withdraw', [WithdrawController::class, 'payWithdraw'])->name('pay.withdraw');
    route::post('/pay', [WithdrawController::class, 'pay'])->name('pay');


    //rate.ogg.place
    route::get('/rate-off-place', [RateOffPlaceController::class, 'rateOffPlace'])->name('rate.ogg.place');
    route::get('/add-rate', [RateOffPlaceController::class, 'addRate'])->name('add.rate');
    route::post('/store-rateOffPlace', [RateOffPlaceController::class, 'storeRateOffPlace'])->name('store.rateOffPlace');
    route::get('/edit-rate/{id}', [RateOffPlaceController::class, 'editRate'])->name('edit.rate');
    route::get('/delete-rate/{id}', [RateOffPlaceController::class, 'deleteRate'])->name('delete.rate');
    route::post('/Update.rateOffPlace', [RateOffPlaceController::class, 'UpdateRateOffPlace'])->name('Update.rateOffPlace');

    //footer
    //footer Menu
    Route::get('/footer-menu', [FootermenuController::class,'footerMenu'])->name('footer.menu');
    Route::get('/add-footerMenu', [FootermenuController::class,'addfooterMenu'])->name('add.footerMenu');
    Route::post('/store-menu', [FootermenuController::class,'storeMenu'])->name('store.menu');
    Route::get('/edit-menu/{id}', [FootermenuController::class,'editMenu'])->name('edit.menu');
    Route::post('/update-menu', [FootermenuController::class,'updateMenu'])->name('update.menu');
    Route::get('/delete-menu/{id}', [FootermenuController::class,'deleteMenu'])->name('delete.menu');
    //footer List
    Route::get('/footer_details',[FooterDetailController::class,'footer_details'])->name('footer.details');
    Route::get('/addFooter_details',[FooterDetailController::class,'showFooter_details'])->name('showFooter_details');
    Route::post('/footer_details',[FooterDetailController::class,'storeFooter_details'])->name('storeFooter_details');
    //edit footer details
    Route::get('/editFooter_details/{id}',[FooterDetailController::class,'showEditFooter_details'])->name('showEditFooter_details');
    Route::post('/editFooter_details/{id}',[FooterDetailController::class,'storeEditFooter_details'])->name('storeEditFooter_details');
    Route::get('/edit-footer_details/{id}', [FooterDetailController::class, 'editEditFooter_details'])->name('edit.footer_details');
    Route::post('/update-Footer_details/{id}',[FooterDetailController::class,'updateEditFooter_details'])->name('update.Footer_details');
    Route::get('/delete-footer_details/{id}', [FooterDetailController::class, 'deleteEditFooter_details'])->name('delete.footer_details');
    // Search Controller
    Route::post('/merchant-search',[SearchController::class,'merchantSearch'])->name('merchant.search');
    Route::post('/qrCode-search',[SearchController::class,'qrCodeSearch'])->name('qrCode.search');
    //online qrcode list


});

    // stripe payment method
    Route::get('/success', function () {
        return "Payment Success";
    });
    Route::get('/cancel', function () {
        return "Payment failed";
    });
    // Admin Register
    Route::get('/admin/register', [AdminAuthController::class, 'adminRegister'])->name('showRegister');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register');


    //Admin Login
    Route::redirect('/', '/admin/login');
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('showLogin');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

    //Admin Login
    Route::redirect('', '/admin/login');
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('showLogin');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');


    //Admin Logout
    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    //Admin Password-reset
    Route::get('/password/forgot', [AdminAuthController::class, 'showForgotForm'])->name('forgot.password.form');

    Route::post('/password/forgot', [AdminAuthController::class, 'sendResetLink'])->name('forgot.password.link');

    Route::get('/password/reset/{token}', [AdminAuthController::class, 'showResetForm'])->name('reset.password.form');

    Route::post('/password/reset', [AdminAuthController::class, 'resetPassword'])->name('reset.password');




    Route::get('/roles', [PermissionController::class]);

    Route::group(['middleware' => 'role:user'], function () {

        Route::get('/user', function () {

            return 'Welcome...!!';
        });
    });
