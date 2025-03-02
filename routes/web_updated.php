<?php

use App\Http\Controllers\site\settingController;
use App\Http\Controllers\site\permissionController;
use App\Http\Controllers\site\adminController;
use App\Http\Controllers\site\userController;
use App\Http\Controllers\site\packageController;
use App\Http\Controllers\site\providerController;
use App\Http\Controllers\site\user_noteController;
use App\Http\Controllers\site\marketController;
use App\Http\Controllers\site\salerController;
use App\Http\Controllers\site\rateController;
use App\Http\Controllers\site\pageController;
use App\Http\Controllers\site\common_questionController;
use App\Http\Controllers\site\sectionController;
use App\Http\Controllers\site\sub_sectionController;
use App\Http\Controllers\site\serviceController;
use App\Http\Controllers\site\media_fileController;
use App\Http\Controllers\site\our_locationController;
use App\Http\Controllers\site\shipping_typeController;
use App\Http\Controllers\site\excelController;
use App\Http\Controllers\site\unitController;
use App\Http\Controllers\site\offerController;
use App\Http\Controllers\site\orderController;
use App\Http\Controllers\site\countryController;
use App\Http\Controllers\site\cityController;
use App\Http\Controllers\site\neighborhoodController;
use App\Http\Controllers\site\sliderController;
use App\Http\Controllers\site\promo_codeController;
use App\Http\Controllers\site\bank_accountController;
use App\Http\Controllers\site\bank_transferController;
use App\Http\Controllers\site\contactController;
use App\Http\Controllers\site\adminReportController;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\StatisticsController;
use App\Http\Controllers\site\mainController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\admin\orderController as adminOrderController;
use App\Http\Controllers\admin\mainController as adminMainController;
use App\Http\Controllers\admin\serviceController as adminServiceController;
use App\Http\Controllers\admin\settingController as adminSettingController;

//Auth::loginUsingId(1);
//Auth::loginUsingId(363);

Route::middleware('lang')->group(function () {
    Route::get('site-print-order/{id}', [orderController::class,'print_order'])->name('site_print_order');
    Route::get('print-order/{id}', [adminOrderController::class ,'print_order'])->name('print_order');
});

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
| By : AbdelRahman - at : 03/2024
*/

/********* QR Code *********/
Route::get('show-qrcode/{id}', [mainController::class,'show_qrcode'])->name('show-qrcode');
Route::get('thanks', [mainController::class,'thanks'])->name('thanks');

/********* send_to_whatsapp *********/
Route::get('send_to_whatsapp', [paymentController::class, 'send_to_whatsapp'])->name('send_to_whatsapp');
Route::post('post_send_to_whatsapp', [paymentController::class, 'post_send_to_whatsapp'])->name('post_send_to_whatsapp');

/********* urway *********/
Route::get('urway', [paymentController::class, 'urway_payment'])->name('urway_payment');
Route::get('urway-status', [paymentController::class, 'urway_payment_status'])->name('urway_payment_status');
Route::get('urway_success', [paymentController::class, 'urway_success'])->name('urway_success');

/********* HyperPay *********/
Route::get('create-form', [paymentController::class, 'createForm'])->name('create-form');
Route::get('payment-result', [paymentController::class, 'paymentResult'])->name('payment-result');

/********* my_fatoorah *********/
Route::get('my_fatoorah', [paymentController::class, 'my_fatoorah'])->name('my_fatoorah');
Route::get('my_fatoorah_success', [paymentController::class, 'my_fatoorah_success'])->name('my_fatoorah_success');
Route::get('my_fatoorah_faild', [paymentController::class, 'my_fatoorah_faild'])->name('my_fatoorah_faild');

/********* surepay *********/
Route::get('surepay', [paymentController::class, 'surepay'])->name('surepay');
Route::get('surepay_success', [paymentController::class, 'surepay_success'])->name('surepay_success');
Route::get('surepay_faild', [paymentController::class, 'surepay_faild'])->name('surepay_faild');

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
| By : AbdelRahman - at : 03/2024
*/

Route::group(['namespace' => 'site'], function () {
    #ui
    Route::get('ui-page/{name}', [mainController::class, 'ui_page'])->name('ui_page');
    Route::any('search_by_keywords', [mainController::class, 'search_by_keywords'])->name('search_by_keywords');

    #change Lang
    Route::get('site-change-lang/{lang}', [mainController::class, 'language'])->name('site_language');
    /*  Lang middleware */
    Route::middleware('lang')->group(function () {
        ############ start mainController ############
        #Login
        Route::get('log-in', [mainController::class, 'login'])->name('site_login');
        Route::post('log-in', [mainController::class, 'post_login'])->name('site_post_login');
        #Register
        Route::get('register', [mainController::class, 'register'])->name('site_register');
        Route::post('register', [mainController::class, 'post_register'])->name('site_post_register');
        #active
        Route::get('site-active/{id}', [mainController::class, 'active'])->name('site_active');
        //Route::get('site-active', [mainController::class, 'active'])->name('site_active');
        //Route::post('site-active', [mainController::class, 'post_active'])->name('site_post_active');
        #Forget_password
        Route::get('forget-password', [mainController::class, 'forget_password'])->name('site_forget_password');
        Route::post('forget-password', [mainController::class, 'post_forget_password'])->name('site_post_forget_password');
        #Reset_password
        Route::get('reset-password/{id}', [mainController::class, 'reset_password'])->name('site_reset_password');
        Route::post('reset-password', [mainController::class, 'post_reset_password'])->name('site_post_reset_password');
        #Logout
        Route::get('log-out', [mainController::class, 'logout'])->name('site_logout');
        #Home
        Route::get('/', [mainController::class, 'home'])->name('site_home');
        #Common question
        Route::get('common-question', [mainController::class, 'common_question'])->name('common_question');
        #site-condition
        Route::get('site-condition', [mainController::class, 'site_condition'])->name('site_condition');
        #Contact us
        Route::get('contact-us/{type}', [mainController::class, 'contact_us'])->name('contact_us');
        Route::post('contact-us', [mainController::class, 'post_contact_us'])->name('post_contact_us');
        Route::post('site-contact-us', [mainController::class, 'post_contact_us'])->name('site_sendcontact');

        Route::any('search', [mainController::class, 'search'])->name('site_search');
        Route::any('questions', [mainController::class, 'questions'])->name('site_questions');
        Route::any('package_info', [mainController::class, 'package_info'])->name('site_package_info');
        Route::any('notifications', [mainController::class, 'notifications'])->name('site_notifications');
        #About us
        Route::get('page/{title}', [mainController::class, 'page'])->name('page');
        Route::get('media-center/{type}', [mainController::class, 'media_center'])->name('media_center');
        Route::get('show-media/{media_id}', [mainController::class, 'show_media'])->name('show_media');
        Route::get('show-slider/{slider_id}', [mainController::class, 'show_slider'])->name('show_slider');
        #all-sections
        Route::get('partners', [mainController::class, 'partners'])->name('partners');
        Route::get('exhibitions', [orderController::class, 'exhibitions'])->name('exhibitions');
        Route::get('all-offers', [orderController::class, 'all_offers'])->name('all-offers');
        Route::get('all-sections', [orderController::class, 'all_sections'])->name('all-sections');
        Route::get('all-services/{section_id}', [orderController::class, 'all_services'])->name('all-services');
        Route::get('all-branches', [mainController::class, 'all_branches'])->name('all-branches');
        Route::get('show-branche/{id}', [mainController::class, 'show_branche'])->name('show-branche');
        #Sections
        Route::get('show-section/{section_id}', [orderController::class, 'show_section'])->name('show-section');
        Route::get('show-sub-section/{sub_section_id}', [orderController::class, 'show_sub_section'])->name('show-sub-section');
        Route::get('show-service/{service_id}', [orderController::class, 'show_service'])->name('show-service');
        Route::any('edit-service/{service_id}', [orderController::class, 'edit_service'])->name('edit-service');
        Route::any('post-service', [orderController::class, 'post_service'])->name('post-service');
        #ajax start
        Route::any('search-service', [orderController::class, 'search'])->name('search-service');
        Route::get('user-account', [orderController::class, 'account'])->name('user-account');
        Route::post('user-post-account', [orderController::class, 'post_account'])->name('user-post-account');
        Route::get('pay', [orderController::class, 'pay'])->name('pay-service');
        #ajax
        Route::post('show-service-location', [orderController::class, 'show_service_location'])->name('show-service_location');

        Route::post('show-service-count', [orderController::class, 'show_service_count'])->name('show-service_count');
        Route::any('check_promo', [orderController::class, 'check_promo'])->name('check_promo');
        #ajax end
        Route::get('all-speakers', [orderController::class, 'all_speakers'])->name('all-speakers');
        #mail_list
        Route::post('mail-list', [mainController::class, 'mail_list'])->name('mail_list');
        ############ end mainController ############

        ############ start orderController ############
        /*  Auth middleware */
        Route::middleware('siteAuth')->group(function () {
            #saler
            Route::get('thanks', [orderController::class, 'thanks'])->name('site_thanks');
            Route::get('tickets', [orderController::class, 'tickets'])->name('site_tickets');
            Route::get('wallet', [orderController::class, 'wallet'])->name('site_wallet');
            #mainController
            Route::any('all_clients', [mainController::class, 'all_clients'])->name('site_all_clients');
            Route::any('all_fav_clients', [mainController::class, 'all_fav_clients'])->name('site_all_fav_clients');
            Route::any('all_blocked_clients', [mainController::class, 'all_blocked_clients'])->name('site_all_blocked_clients');
            Route::any('all_visitor_clients', [mainController::class, 'all_visitor_clients'])->name('site_all_visitor_clients');
            Route::any('show_client/{id}', [mainController::class, 'show_client'])->name('site_show_client');
            Route::any('all_packages', [mainController::class, 'all_packages'])->name('site_all_packages');
            Route::any('subscripe_package/{id}', [mainController::class, 'subscripe_package'])->name('site_subscripe_package');
            Route::any('all_rooms', [mainController::class, 'all_rooms'])->name('site_all_rooms');
            Route::any('show_chat/{id}', [mainController::class, 'show_chat'])->name('site_show_chat');
            Route::any('show_room/{id}', [mainController::class, 'show_room'])->name('site_show_room');
            Route::any('ajax_show_room/{id}', [mainController::class, 'ajax_show_room'])->name('site_ajax_show_room');
            Route::any('store_chat', [mainController::class, 'store_chat'])->name('site_store_chat');
            Route::any('add_to_favourite/{id}', [mainController::class, 'add_to_favourite'])->name('site_add_to_favourite');
            Route::any('add_to_block_list/{id}', [mainController::class, 'add_to_block_list'])->name('site_add_to_block_list');
            #orders
            Route::get('new_order', [orderController::class, 'new_order'])->name('site_new_order');
            Route::get('new_orders', [orderController::class, 'new_orders'])->name('site_new_orders');
            Route::get('current_orders', [orderController::class, 'current_orders'])->name('site_current_orders');
            Route::get('change_order/{id}/{status}', [orderController::class, 'change_order'])->name('site_change_order');
            Route::get('orders', [orderController::class, 'orders'])->name('site_orders');
            Route::get('order/{step}', [orderController::class, 'order'])->name('site_order');
            Route::get('add-order/{service_id}', [orderController::class, 'add_order'])->name('site_add_order');
            Route::post('store_order', [orderController::class, 'store_order'])->name('site_store_order');
            #profile
            Route::get('profile', [mainController::class, 'profile'])->name('site_profile');
            Route::post('update_email', [mainController::class, 'post_update_email'])->name('site_post_update_email');
            Route::post('update_password', [mainController::class, 'post_update_password'])->name('site_post_update_password');
            Route::post('profile', [mainController::class, 'post_profile'])->name('site_post_profile');
        });
        ############ end orderController ############
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
| By : AbdelRahman - at : 03/2024
*/


Route::group(['namespace' => 'admin'], function () {
    #Get Statistics

    #change lang
    Route::get('change-lang/{lang}', [adminMainController::class, 'language'])->name('admin_language');
    Route::post('fill_salers', [marketController::class, 'fill_salers'])->name('fill_salers');
    Route::post('get_neighborhood', [adminMainController::class, 'get_neighborhood'])->name('get_neighborhood');
    #seen contact
    Route::post('contact-seen', [adminMainController::class, 'contact_seen'])->name('contact-seen');
    #rmvImage
    Route::post('rmvImage', ['uses' => [serviceController::class,'rmvImage'], 'as' => 'rmvImage']);
    Route::post('rmvMarketImage', ['uses' => [marketController::class,'rmvImage'], 'as' => 'rmvMarketImage']);
    /*  Lang middleware */
    Route::middleware('lang')->group(function () {
        #login
        Route::get('login', [adminMainController::class, 'login'])->name('admin_login');
        Route::post('login', [adminMainController::class, 'post_login'])->name('admin_post_login');
        #logout
        Route::get('logout', [adminMainController::class, 'logout'])->name('admin_logout');

        /*  Auth middleware */
        Route::middleware('adminAuth')->group(function () {
            #Statics in dashboard
            Route::get('/admin/user-stats', [StatisticsController::class, 'getUserStats']);
            Route::get('/api/revenue-stats', [StatisticsController::class, 'getRevenueStats']);
            Route::get('/api/visit-stats', [StatisticsController::class, 'getVisitStats']);
            #home
            Route::get('admin-panel', [adminMainController::class, 'home'])->name('admin_home');

            Route::middleware('hasPermission')->group(function () {
                /******************************************** settingController Start ********************************************/
                Route::get(
                    'settings',
                    [
                        'uses' => [settingController::class,'index'],
                        'as' => 'settings',
                        'title' => 'الإعدادات',
                        'icon' => '<i class="fa fa-cog"></i>',
                        'child' => [
                            'updatesetting',
                            'updateintro',
                            //'updatesocial',
                            //'updatelocation',
                            'updateseo',
                        ]
                    ]
                );

                #Update setting
                Route::post('update-setting', ['uses' => [settingController::class, 'update'], 'as' => 'updatesetting', 'title' => 'تحديث الإعدادات']);
                #Update intro
                Route::post('update-intro', ['uses' => [settingController::class, 'intro'], 'as' => 'updateintro', 'title' => 'اكواد جوجل']);
                #Update social
                Route::post('update-social', ['uses' => [settingController::class, 'social'], 'as' => 'updatesocial', 'title' => 'تحديث مواقع التواصل']);
                #Update location
                Route::post('update-location', ['uses' => [settingController::class, 'location'], 'as' => 'updatelocation', 'title' => 'تحديث الخريطة']);
                #Update seo
                Route::post('update-seo', ['uses' => [settingController::class, 'seo'], 'as' => 'updateseo', 'title' => 'تحديث محركات البحث']);

                /********************************************* settingController End *********************************************/

                /******************************************** permissionController Start ********************************************/
                Route::get(
                    'permissions',
                    [
                        'uses' => [permissionController::class, 'index'],
                        'as' => 'permissions',
                        'title' => 'الصلاحيات',
                        'icon' => '<i class="fa fa-cog"></i>',
                        'child' => [
                            'addpagepermission',
                            'addpermission',
                            'editpagepermission',
                            'updatepermission',
                            'deletepermission',
                        ]
                    ]
                );

                #Add permission page
                Route::get('add-page-permission', ['uses' => [permissionController::class, 'add'], 'as' => 'addpagepermission', 'title' => 'صفحة اضافة صلاحية']);
                #Add permission
                Route::post('add-permission', ['uses' => [permissionController::class, 'store'], 'as' => 'addpermission', 'title' => 'اضافة صلاحية']);
                #Edit permission page
                Route::get('edit-page-permission/{role_id}', ['uses' => [permissionController::class, 'edit'], 'as' => 'editpagepermission', 'title' => 'صفحة تعديل صلاحية']);
                #Update permission
                Route::post('update-permission', ['uses' => [permissionController::class, 'update'], 'as' => 'updatepermission', 'title' => 'تعديل صلاحية']);
                #Delete permission
                Route::post('delete-permission', ['uses' => [permissionController::class, 'delete'], 'as' => 'deletepermission', 'title' => 'حذف صلاحية']);

                /********************************************* permissionController End *********************************************/

                /******************************************** adminController Start ********************************************/
                Route::get(
                    'admins',
                    [
                        'uses' => [adminController::class, 'index'],
                        'as' => 'admins',
                        'title' => 'المديرين',
                        'icon' => '<i class="fa fa-user-circle"></i>',
                        'child' => [
                            'addadmin',
                            'updateadmin',
                            'deleteadmin',
                            'deleteadmins',
                        ]
                    ]
                );

                #Add admin
                Route::post('add-admin', ['uses' => [adminController::class, 'store'], 'as' => 'addadmin', 'title' => 'اضافة مدير']);
                #Update admin
                Route::post('update-admin', ['uses' => [adminController::class, 'update'], 'as' => 'updateadmin', 'title' => 'تعديل مدير']);
                #Delete admin
                Route::post('delete-admin', ['uses' => [adminController::class, 'delete'], 'as' => 'deleteadmin', 'title' => 'حذف مدير']);
                #Delete admins
                Route::post('delete-admins', ['uses' => [adminController::class, 'delete_all'], 'as' => 'deleteadmins', 'title' => 'حذف اكثر من مدير']);

                /********************************************* adminController End *********************************************/

                /******************************************** userController Start ********************************************/
                Route::get(
                    'users',
                    [
                        'uses' => [userController::class, 'index'],
                        'as' => 'users',
                        'title' => 'الأعضاء',
                        'icon' => '<i class="fa fa-users"></i>',
                        'child' => [
                            'adduser',
                            'updateuser',
                            'updatepackageuser',
                            //'sendnotifyuser',
                            'deleteuser',
                            'deleteusers',
                            'changestatususer',
                            'avataruserseen',
                            // 'changesee_familyuser',
                            // 'checkout_wallet',
                            // 'userorders',
                            // 'userpaid',
                        ]
                    ]
                );

                #Add User
                Route::post('add-user', ['uses' => [userController::class, 'store'], 'as' => 'adduser', 'title' => 'اضافة عضو']);
                #Update User
                Route::post('update-user', ['uses' => [userController::class, 'update'], 'as' => 'updateuser', 'title' => 'تعديل عضو']);
                Route::post('updatepackage-user', ['uses' => [userController::class, 'update_package'], 'as' => 'updatepackageuser', 'title' => 'تعديل باقة عضو']);
                #Send notify
                Route::post('send-notify-user', ['uses' => [userController::class, 'send_notify'], 'as' => 'sendnotifyuser', 'title' => 'أرسال إشعار']);
                #Change User Status
                Route::post('change-user-status', ['uses' => [userController::class, 'change_user_status'], 'as' => 'changestatususer', 'title' => 'بتغير حالة عضو']);
                Route::post('avatar-user-seen', ['uses' => [userController::class, 'avatar_user_seen'], 'as' => 'avataruserseen', 'title' => 'تأكيد الصورة الشخصية']);
                Route::post('change-user-see_family', ['uses' => [userController::class, 'change_user_see_family'], 'as' => 'changesee_familyuser', 'title' => 'بتغير حالة ظهور السوق الخيري']);
                #Delete User
                Route::post('delete-user', ['uses' => [userController::class, 'delete'], 'as' => 'deleteuser', 'title' => 'حذف عضو']);
                #Delete Users
                Route::post('delete-users', ['uses' => [userController::class, 'delete_all'], 'as' => 'deleteusers', 'title' => 'حذف اكثر من عضو']);
                #checkout wallet
                Route::get('user-orders/{id}', ['uses' => [userController::class, 'orders'], 'as' => 'userorders', 'title' => 'عرض حسابات عضو']);
                Route::post('user-paid', ['uses' => [userController::class, 'paid'], 'as' => 'userpaid', 'title' => 'تسوية حساب عضو']);
                Route::post('checkout_wallet', ['uses' => [userController::class, 'checkout_wallet'], 'as' => 'checkout_wallet', 'title' => 'تسوية حساب عضو']);

                /********************************************* userController End *********************************************/

                /******************************************** packageController Start *****************************************/
                Route::get(
                    'packages',
                    [
                        'uses' => [packageController::class, 'index'],
                        'as' => 'packages',
                        'title' => 'الباقات',
                        'icon' => '<i class="nav-icon fas fa-dollar-sign"></i>',
                        'child' => [
                            'addpackage',
                            'editpackage',
                            'updatepackage',
                            'deletepackage',
                            'deletepackages',
                        ]
                    ]
                );

                #Add package
                Route::post('add-package', ['uses' => [packageController::class, 'store'], 'as' => 'addpackage', 'title' => 'اضافة باقة']);
                #Edit package page
                Route::get('edit-package/{id}', ['uses' => [packageController::class, 'edit'], 'as' => 'editpackage', 'title' => 'صفحة تعديل باقة']);
                #Update package
                Route::post('update-package', ['uses' => [packageController::class, 'update'], 'as' => 'updatepackage', 'title' => 'تعديل باقة']);
                #Delete package
                Route::post('delete-package', ['uses' => [packageController::class, 'delete'], 'as' => 'deletepackage', 'title' => 'حذف باقة']);
                #Delete packages
                Route::post('delete-packages', ['uses' => [packageController::class, 'delete_all'], 'as' => 'deletepackages', 'title' => 'حذف اكثر من باقة']);

                /********************************************* packageController End *********************************************/

                /******************************************** providerController Start ********************************************/
                /*Route::get(
                    'providers',
                    [
                        'uses' => [providerController::class, 'index'], 'as' => 'providers', 'title' => 'الفرع', 'icon' => '<i class="fa fa-users"></i>',
                        'child' => [
                            'addprovider',
                            'updateprovider',
                            // 'sendnotifyprovider',
                            'deleteprovider',
                            'deleteproviders',
                            'changestatusprovider',
                            // 'changefavprovider',
                            // 'confirmprovider',
                            //'providerorders',
                            //'providerpaid',
                        ]
                    ]
                );*/

                #Add Provider
                Route::post('add-provider', ['uses' => [providerController::class, 'store'], 'as' => 'addprovider', 'title' => 'اضافة عنصر']);
                #Update Provider
                Route::post('update-provider', ['uses' => [providerController::class, 'update'], 'as' => 'updateprovider', 'title' => 'تعديل عنصر']);
                #Send notify
                Route::post('send-notify-provider', ['uses' => [providerController::class, 'send_notify'], 'as' => 'sendnotifyprovider', 'title' => 'أرسال إشعار']);
                #Change Provider Status
                Route::post('change-provider-status', ['uses' => [providerController::class, 'change_provider_status'], 'as' => 'changestatusprovider', 'title' => 'بتغير حالة عنصر']);
                Route::post('confirm-provider', ['uses' => [providerController::class, 'confirm_provider'], 'as' => 'confirmprovider', 'title' => 'تفعيل حساب عنصر']);
                Route::post('change-provider-fav', ['uses' => [providerController::class, 'change_provider_fav'], 'as' => 'changefavprovider', 'title' => 'بتميز عنصر']);
                #Delete Provider
                Route::post('delete-provider', ['uses' => [providerController::class, 'delete'], 'as' => 'deleteprovider', 'title' => 'حذف عنصر']);
                #Delete Providers
                Route::post('delete-providers', ['uses' => [providerController::class, 'delete_all'], 'as' => 'deleteproviders', 'title' => 'حذف اكثر من عنصر']);
                #provider orders
                Route::get('provider-orders/{id}', ['uses' => [providerController::class, 'orders'], 'as' => 'providerorders', 'title' => 'عرض حسابات عنصر']);
                Route::post('provider-paid', ['uses' => [providerController::class, 'paid'], 'as' => 'providerpaid', 'title' => 'تسوية حساب عنصر']);

                /********************************************* providerController End *********************************************/

                /******************************************** user_noteController Start ********************************************/
                /*Route::get(
                    'user_notes/{user_id}',
                    [
                        'uses' => [user_noteController::class, 'index'], 'as' => 'user_notes', 'title' => 'ملاحظات الفروع', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'adduser_note',
                            'updateuser_note',
                            'deleteuser_note',
                            'deleteuser_notes',
                        ]
                    ]
                );*/

                #Add user_note
                Route::post('add-user_note', ['uses' => [user_noteController::class, 'store'], 'as' => 'adduser_note', 'title' => 'اضافة عنصر']);
                #Update user_note
                Route::post('update-user_note', ['uses' => [user_noteController::class, 'update'], 'as' => 'updateuser_note', 'title' => 'تعديل عنصر']);
                #Delete user_note
                Route::post('delete-user_note', ['uses' => [user_noteController::class, 'delete'], 'as' => 'deleteuser_note', 'title' => 'حذف عنصر']);
                #Delete user_notes
                Route::post('delete-user_notes', ['uses' => [user_noteController::class, 'delete_all'], 'as' => 'deleteuser_notes', 'title' => 'حذف اكثر من عنصر']);

                /********************************************* user_noteController End *********************************************/

                /******************************************** marketController Start ********************************************/
                /*Route::get(
                    'markets',
                    [
                        'uses' => [marketController::class, 'index'], 'as' => 'markets', 'title' => 'المحاسبين', 'icon' => '<i class="fa fa-users"></i>',
                        'child' => [
                            // 'newmarket',
                            'addmarket',
                            // 'editmarket',
                            'updatemarket',
                            //'sendnotifymarket',
                            'deletemarket',
                            'deletemarkets',
                            'changestatusmarket',
                            //'changefavmarket',
                            // 'changeactivemarket',
                            // 'changecan_ordermarket',
                            // 'confirmmarket',
                            //'marketorders',
                            //'marketpaid',
                        ]
                    ]
                );*/

                #Add market
                // Route::get('new-market', ['uses' => [marketController::class, 'new'], 'as' => 'newmarket', 'title' => 'اضافة عنصر']);
                Route::post('add-market', ['uses' => [marketController::class, 'store'], 'as' => 'addmarket', 'title' => 'اضافة عنصر']);
                #Update market
                // Route::get('edit-market/{id}', ['uses' => [marketController::class, 'edit'], 'as' => 'editmarket', 'title' => 'صفحة تعديل عنصر']);
                Route::post('update-market', ['uses' => [marketController::class, 'update'], 'as' => 'updatemarket', 'title' => 'تعديل عنصر']);
                #Send notify
                Route::post('send-notify-market', ['uses' => [marketController::class, 'send_notify'], 'as' => 'sendnotifymarket', 'title' => 'أرسال إشعار']);
                #Change market Status
                Route::post('change-market-active', ['uses' => [marketController::class, 'change_market_active'], 'as' => 'changeactivemarket', 'title' => 'بتفعيل جوال عنصر']);
                Route::post('change-market-status', ['uses' => [marketController::class, 'change_market_status'], 'as' => 'changestatusmarket', 'title' => 'بتغير حالة عنصر']);
                Route::post('change-market-fav', ['uses' => [marketController::class, 'change_market_fav'], 'as' => 'changefavmarket', 'title' => 'بتميز عنصر']);
                Route::post('changecan_ordermarket', ['uses' => [marketController::class, 'changecan_ordermarket'], 'as' => 'changecan_ordermarket', 'title' => 'بامكانية الطلب من عنصر']);
                Route::post('confirm-market', ['uses' => [marketController::class, 'confirm_market'], 'as' => 'confirmmarket', 'title' => 'تفعيل عنصر']);
                #Delete market
                Route::post('delete-market', ['uses' => [marketController::class, 'delete'], 'as' => 'deletemarket', 'title' => 'حذف عنصر']);
                #Delete markets
                Route::post('delete-markets', ['uses' => [marketController::class, 'delete_all'], 'as' => 'deletemarkets', 'title' => 'حذف اكثر من عنصر']);
                #market orders
                Route::get('market-orders/{id}', ['uses' => [marketController::class, 'orders'], 'as' => 'marketorders', 'title' => 'عرض حسابات عنصر']);
                Route::post('market-paid', ['uses' => [marketController::class, 'paid'], 'as' => 'marketpaid', 'title' => 'تسوية حساب عنصر']);

                /********************************************* marketController End *********************************************/

                /******************************************** salerController Start ********************************************/
                /*Route::get(
                    'salers',
                    [
                        'uses' => [salerController::class, 'index'], 'as' => 'salers', 'title' => 'الاطباء', 'icon' => '<i class="fa fa-users"></i>',
                        'child' => [
                            // 'newsaler',
                            'addsaler',
                            // 'editsaler',
                            'updatesaler',
                            //'sendnotifysaler',
                            'deletesaler',
                            'deletesalers',
                            'changestatussaler',
                            //'changefavsaler',
                            // 'changeactivesaler',
                            // 'changecan_ordersaler',
                            // 'confirmsaler',
                            //'salerorders',
                            //'salerpaid',
                        ]
                    ]
                );*/

                #Add saler
                // Route::get('new-saler', ['uses' => [salerController::class, 'new'], 'as' => 'newsaler', 'title' => 'اضافة عنصر']);
                Route::post('add-saler', ['uses' => [salerController::class, 'store'], 'as' => 'addsaler', 'title' => 'اضافة عنصر']);
                #Update saler
                // Route::get('edit-saler/{id}', ['uses' => [salerController::class, 'edit'], 'as' => 'editsaler', 'title' => 'صفحة تعديل عنصر']);
                Route::post('update-saler', ['uses' => [salerController::class, 'update'], 'as' => 'updatesaler', 'title' => 'تعديل عنصر']);
                #Send notify
                Route::post('send-notify-saler', ['uses' => [salerController::class, 'send_notify'], 'as' => 'sendnotifysaler', 'title' => 'أرسال إشعار']);
                #Change saler Status
                Route::post('change-saler-active', ['uses' => [salerController::class, 'change_saler_active'], 'as' => 'changeactivesaler', 'title' => 'بتفعيل جوال عنصر']);
                Route::post('change-saler-status', ['uses' => [salerController::class, 'change_saler_status'], 'as' => 'changestatussaler', 'title' => 'بتغير حالة عنصر']);
                Route::post('change-saler-fav', ['uses' => [salerController::class, 'change_saler_fav'], 'as' => 'changefavsaler', 'title' => 'بتميز عنصر']);
                Route::post('changecan_ordersaler', ['uses' => [salerController::class, 'changecan_ordersaler'], 'as' => 'changecan_ordersaler', 'title' => 'بامكانية الطلب من عنصر']);
                Route::post('confirm-saler', ['uses' => [salerController::class, 'confirm_saler'], 'as' => 'confirmsaler', 'title' => 'تفعيل عنصر']);
                #Delete saler
                Route::post('delete-saler', ['uses' => [salerController::class, 'delete'], 'as' => 'deletesaler', 'title' => 'حذف عنصر']);
                #Delete salers
                Route::post('delete-salers', ['uses' => [salerController::class, 'delete_all'], 'as' => 'deletesalers', 'title' => 'حذف اكثر من عنصر']);
                #saler orders
                Route::get('saler-orders/{id}', ['uses' => [salerController::class, 'orders'], 'as' => 'salerorders', 'title' => 'عرض حسابات عنصر']);
                Route::post('saler-paid', ['uses' => [salerController::class, 'paid'], 'as' => 'salerpaid', 'title' => 'تسوية حساب عنصر']);

                /********************************************* salerController End *********************************************/

                /******************************************** rateController Start ********************************************/
                // Route::get(
                //      'rates',
                //      [
                //          'uses' => [rateController::class, 'index'], 'as' => 'rates', 'title' => 'التقييمات', 'icon' => '<i class="fa fa-star"></i>',
                //          'child' => [
                //              //'seenrate',
                //              'deleterate',
                //              'deleterates',
                //          ]
                //      ]
                //  );

                #update seen rate
                Route::post('seen-rate', ['uses' => [rateController::class, 'seen_rate'], 'as' => 'seenrate', 'title' => 'تغيير حالة تقييم']);
                #Delete Provider
                Route::post('delete-rate', ['uses' => [rateController::class, 'delete'], 'as' => 'deleterate', 'title' => 'حذف تقييم']);
                #Delete Providers
                Route::post('delete-rates', ['uses' => [rateController::class, 'delete_all'], 'as' => 'deleterates', 'title' => 'حذف اكثر من تقييم']);

                /********************************************* rateController End *********************************************/

                /******************************************** pageController Start ********************************************/
                Route::get(
                    'pages',
                    [
                        'uses' => [pageController::class, 'index'],
                        'as' => 'pages',
                        'title' => 'الصفحات الاساسية',
                        'icon' => '<i class="fa fa-cog"></i>',
                        'child' => [
                            //'addpage',
                            'editpagepage',
                            'updatepage',
                            //'deletepage',
                            //'deletepages',
                        ]
                    ]
                );

                #Add page
                Route::post('add-page', ['uses' => [pageController::class, 'store'], 'as' => 'addpage', 'title' => 'اضافة صفحة']);
                #Edit page page
                Route::get('edit-page-page/{id}', ['uses' => [pageController::class, 'edit'], 'as' => 'editpagepage', 'title' => 'صفحة تعديل موضوع']);
                #Update page
                Route::post('update-page', ['uses' => [pageController::class, 'update'], 'as' => 'updatepage', 'title' => 'تعديل صفحة']);
                #Delete page
                Route::post('delete-page', ['uses' => [pageController::class, 'delete'], 'as' => 'deletepage', 'title' => 'حذف صفحة']);
                #Delete pages
                Route::post('delete-pages', ['uses' => [pageController::class, 'delete_all'], 'as' => 'deletepages', 'title' => 'حذف اكثر من صفحة']);

                /********************************************* pageController End *********************************************/

                /******************************************** common_questionController Start ********************************************/
                Route::get(
                    'common_questions',
                    [
                        'uses' => [common_questionController::class, 'index'],
                        'as' => 'common_questions',
                        'title' => 'الاسئلة المتداولة',
                        'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            //'addpagecommon_question',
                            'addcommon_question',
                            //'editpagecommon_question',
                            'updatecommon_question',
                            'deletecommon_question',
                            'deletecommon_questions',
                        ]
                    ]
                );

                #Add common_question page
                Route::get('add-page-common_question', ['uses' => [common_questionController::class, 'add'], 'as' => 'addpagecommon_question', 'title' => 'صفحة اضافة عنصر']);
                #Add common_question
                Route::post('add-common_question', ['uses' => [common_questionController::class, 'store'], 'as' => 'addcommon_question', 'title' => 'اضافة عنصر']);
                #Edit common_question page
                Route::get('edit-page-common_question/{id}', ['uses' => [common_questionController::class, 'edit'], 'as' => 'editpagecommon_question', 'title' => 'صفحة تعديل عنصر']);
                #Update common_question
                Route::post('update-common_question', ['uses' => [common_questionController::class, 'update'], 'as' => 'updatecommon_question', 'title' => 'تعديل عنصر']);
                #Delete common_question
                Route::post('delete-common_question', ['uses' => [common_questionController::class, 'delete'], 'as' => 'deletecommon_question', 'title' => 'حذف عنصر']);
                #Delete common_questions
                Route::post('delete-common_questions', ['uses' => [common_questionController::class, 'delete_all'], 'as' => 'deletecommon_questions', 'title' => 'حذف اكثر من عنصر']);

                /********************************************* common_questionController End *********************************************/

                /******************************************** sectionController Start ********************************************/
                Route::get(
                    'sections',
                    [
                        'uses' => [sectionController::class, 'index'],
                        'as' => 'sections',
                        'title' => 'اقسام المدونة',
                        'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'addsection',
                            'updatesection',
                            //'sendnotifysection',
                            //'changestatussection',
                            'deletesection',
                            'deletesections',
                        ]
                    ]
                );

                #Add section
                Route::post('add-section', ['uses' => [sectionController::class, 'store'], 'as' => 'addsection', 'title' => 'اضافة قسم']);
                #Update section
                Route::post('update-section', ['uses' => [sectionController::class, 'update'], 'as' => 'updatesection', 'title' => 'تعديل قسم']);
                #Send notify
                // Route::post('send-notify-section', ['uses' => [sectionController::class, 'send_notify'], 'as' => 'sendnotifysection', 'title' => 'أرسال إشعار']);
                Route::post('change-section-status', ['uses' => [sectionController::class, 'change_section_status'], 'as' => 'changestatussection', 'title' => 'حالة القسم']);
                #Delete section
                Route::post('delete-section', ['uses' => [sectionController::class, 'delete'], 'as' => 'deletesection', 'title' => 'حذف قسم']);
                #Delete sections
                Route::post('delete-sections', ['uses' => [sectionController::class, 'delete_all'], 'as' => 'deletesections', 'title' => 'حذف اكثر من قسم']);

                /********************************************* sectionController End *********************************************/

                /******************************************** sub_sectionController Start ********************************************/
                /*Route::get(
                    'sub_sections/{user_id}',
                    [
                        'uses' => [sub_sectionController::class, 'index'], 'as' => 'sub_sections', 'title' => 'أقسام التجار', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'addsub_section',
                            'updatesub_section',
                            'deletesub_section',
                            'deletesub_sections',
                        ]
                    ]
                );*/

                #Add sub_section
                Route::post('add-sub_section', ['uses' => [sub_sectionController::class, 'store'], 'as' => 'addsub_section', 'title' => 'اضافة قسم']);
                #Update sub_section
                Route::post('update-sub_section', ['uses' => [sub_sectionController::class, 'update'], 'as' => 'updatesub_section', 'title' => 'تعديل قسم']);
                #Delete sub_section
                Route::post('delete-sub_section', ['uses' => [sub_sectionController::class, 'delete'], 'as' => 'deletesub_section', 'title' => 'حذف قسم']);
                #Delete sub_sections
                Route::post('delete-sub_sections', ['uses' => [sub_sectionController::class, 'delete_all'], 'as' => 'deletesub_sections', 'title' => 'حذف اكثر من قسم']);

                /********************************************* sub_sectionController End *********************************************/

                /******************************************** serviceController Start ********************************************/
                /*Route::get(
                    'services/{sub_section_id}',
                    [
                        'uses' => [serviceController::class, 'index'], 'as' => 'services', 'title' => 'المنتجات', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'addpageservice',
                            'addservice',
                            'editpageservice',
                            'updateservice',
                            'changestatusservice',
                            'changeis_favservice',
                            'changebestservice',
                            'deleteservice',
                            'deleteservices',
                        ]
                    ]
                );*/

                #Add service page
                Route::get('add-page-service/{sub_section_id}', ['uses' => [serviceController::class, 'add'], 'as' => 'addpageservice', 'title' => 'صفحة اضافة منتج']);
                #Add service
                Route::post('add-service', ['uses' => [serviceController::class, 'store'], 'as' => 'addservice', 'title' => 'اضافة منتج']);
                #Edit service page
                Route::get('edit-page-service/{id}', ['uses' => [serviceController::class, 'edit'], 'as' => 'editpageservice', 'title' => 'صفحة تعديل منتج']);
                #Update service
                Route::post('update-service', ['uses' => [serviceController::class, 'update'], 'as' => 'updateservice', 'title' => 'تعديل منتج']);
                Route::post('change-service-status', ['uses' => [serviceController::class, 'change_service_status'], 'as' => 'changestatusservice', 'title' => 'حالة ظهور المنتج']);
                Route::post('change-service-is_fav', ['uses' => [serviceController::class, 'change_service_is_fav'], 'as' => 'changeis_favservice', 'title' => 'التحكم في حالة افضل العروض']);
                Route::post('change-service-best', ['uses' => [serviceController::class, 'change_service_best'], 'as' => 'changebestservice', 'title' => 'التحكم في الظهور في جديدنا']);
                #Delete service
                Route::post('delete-service', ['uses' => [serviceController::class, 'delete'], 'as' => 'deleteservice', 'title' => 'حذف منتج']);
                #Delete services
                Route::post('delete-services', ['uses' => [serviceController::class, 'delete_all'], 'as' => 'deleteservices', 'title' => 'حذف اكثر من منتج']);

                /********************************************* serviceController End *********************************************/

                /******************************************** media_fileController Start ********************************************/
                Route::get(
                    'media_files/{type}',
                    [
                        'uses' => [media_fileController::class, 'index'],
                        'as' => 'media_files',
                        'title' => 'بيانات عامة',
                        'icon' => '<i class="nav-icon fas fa-video"></i>',
                        'child' => [
                            'addpagemedia_file',
                            'addmedia_file',
                            'editpagemedia_file',
                            'updatemedia_file',
                            'deletemedia_file',
                            'deletemedia_files',
                        ]
                    ]
                );

                #Add media_file page
                Route::get('add-page-media_file/{type}', ['uses' => [media_fileController::class, 'add'], 'as' => 'addpagemedia_file', 'title' => 'صفحة اضافة عنصر']);
                #Add media_file
                Route::post('add-media_file', ['uses' => [media_fileController::class, 'store'], 'as' => 'addmedia_file', 'title' => 'اضافة عنصر']);
                #Edit media_file page
                Route::get('edit-page-media_file/{id}', ['uses' => [media_fileController::class, 'edit'], 'as' => 'editpagemedia_file', 'title' => 'صفحة تعديل عنصر']);
                #Update media_file
                Route::post('update-media_file', ['uses' => [media_fileController::class, 'update'], 'as' => 'updatemedia_file', 'title' => 'تعديل عنصر']);
                #Delete media_file
                Route::post('delete-media_file', ['uses' => [media_fileController::class, 'delete'], 'as' => 'deletemedia_file', 'title' => 'حذف عنصر']);
                #Delete media_files
                Route::post('delete-media_files', ['uses' => [media_fileController::class, 'delete_all'], 'as' => 'deletemedia_files', 'title' => 'حذف اكثر من عنصر']);

                /********************************************* media_fileController End *********************************************/

                /******************************************** our_locationController Start ********************************************/
                // Route::get(
                //     'our_locations',
                //     [
                //         'uses' => [our_locationController::class, 'index'], 'as' => 'our_locations', 'title' => 'تواجدنا', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                //         'child' => [
                //             'addour_location',
                //             'updateour_location',
                //             //'sendnotifyour_location',
                //             //'changestatusour_location',
                //             'deleteour_location',
                //             'deleteour_locations',
                //         ]
                //     ]
                // );

                #Add our_location
                Route::post('add-our_location', ['uses' => [our_locationController::class, 'store'], 'as' => 'addour_location', 'title' => 'اضافة موقع']);
                #Update our_location
                Route::post('update-our_location', ['uses' => [our_locationController::class, 'update'], 'as' => 'updateour_location', 'title' => 'تعديل موقع']);
                #Send notify
                // Route::post('send-notify-our_location', ['uses' => [our_locationController::class, 'send_notify'], 'as' => 'sendnotifyour_location', 'title' => 'أرسال إشعار']);
                Route::post('change-our_location-status', ['uses' => [our_locationController::class, 'change_our_location_status'], 'as' => 'changestatusour_location', 'title' => 'حالة الموقع']);
                #Delete our_location
                Route::post('delete-our_location', ['uses' => [our_locationController::class, 'delete'], 'as' => 'deleteour_location', 'title' => 'حذف موقع']);
                #Delete our_locations
                Route::post('delete-our_locations', ['uses' => [our_locationController::class, 'delete_all'], 'as' => 'deleteour_locations', 'title' => 'حذف اكثر من موقع']);

                /********************************************* our_locationController End *********************************************/

                /******************************************** shipping_typeController Start ********************************************/
                /*Route::get(
                    'shipping_types',
                    [
                        'uses' => [shipping_typeController::class, 'index'], 'as' => 'shipping_types', 'title' => 'طرق الشحن', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'addshipping_type',
                            'updateshipping_type',
                            //'sendnotifyshipping_type',
                            //'changestatusshipping_type',
                            'deleteshipping_type',
                            'deleteshipping_types',
                        ]
                    ]
                );*/

                #Add shipping_type
                Route::post('add-shipping_type', ['uses' => [shipping_typeController::class, 'store'], 'as' => 'addshipping_type', 'title' => 'اضافة طريقة']);
                #Update shipping_type
                Route::post('update-shipping_type', ['uses' => [shipping_typeController::class, 'update'], 'as' => 'updateshipping_type', 'title' => 'تعديل طريقة']);
                #Send notify
                // Route::post('send-notify-shipping_type', ['uses' => [shipping_typeController::class, 'send_notify'], 'as' => 'sendnotifyshipping_type', 'title' => 'أرسال إشعار']);
                Route::post('change-shipping_type-status', ['uses' => [shipping_typeController::class, 'change_shipping_type_status'], 'as' => 'changestatusshipping_type', 'title' => 'حالة الطريقة']);
                #Delete shipping_type
                Route::post('delete-shipping_type', ['uses' => [shipping_typeController::class, 'delete'], 'as' => 'deleteshipping_type', 'title' => 'حذف طريقة']);
                #Delete shipping_types
                Route::post('delete-shipping_types', ['uses' => [shipping_typeController::class, 'delete_all'], 'as' => 'deleteshipping_types', 'title' => 'حذف اكثر من طريقة']);

                /********************************************* shipping_typeController End *********************************************/

                /********************************************* excelController Start *********************************************/
                /*Route::get('excel_upload', [
                     'uses' => [excelController::class, 'excel_upload'],
                     'as' => 'excel_upload',
                     'title' => 'رفع طلبات جماعية',
                     'icon' => '<i class="fa fa-file"></i>',
                     'child' => [
                         'post_upload_excel_order',
                         //'post_upload_image',
                     ]
                 ]);*/

                Route::post('/post_upload_excel_order', [
                    'uses' => [excelController::class, 'post_upload_excel_order'],
                    'as' => 'post_upload_excel_order',
                    'title' => 'حفظ طلبات جماعية'
                ]);

                Route::post('/post_upload_image', [
                    'uses' => [excelController::class, 'post_upload_image'],
                    'as' => 'post_upload_image',
                    'title' => 'رفع صور'
                ]);
                /********************************************* excelController End *********************************************/

                /******************************************** unitController Start *****************************************/
                // Route::get(
                //     'units',
                //     [
                //         'uses' => [unitController::class, 'index'], 'as' => 'units', 'title' => 'وحدات القياس', 'icon' => '<i class="nav-icon fas fa-dollar-sign"></i>',
                //         'child' => [
                //             'addunit',
                //             'updateunit',
                //             'deleteunit',
                //             'deleteunits',
                //         ]
                //     ]
                // );

                #Add unit
                Route::post('add-unit', ['uses' => [unitController::class, 'store'], 'as' => 'addunit', 'title' => 'اضافة وحدة قياس']);
                #Update unit
                Route::post('update-unit', ['uses' => [unitController::class, 'update'], 'as' => 'updateunit', 'title' => 'تعديل وحدة قياس']);
                #Delete unit
                Route::post('delete-unit', ['uses' => [unitController::class, 'delete'], 'as' => 'deleteunit', 'title' => 'حذف وحدة قياس']);
                #Delete units
                Route::post('delete-units', ['uses' => [unitController::class, 'delete_all'], 'as' => 'deleteunits', 'title' => 'حذف اكثر من وحدة قياس']);

                /********************************************* unitController End *********************************************/

                /******************************************** offerController Start *****************************************/
                // Route::get(
                //     'offers',
                //     [
                //         'uses' => [offerController::class, 'index'], 'as' => 'offers', 'title' => 'العروض', 'icon' => '<i class="nav-icon fas fa-database"></i>',
                //         'child' => [
                //             'addoffer',
                //             'updateoffer',
                //             'deleteoffer',
                //             'deleteoffers',
                //         ]
                //     ]
                // );

                #Add offer
                Route::post('add-offer', ['uses' => [offerController::class, 'store'], 'as' => 'addoffer', 'title' => 'اضافة عرض']);
                #Update offer
                Route::post('update-offer', ['uses' => [offerController::class, 'update'], 'as' => 'updateoffer', 'title' => 'تعديل عرض']);
                #Delete offer
                Route::post('delete-offer', ['uses' => [offerController::class, 'delete'], 'as' => 'deleteoffer', 'title' => 'حذف عرض']);
                #Delete offers
                Route::post('delete-offers', ['uses' => [offerController::class, 'delete_all'], 'as' => 'deleteoffers', 'title' => 'حذف اكثر من عرض']);

                /********************************************* offerController End *********************************************/

                /******************************************** orderController Start ********************************************/
                /*Route::get(
                    'orders/{status}',
                    [
                        'uses' => [orderController::class, 'index'], 'as' => 'orders', 'title' => 'الطلبات',
                        'child' => [
                            'showorder',
                            //'changeorderprovider',
                            //'changeordersprovider',
                            //'changeorder',
                            // 'add_order_report',
                            'updateorder',
                            'changestatusorder',
                            'deleteorder',
                            // 'deleteorders',
                        ]
                    ]
                );*/

                #show order
                Route::get('show-order/{id}', ['uses' => [orderController::class, 'show'], 'as' => 'showorder', 'title' => 'عرض طلب']);
                #Change User Status
                Route::post('change-order-status', ['uses' => [orderController::class, 'change_order_status'], 'as' => 'changestatusorder', 'title' => 'تأكيد رفع الطلب']);
                #change order
                Route::any('change-order', ['uses' => [orderController::class, 'change'], 'as' => 'changeorder', 'title' => 'تغيير حالة الطلب']);
                Route::any('update-order', ['uses' => [orderController::class, 'update'], 'as' => 'updateorder', 'title' => 'تعديل الطلب']);
                Route::post('change-order-provider', ['uses' => [orderController::class, 'change_provider'], 'as' => 'changeorderprovider', 'title' => 'تعيين مندوب']);
                Route::post('change-orders-provider', ['uses' => [orderController::class, 'change_providers'], 'as' => 'changeordersprovider', 'title' => 'تعيين مندوب لاكثر من طلب']);
                Route::post('add_order_report', ['uses' => [orderController::class, 'add_order_report'], 'as' => 'add_order_report', 'title' => 'اضافة تقرير الى الطلب']);
                // #Delete order
                Route::post('delete-order', ['uses' => [orderController::class, 'delete'], 'as' => 'deleteorder', 'title' => 'حذف طلب']);
                // #Delete orders
                // Route::post('delete-orders', ['uses' => [orderController::class, 'delete_all'], 'as' => 'deleteorders', 'title' => 'حذف اكثر من طلب']);

                /*Route::get(
                    'order-report',
                    [
                        'uses' => [orderController::class, 'report'], 'as' => 'order-report', 'title' => 'تقارير الطلبات',
                        'child' => []
                    ]
                );*/

                /********************************************* orderController End *********************************************/

                /******************************************** countryController Start ********************************************/
                /*Route::get(
                    'countrys',
                    [
                        'uses' => [countryController::class, 'index'], 'as' => 'countrys', 'title' => 'الدول', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'addcountry',
                            'updatecountry',
                            'deletecountry',
                            'deletecountrys',
                        ]
                    ]
                );*/

                #Add country
                Route::post('add-country', ['uses' => [countryController::class, 'store'], 'as' => 'addcountry', 'title' => 'اضافة دولة']);
                #Update country
                Route::post('update-country', ['uses' => [countryController::class, 'update'], 'as' => 'updatecountry', 'title' => 'تعديل دولة']);
                #Delete country
                Route::post('delete-country', ['uses' => [countryController::class, 'delete'], 'as' => 'deletecountry', 'title' => 'حذف دولة']);
                #Delete countrys
                Route::post('delete-countrys', ['uses' => [countryController::class, 'delete_all'], 'as' => 'deletecountrys', 'title' => 'حذف اكثر من دولة']);

                /********************************************* countryController End *********************************************/

                /******************************************** cityController Start ********************************************/
                Route::get(
                    'citys',
                    [
                        'uses' => [cityController::class, 'index'],
                        'as' => 'citys',
                        'title' => 'المدن',
                        'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'addcity',
                            'updatecity',
                            //'showcitydelivery',
                            //'updatecitydelivery',
                            'deletecity',
                            'deletecitys',
                        ]
                    ]
                );

                #Add city
                Route::post('add-city', ['uses' => [cityController::class, 'store'], 'as' => 'addcity', 'title' => 'اضافة مدينة']);
                #Update city
                Route::post('update-city', ['uses' => [cityController::class, 'update'], 'as' => 'updatecity', 'title' => 'تعديل مدينة']);
                Route::get('show-city-delivery/{city_id}', ['uses' => [cityController::class, 'show_city_delivery'], 'as' => 'showcitydelivery', 'title' => 'صفحة اسعار التوصيل لباقي المدن']);
                Route::post('update-city-delivery', ['uses' => [cityController::class, 'update_city_delivery'], 'as' => 'updatecitydelivery', 'title' => 'حفظ سعر التوصيل لمدينة']);
                #Delete city
                Route::post('delete-city', ['uses' => [cityController::class, 'delete'], 'as' => 'deletecity', 'title' => 'حذف مدينة']);
                #Delete citys
                Route::post('delete-citys', ['uses' => [cityController::class, 'delete_all'], 'as' => 'deletecitys', 'title' => 'حذف اكثر من مدينة']);

                /********************************************* cityController End *********************************************/

                /******************************************** neighborhoodController Start ********************************************/
                // Route::get(
                //     'neighborhoods',
                //     [
                //         'uses' => [neighborhoodController::class, 'index'], 'as' => 'neighborhoods', 'title' => 'الأحياء', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                //         'child' => [
                //             'addneighborhood',
                //             'updateneighborhood',
                //             'deleteneighborhood',
                //             'deleteneighborhoods',
                //         ]
                //     ]
                // );

                #Add neighborhood
                Route::post('add-neighborhood', ['uses' => [neighborhoodController::class, 'store'], 'as' => 'addneighborhood', 'title' => 'اضافة حي']);
                #Update neighborhood
                Route::post('update-neighborhood', ['uses' => [neighborhoodController::class, 'update'], 'as' => 'updateneighborhood', 'title' => 'تعديل حي']);
                #Delete neighborhood
                Route::post('delete-neighborhood', ['uses' => [neighborhoodController::class, 'delete'], 'as' => 'deleteneighborhood', 'title' => 'حذف حي']);
                #Delete neighborhoods
                Route::post('delete-neighborhoods', ['uses' => [neighborhoodController::class, 'delete_all'], 'as' => 'deleteneighborhoods', 'title' => 'حذف اكثر من حي']);

                /********************************************* neighborhoodController End *********************************************/

                /******************************************** sliderController Start ********************************************/
                Route::get(
                    'sliders/{type}',
                    [
                        'uses' => [sliderController::class, 'index'],
                        'as' => 'sliders',
                        'title' => 'الإعلانات',
                        'icon' => '<i class="nav-icon fas fa-image"></i>',
                        'child' => [
                            'addslider',
                            'updateslider',
                            'deleteslider',
                            'deletesliders',
                        ]
                    ]
                );

                #Add slider
                Route::post('add-slider', ['uses' => [sliderController::class, 'store'], 'as' => 'addslider', 'title' => 'اضافة إعلان']);
                #Update slider
                Route::post('update-slider', ['uses' => [sliderController::class, 'update'], 'as' => 'updateslider', 'title' => 'تعديل إعلان']);
                #Delete slider
                Route::post('delete-slider', ['uses' => [sliderController::class, 'delete'], 'as' => 'deleteslider', 'title' => 'حذف إعلان']);
                #Delete sliders
                Route::post('delete-sliders', ['uses' => [sliderController::class, 'delete_all'], 'as' => 'deletesliders', 'title' => 'حذف اكثر من إعلان']);

                /********************************************* sliderController End *********************************************/

                /******************************************** promo_codeController Start ********************************************/
                /*Route::get(
                    'promo_codes',
                    [
                        'uses' => [promo_codeController::class, 'index'], 'as' => 'promo_codes', 'title' => 'اكواد الخصم', 'icon' => '<i class="nav-icon fas fa-percent"></i>',
                        'child' => [
                            'addpromo_code',
                            'updatepromo_code',
                            'deletepromo_code',
                            'deletepromo_codes',
                        ]
                    ]
                );*/

                #Add promo_code
                Route::post('add-promo_code', ['uses' => [promo_codeController::class, 'store'], 'as' => 'addpromo_code', 'title' => 'اضافة كود']);
                #Update promo_code
                Route::post('update-promo_code', ['uses' => [promo_codeController::class, 'update'], 'as' => 'updatepromo_code', 'title' => 'تعديل كود']);
                #Delete promo_code
                Route::post('delete-promo_code', ['uses' => [promo_codeController::class, 'delete'], 'as' => 'deletepromo_code', 'title' => 'حذف كود']);
                #Delete promo_codes
                Route::post('delete-promo_codes', ['uses' => [promo_codeController::class, 'delete_all'], 'as' => 'deletepromo_codes', 'title' => 'حذف اكثر من كود']);

                /********************************************* promo_codeController End *********************************************/

                /******************************************** bank_accountController Start *****************************************/
                //  Route::get(
                //      'bank_accounts',
                //      [
                //          'uses' => [bank_accountController::class, 'index'], 'as' => 'bank_accounts', 'title' => 'البنوك', 'icon' => '<i class="nav-icon fas fa-dollar-sign"></i>',
                //          'child' => [
                //              'addbank_account',
                //              'updatebank_account',
                //              'deletebank_account',
                //              'deletebank_accounts',
                //          ]
                //      ]
                //  );

                #Add bank_account
                Route::post('add-bank_account', ['uses' => [bank_accountController::class, 'store'], 'as' => 'addbank_account', 'title' => 'اضافة بنك']);
                #Update bank_account
                Route::post('update-bank_account', ['uses' => [bank_accountController::class, 'update'], 'as' => 'updatebank_account', 'title' => 'تعديل بنك']);
                #Delete bank_account
                Route::post('delete-bank_account', ['uses' => [bank_accountController::class, 'delete'], 'as' => 'deletebank_account', 'title' => 'حذف بنك']);
                #Delete bank_accounts
                Route::post('delete-bank_accounts', ['uses' => [bank_accountController::class, 'delete_all'], 'as' => 'deletebank_accounts', 'title' => 'حذف اكثر من بنك']);

                /********************************************* bank_accountController End *********************************************/

                /******************************************** bank_transferController Start ********************************************/
                //  Route::get(
                //      'bank_transfers',
                //      [
                //          'uses' => [bank_transferController::class, 'index'], 'as' => 'bank_transfers', 'title' => 'التحويلات البنكية', 'icon' => '<i class="nav-icon fas fa-dollar-sign"></i>',
                //          'child' => [
                //              'deletebank_transfer',
                //              'deletebank_transfers',
                //          ]
                //      ]
                //  );

                #Delete bank_transfer
                Route::post('delete-bank_transfer', ['uses' => [bank_transferController::class, 'delete'], 'as' => 'deletebank_transfer', 'title' => 'حذف تحويل']);
                #Delete bank_transfers
                Route::post('delete-bank_transfers', ['uses' => [bank_transferController::class, 'delete_all'], 'as' => 'deletebank_transfers', 'title' => 'حذف اكثر من تحويل']);

                /********************************************* bank_transferController End *********************************************/

                /******************************************** contactController Start ********************************************/
                Route::get(
                    'contacts/{type}',
                    [
                        'uses' => [contactController::class, 'index'],
                        'as' => 'contacts',
                        'title' => 'تواصل معنا',
                        'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'deletecontact',
                            'deletecontacts',
                        ]
                    ]
                );

                #Delete contact
                Route::post('delete-contact', ['uses' => [contactController::class, 'delete'], 'as' => 'deletecontact', 'title' => 'حذف رسالة']);
                #Delete contacts
                Route::post('delete-contacts', ['uses' => [contactController::class, 'delete_all'], 'as' => 'deletecontacts', 'title' => 'حذف اكثر من رسالة']);

                /********************************************* contactController End *********************************************/

                /******************************************** adminReportController Start ********************************************/
                /*Route::get(
                    'adminReports',
                    [
                        'uses' => [adminReportController::class, 'index'], 'as' => 'adminReports', 'title' => 'تقارير لوحة التحكم', 'icon' => '<i class="nav-icon fas fa-copy"></i>',
                        'child' => [
                            'deleteadminReport',
                            'deleteadminReports',
                        ]
                    ]
                );*/

                #Delete adminReport
                Route::post('delete-adminReport', ['uses' => [adminReportController::class, 'delete'], 'as' => 'deleteadminReport', 'title' => 'حذف تقرير']);
                #Delete adminReports
                Route::post('delete-adminReports', ['uses' => [adminReportController::class, 'delete_all'], 'as' => 'deleteadminReports', 'title' => 'حذف اكثر من تقرير']);

                /********************************************* adminReportController End *********************************************/
            });
        });
    });
});
