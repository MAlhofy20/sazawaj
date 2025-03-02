<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\site\mainController;
use App\Http\Controllers\admin\cityController;
use App\Http\Controllers\admin\pageController;
use App\Http\Controllers\admin\rateController;
use App\Http\Controllers\admin\unitController;
use App\Http\Controllers\admin\userController;
use App\Http\Controllers\site\orderController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\excelController;
use App\Http\Controllers\admin\offerController;
use App\Http\Controllers\admin\salerController;
use App\Http\Controllers\site\marketController;
use App\Http\Controllers\admin\sliderController;
use App\Http\Controllers\admin\contactController;
use App\Http\Controllers\admin\countryController;
use App\Http\Controllers\admin\packageController;
use App\Http\Controllers\admin\paymentController;
use App\Http\Controllers\admin\sectionController;
use App\Http\Controllers\admin\serviceController;
use App\Http\Controllers\admin\settingController;
use App\Http\Controllers\admin\providerController;
use App\Http\Controllers\admin\user_noteController;
use App\Http\Controllers\admin\media_fileController;
use App\Http\Controllers\admin\permissionController;
use App\Http\Controllers\admin\promo_codeController;
use App\Http\Controllers\admin\StatisticsController;
use App\Http\Controllers\admin\adminReportController;
use App\Http\Controllers\admin\sub_sectionController;
use App\Http\Controllers\admin\bank_accountController;
use App\Http\Controllers\admin\neighborhoodController;
use App\Http\Controllers\admin\our_locationController;
use App\Http\Controllers\admin\bank_transferController;
use App\Http\Controllers\admin\shipping_typeController;
use App\Http\Controllers\admin\CommonQuestionController;
use App\Http\Controllers\admin\mainController as adminMainController;
use App\Http\Controllers\admin\orderController as adminOrderController;

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
        Route::get('site-post-test', [mainController::class, 'post_test'])->name('site_active');
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
        Route::post('site_notificationsRead', [mainController::class, 'notificationsMarkAsRead'])->name('site_notificationsRead');
        Route::get('notificationsCount', [mainController::class, 'notificationsCount'])->name('notificationsCount');
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
        Route::any('show_client/{id}', [mainController::class, 'show_client'])->name('site_show_client');

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
           // Route::any('show_client/{id}', [mainController::class, 'show_client'])->name('site_show_client');
            Route::any('all_packages', [mainController::class, 'all_packages'])->name('site_all_packages');
            Route::any('subscripe_package/{id}', [mainController::class, 'subscripe_package'])->name('site_subscripe_package');
            Route::any('all_rooms', [mainController::class, 'all_rooms'])->name('site_all_rooms');
            Route::any('show_chat/{id}', [mainController::class, 'show_chat'])->name('site_show_chat');
            Route::any('show_room/{id}', [mainController::class, 'show_room'])->name('site_show_room');
            Route::any('delete_room', [mainController::class, 'delete_rooms'])->name('delete_rooms');
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
    #Send reminder emails manually
    // Route::get('/send-activation-reminders', function () {
    //     Artisan::call('send:activation-reminders');
    //     return 'Reminder emails sent!';
    // });
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
            Route::get('adminAllNotifications', [adminMainController::class, 'adminAllNotifications'])->name('adminAllNotifications');
            Route::post('admin_notificationsRead',[adminMainController::class, 'markAllNotificationsRead'])->name('admin_notificationsRead');

            Route::middleware('hasPermission')->group(function () {
                /******************************************** settingController Start ********************************************/
                Route::get('settings', [settingController::class, 'index'])->name('settings')
                ->defaults('title', 'الإعدادات')
                ->defaults('child', ['updatesetting', 'updateintro','updateseo']);

                Route::post('update-setting', [settingController::class, 'update'])->name('updatesetting') ->defaults('title', 'تحديث الإعدادات') ;
                Route::post('update-intro', [settingController::class, 'intro'])->name('updateintro') ->defaults('title', 'اكواد جوجل') ;
                Route::post('update-social', [settingController::class, 'social'])->name('updatesocial') ->defaults('title', 'تحديث مواقع التواصل') ;
                Route::post('update-location', [settingController::class, 'location'])->name('updatelocation') ->defaults('title', 'تحديث الخريطة') ;
                Route::post('update-seo', [settingController::class, 'seo'])->name('updateseo') ->defaults('title', 'تحديث محركات البحث') ;

                /********************************************* settingController End *********************************************/

                /******************************************** permissionController Start ********************************************/
                Route::get('permissions', [permissionController::class, 'index'])
                ->name('permissions') ->defaults('title', 'الصلاحيات') ->defaults('child', ['addpagepermission', 'addpermission', 'editpagepermission', 'updatepermission', 'deletepermission']);
                #Add permission page
                Route::get('add-page-permission', [permissionController::class, 'add'])->name('addpagepermission') ->defaults('title', 'صفحة اضافة صلاحية') ;
                #Add permission
                Route::post('add-permission', [permissionController::class, 'store'])
                ->name('addpermission')  ->defaults('title', 'اضافة صلاحية') ;
                #Edit permission page
                Route::get('edit-page-permission/{role_id}', [permissionController::class, 'edit'])
                ->name('editpagepermission') ->defaults('title', 'صفحة تعديل صلاحية') ;
                #Update permission
                Route::post('update-permission', [permissionController::class, 'update'])
                ->name('updatepermission') ->defaults('title', 'تعديل صلاحية') ;
                #Delete permission
                Route::post('delete-permission', [permissionController::class, 'delete'])
                ->name('deletepermission') ->defaults('title', 'حذف صلاحية') ;

                /********************************************* permissionController End *********************************************/

                /******************************************** adminController Start ********************************************/
                Route::get('admins', [adminController::class, 'index'])->name('admins') ->defaults('title', 'المديرين') ->defaults('child', ['addadmin', 'updateadmin', 'deleteadmin', 'deleteadmins']);

                #Add admin
                Route::post('add-admin', [adminController::class, 'store'])->name('addadmin') ->defaults('title', 'اضافة مدير') ;

                #Update admin
                Route::post('update-admin', [adminController::class, 'update'])->name('updateadmin') ->defaults('title', 'تعديل مدير') ;

                #Delete admin
                Route::post('delete-admin', [adminController::class, 'delete'])->name('deleteadmin') ->defaults('title', 'حذف مدير') ;

                #Delete admins
                Route::post('delete-admins', [adminController::class, 'delete_all'])->name('deleteadmins') ->defaults('title', 'حذف اكثر من مدير') ;

                /********************************************* adminController End *********************************************/

                /******************************************** userController Start ********************************************/
                Route::get('users', [userController::class, 'index'])->name('users')
                ->defaults('title', 'الأعضاء')
                ->defaults('child', [
                    'adduser',
                    'updateuser',
                    'updatepackageuser',
                    //'sendnotifyuser,
                    'deleteuser',
                    'deleteusers',
                    'changestatususer',
                    'avataruserseen',
                    // 'changesee_familyuser,
                    // 'checkout_wallet,
                    // 'userorders,
                    // 'userpaid
                    'user.review',
                    'user.accept',
                    'user.reject',
                ]);

                #Add User
                Route::post('add-user', [userController::class, 'store'])->name('adduser') ->defaults('title', 'اضافة عضو') ;
                #Update User
                Route::post('update-user', [userController::class, 'update'])->name('updateuser') ->defaults('title', 'تعديل عضو') ;
                Route::post('updatepackage-user', [userController::class, 'update_package'])->name('updatepackageuser') ->defaults('title', 'تعديل باقة عضو') ;
                #Send notify
                Route::post('send-notify-user', [userController::class, 'send_notify'])->name('sendnotifyuser') ->defaults('title', 'أرسال إشعار') ;
                #Change User Status
                Route::post('change-user-status', [userController::class, 'change_user_status'])->name('changestatususer') ->defaults('title', 'بتغير حالة عضو') ;
                Route::post('avatar-user-seen', [userController::class, 'avatar_user_seen'])->name('avataruserseen') ->defaults('title', 'تأكيد الصورة الشخصية') ;
                Route::post('change-user-see_family', [userController::class, 'change_user_see_family'])->name('changesee_familyuser') ->defaults('title', 'بتغير حالة ظهور السوق الخيري') ;
                #Delete User
                Route::post('delete-user', [userController::class, 'delete'])->name('deleteuser') ->defaults('title', 'حذف عضو') ;
                #Delete Users
                Route::post('delete-users', [userController::class, 'delete_all'])->name('deleteusers') ->defaults('title', 'حذف اكثر من عضو') ;
                #checkout wallet
                Route::get('user-orders/{id}', [userController::class, 'orders'])->name('userorders') ->defaults('title', 'عرض حسابات عضو') ;
                Route::post('user-paid', [userController::class, 'paid'])->name('userpaid') ->defaults('title', 'تسوية حساب عضو') ;
                Route::post('checkout_wallet', [userController::class, 'checkout_wallet'])->name('checkout_wallet') ->defaults('title', 'تسوية حساب عضو') ;
                Route::get('/user/review/{id}', [UserController::class, 'review'])->name('user.review')->defaults('title', 'مراجعة صورة عضو') ;
                Route::post('/user/accept/{id}', [UserController::class, 'accept'])->name('user.accept')->defaults('title', 'قبول صورة عضو') ;
                Route::post('/user/reject/{id}', [UserController::class, 'reject'])->name('user.reject')->defaults('title', 'رفض صورة عضو') ;
                /********************************************* userController End *********************************************/

                /******************************************** packageController Start *****************************************/
                Route::get('packages', [packageController::class, 'index'])->name('packages') ->defaults('title', 'الباقات') ->defaults('child', ['addpackage', 'editpackage', 'updatepackage', 'deletepackage', 'deletepackages']);

                #Add package
                Route::post('add-package', [packageController::class, 'store'])->name('addpackage') ->defaults('title', 'اضافة باقة') ;
                #Edit package page
                Route::get('edit-package/{id}', [packageController::class, 'edit'])->name('editpackage') ->defaults('title', 'صفحة تعديل باقة') ;
                #Update package
                Route::post('update-package', [packageController::class, 'update'])->name('updatepackage') ->defaults('title', 'تعديل باقة') ;
                #Delete package
                Route::post('delete-package', [packageController::class, 'delete'])->name('deletepackage') ->defaults('title', 'حذف باقة') ;
                #Delete package
                Route::post('delete-packages', [packageController::class, 'delete_all'])->name('deletepackages') ->defaults('title', 'حذف اكثر من باقة') ;
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
                Route::post('add-provider', [providerController::class, 'store'])->name('addprovider') ->defaults('title', 'اضافة عنصر') ;
                #Update Provider
                Route::post('update-provider', [providerController::class, 'update'])->name('updateprovider') ->defaults('title', 'تعديل عنصر') ;
                #Send notify
                Route::post('send-notify-provider', [providerController::class, 'send_notify'])->name('sendnotifyprovider') ->defaults('title', 'أرسال إشعار') ;
                #Change Provider Status
                Route::post('change-provider-status', [providerController::class, 'change_provider_status'])->name('changestatusprovider') ->defaults('title', 'بتغير حالة عنصر') ;
                Route::post('confirm-provider', [providerController::class, 'confirm_provider'])->name('confirmprovider') ->defaults('title', 'تفعيل حساب عنصر') ;
                Route::post('change-provider-fav', [providerController::class, 'change_provider_fav'])->name('changefavprovider') ->defaults('title', 'بتميز عنصر') ;
                #Delete Provider
                Route::post('delete-provider', [providerController::class, 'delete'])->name('deleteprovider') ->defaults('title', 'حذف عنصر') ;
                #Delete Providers
                Route::post('delete-providers', [providerController::class, 'delete_all'])->name('deleteproviders') ->defaults('title', 'حذف اكثر من عنصر') ;
                #provider orders
                Route::get('provider-orders/{id}', [providerController::class, 'orders'])->name('providerorders') ->defaults('title', 'عرض حسابات عنصر') ;
                Route::post('provider-paid', [providerController::class, 'paid'])->name('providerpaid') ->defaults('title', 'تسوية حساب عنصر') ;
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
                Route::post('add-user_note', [user_noteController::class, 'store'])->name('adduser_note') ->defaults('title', 'اضافة عنصر') ;
                #Update user_note
                Route::post('update-user_note', [user_noteController::class, 'update'])->name('updateuser_note') ->defaults('title', 'تعديل عنصر') ;
                #Delete user_note
                Route::post('delete-user_note', [user_noteController::class, 'delete'])->name('deleteuser_note') ->defaults('title', 'حذف عنصر') ;
                #Delete user_notes
                Route::post('delete-user_notes', [user_noteController::class, 'delete_all'])->name('deleteuser_notes') ->defaults('title', 'حذف اكثر من عنصر') ;
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

                // Route::get('new-market', [marketController::class, 'new'])->name('newmarket') ->defaults('title', 'اضافة عنصر') ;
                #Add market
                Route::post('add-market', [marketController::class, 'store'])->name('addmarket') ->defaults('title', 'اضافة عنصر') ;
                // Route::get('edit-market/{id}', [marketController::class, 'edit'])->name('editmarket') ->defaults('title', 'صفحة تعديل عنصر') ;
                #Update market
                Route::post('update-market', [marketController::class, 'update'])->name('updatemarket') ->defaults('title', 'تعديل عنصر') ;
                #Send notify
                Route::post('send-notify-market', [marketController::class, 'send_notify'])->name('sendnotifymarket') ->defaults('title', 'أرسال إشعار') ;
                #Change market Status
                Route::post('change-market-active', [marketController::class, 'change_market_active'])->name('changeactivemarket') ->defaults('title', 'بتفعيل جوال عنصر') ;
                Route::post('change-market-status', [marketController::class, 'change_market_status'])->name('changestatusmarket') ->defaults('title', 'بتغير حالة عنصر') ;
                Route::post('change-market-fav', [marketController::class, 'change_market_fav'])->name('changefavmarket') ->defaults('title', 'بتميز عنصر') ;
                Route::post('changecan_ordermarket', [marketController::class, 'changecan_ordermarket'])->name('changecan_ordermarket') ->defaults('title', 'بامكانية الطلب من عنصر') ;
                Route::post('confirm-market', [marketController::class, 'confirm_market'])->name('confirmmarket') ->defaults('title', 'تفعيل عنصر') ;
                #Delete market
                Route::post('delete-market', [marketController::class, 'delete'])->name('deletemarket') ->defaults('title', 'حذف عنصر') ;
                #Delete markets
                Route::post('delete-markets', [marketController::class, 'delete_all'])->name('deletemarkets') ->defaults('title', 'حذف اكثر من عنصر') ;
                #market orders
                Route::get('market-orders/{id}', [marketController::class, 'orders'])->name('marketorders') ->defaults('title', 'عرض حسابات عنصر') ;
                Route::post('market-paid', [marketController::class, 'paid'])->name('marketpaid') ->defaults('title', 'تسوية حساب عنصر') ;

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
                // Route::get('new-saler', [salerController::class, 'new'])->name('newsaler') ->defaults('title', 'اضافة عنصر') ;
                Route::post('add-saler', [salerController::class, 'store'])->name('addsaler') ->defaults('title', 'اضافة عنصر') ;
                #Update saler
                // Route::get('edit-saler/{id}', [salerController::class, 'edit'])->name('editsaler') ->defaults('title', 'صفحة تعديل عنصر') ;
                Route::post('update-saler', [salerController::class, 'update'])->name('updatesaler') ->defaults('title', 'تعديل عنصر') ;
                #Send notify
                Route::post('send-notify-saler', [salerController::class, 'send_notify'])->name('sendnotifysaler') ->defaults('title', 'أرسال إشعار') ;
                #Change saler Status
                Route::post('change-saler-active', [salerController::class, 'change_saler_active'])->name('changeactivesaler') ->defaults('title', 'بتفعيل جوال عنصر') ;
                Route::post('change-saler-status', [salerController::class, 'change_saler_status'])->name('changestatussaler') ->defaults('title', 'بتغير حالة عنصر') ;
                Route::post('change-saler-fav', [salerController::class, 'change_saler_fav'])->name('changefavsaler') ->defaults('title', 'بتميز عنصر') ;
                Route::post('changecan_ordersaler', [salerController::class, 'changecan_ordersaler'])->name('changecan_ordersaler') ->defaults('title', 'بامكانية الطلب من عنصر') ;
                Route::post('confirm-saler', [salerController::class, 'confirm_saler'])->name('confirmsaler') ->defaults('title', 'تفعيل عنصر') ;
                #Delete saler
                Route::post('delete-saler', [salerController::class, 'delete'])->name('deletesaler') ->defaults('title', 'حذف عنصر') ;
                #Delete salers
                Route::post('delete-salers', [salerController::class, 'delete_all'])->name('deletesalers') ->defaults('title', 'حذف اكثر من عنصر') ;
                #saler orders
                Route::get('saler-orders/{id}', [salerController::class, 'orders'])->name('salerorders') ->defaults('title', 'عرض حسابات عنصر') ;
                Route::post('saler-paid', [salerController::class, 'paid'])->name('salerpaid') ->defaults('title', 'تسوية حساب عنصر') ;

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
                Route::post('seen-rate', [rateController::class, 'seen_rate'])->name('seenrate') ->defaults('title', 'تغيير حالة تقييم') ;
                #Delete Provider
                Route::post('delete-rate', [rateController::class, 'delete'])->name('deleterate') ->defaults('title', 'حذف تقييم') ;
                #Delete Providers
                Route::post('delete-rates', [rateController::class, 'delete_all'])->name('deleterates') ->defaults('title', 'حذف اكثر من تقييم') ;

                /********************************************* rateController End *********************************************/

                /******************************************** pageController Start ********************************************/
                Route::get('pages',[pageController::class, 'index'])->name('pages')
                ->defaults('title', 'الصفحات الاساسية')
                ->defaults('child', [
                    //'addpage,
                    'editpagepage',
                    'updatepage',
                    //'deletepage,
                    //'deletepages
                ]);

                #Add page
                Route::post('add-page', [pageController::class, 'store'])->name('addpage') ->defaults('title', 'اضافة صفحة') ;
                #Edit page page
                Route::get('edit-page-page/{id}', [pageController::class, 'edit'])->name('editpagepage') ->defaults('title', 'صفحة تعديل موضوع') ;
                #Update page
                Route::post('update-page', [pageController::class, 'update'])->name('updatepage') ->defaults('title', 'تعديل صفحة') ;
                #Delete page
                Route::post('delete-page', [pageController::class, 'delete'])->name('deletepage') ->defaults('title', 'حذف صفحة') ;
                #Delete pages
                Route::post('delete-pages', [pageController::class, 'delete_all'])->name('deletepages') ->defaults('title', 'حذف اكثر من صفحة') ;

                /********************************************* pageController End *********************************************/

                /******************************************** CommonQuestionController Start ********************************************/
               Route::POST('common_questions', [\App\Http\Controllers\admin\CommonQuestionController::class, 'store'])->name('addcommon_question');
                Route::get('common_questions',[CommonQuestionController::class, 'index'])->name('common_questions')
                ->defaults('title', 'الاسئلة المتداولة')
                ->defaults('child', [
                    //'addpagecommon_question,
                   // 'addcommon_question',
                    //'editpagecommon_question,
                    'updatecommon_question',
                    'deletecommon_question',
                    'deletecommon_questions'
                ]);

                #Add common_question page
                Route::get('add-page-common_question', [CommonQuestionController::class, 'add'])->name('addpagecommon_question') ->defaults('title', 'صفحة اضافة عنصر') ;
                #Add common_question
               // Route::post('add-common_question', [CommonQuestionController::class, 'store'])->name('addcommon_question') ->defaults('title', 'اضافة عنصر') ;
                #Edit common_question page
                Route::get('edit-page-common_question/{id}', [CommonQuestionController::class, 'edit'])->name('editpagecommon_question') ->defaults('title', 'صفحة تعديل عنصر') ;
                #Update common_question
                Route::post('update-common_question', [CommonQuestionController::class, 'update'])->name('updatecommon_question') ->defaults('title', 'تعديل عنصر') ;
                #Delete common_question
                Route::post('delete-common_question', [CommonQuestionController::class, 'delete'])->name('deletecommon_question') ->defaults('title', 'حذف عنصر') ;
                #Delete common_questions
                Route::post('delete-common_questions', [CommonQuestionController::class, 'delete_all'])->name('deletecommon_questions') ->defaults('title', 'حذف اكثر من عنصر') ;

                /********************************************* CommonQuestionController End *********************************************/

                /******************************************** sectionController Start ********************************************/
                Route::get('sections',[sectionController::class, 'index'])->name('sections')
                ->defaults('title', 'اقسام المدونة')
                ->defaults('child', [
                    'addsection',
                    'updatesection',
                    //'sendnotifysection,
                    //'changestatussection,
                    'deletesection',
                    'deletesections'
                ]);

                #Add section
                Route::post('add-section', [sectionController::class, 'store'])->name('addsection') ->defaults('title', 'اضافة قسم') ;
                #Update section
                Route::post('update-section', [sectionController::class, 'update'])->name('updatesection') ->defaults('title', 'تعديل قسم') ;
                #Send notify
                // Route::post('send-notify-section', [sectionController::class, 'send_notify'])->name('sendnotifysection') ->defaults('title', 'أرسال إشعار') ;
                Route::post('change-section-status', [sectionController::class, 'change_section_status'])->name('changestatussection') ->defaults('title', 'حالة القسم') ;
                #Delete section
                Route::post('delete-section', [sectionController::class, 'delete'])->name('deletesection') ->defaults('title', 'حذف قسم') ;
                #Delete sections
                Route::post('delete-sections', [sectionController::class, 'delete_all'])->name('deletesections') ->defaults('title', 'حذف اكثر من قسم') ;

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
                Route::post('add-sub_section', [sub_sectionController::class, 'store'])->name('addsub_section') ->defaults('title', 'اضافة قسم') ;
                #Update sub_section
                Route::post('update-sub_section', [sub_sectionController::class, 'update'])->name('updatesub_section') ->defaults('title', 'تعديل قسم') ;
                #Delete sub_section
                Route::post('delete-sub_section', [sub_sectionController::class, 'delete'])->name('deletesub_section') ->defaults('title', 'حذف قسم') ;
                #Delete sub_sections
                Route::post('delete-sub_sections', [sub_sectionController::class, 'delete_all'])->name('deletesub_sections') ->defaults('title', 'حذف اكثر من قسم') ;

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
                Route::get('add-page-service/{sub_section_id}', [serviceController::class, 'add'])->name('addpageservice') ->defaults('title', 'صفحة اضافة منتج') ;
                #Add service
                Route::post('add-service', [serviceController::class, 'store'])->name('addservice') ->defaults('title', 'اضافة منتج') ;
                #Edit service page
                Route::get('edit-page-service/{id}', [serviceController::class, 'edit'])->name('editpageservice') ->defaults('title', 'صفحة تعديل منتج') ;
                #Update service
                Route::post('update-service', [serviceController::class, 'update'])->name('updateservice') ->defaults('title', 'تعديل منتج') ;
                Route::post('change-service-status', [serviceController::class, 'change_service_status'])->name('changestatusservice') ->defaults('title', 'حالة ظهور المنتج') ;
                Route::post('change-service-is_fav', [serviceController::class, 'change_service_is_fav'])->name('changeis_favservice') ->defaults('title', 'التحكم في حالة افضل العروض') ;
                Route::post('change-service-best', [serviceController::class, 'change_service_best'])->name('changebestservice') ->defaults('title', 'التحكم في الظهور في جديدنا') ;
                #Delete service
                Route::post('delete-service', [serviceController::class, 'delete'])->name('deleteservice') ->defaults('title', 'حذف منتج') ;
                #Delete services
                Route::post('delete-services', [serviceController::class, 'delete_all'])->name('deleteservices') ->defaults('title', 'حذف اكثر من منتج') ;

                /********************************************* serviceController End *********************************************/

                /******************************************** media_fileController Start ********************************************/
                Route::get('media_files/{type}',[media_fileController::class, 'index'])->name('media_files') ->defaults('title', 'بيانات عامة') ->defaults('child', ['addpagemedia_file', 'addmedia_file', 'editpagemedia_file', 'updatemedia_file', 'deletemedia_file', 'deletemedia_files']);

                #Add media_file page
                Route::get('add-page-media_file/{type}', [media_fileController::class, 'add'])->name('addpagemedia_file') ->defaults('title', 'صفحة اضافة عنصر') ;
                #Add media_file
                Route::post('add-media_file', [media_fileController::class, 'store'])->name('addmedia_file') ->defaults('title', 'اضافة عنصر') ;
                #Edit media_file page
                Route::get('edit-page-media_file/{id}', [media_fileController::class, 'edit'])->name('editpagemedia_file') ->defaults('title', 'صفحة تعديل عنصر') ;
                #Update media_file
                Route::post('update-media_file', [media_fileController::class, 'update'])->name('updatemedia_file') ->defaults('title', 'تعديل عنصر') ;
                #Delete media_file
                Route::post('delete-media_file', [media_fileController::class, 'delete'])->name('deletemedia_file') ->defaults('title', 'حذف عنصر') ;
                #Delete media_files
                Route::post('delete-media_files', [media_fileController::class, 'delete_all'])->name('deletemedia_files') ->defaults('title', 'حذف اكثر من عنصر') ;

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
                Route::post('add-our_location', [our_locationController::class, 'store'])->name('addour_location') ->defaults('title', 'اضافة موقع') ;
                #Update our_location
                Route::post('update-our_location', [our_locationController::class, 'update'])->name('updateour_location') ->defaults('title', 'تعديل موقع') ;
                #Send notify
                // Route::post('send-notify-our_location', [our_locationController::class, 'send_notify'])->name('sendnotifyour_location') ->defaults('title', 'أرسال إشعار') ;
                Route::post('change-our_location-status', [our_locationController::class, 'change_our_location_status'])->name('changestatusour_location') ->defaults('title', 'حالة الموقع') ;
                #Delete our_location
                Route::post('delete-our_location', [our_locationController::class, 'delete'])->name('deleteour_location') ->defaults('title', 'حذف موقع') ;
                #Delete our_locations
                Route::post('delete-our_locations', [our_locationController::class, 'delete_all'])->name('deleteour_locations') ->defaults('title', 'حذف اكثر من موقع') ;

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
                Route::post('add-shipping_type', [shipping_typeController::class, 'store'])->name('addshipping_type') ->defaults('title', 'اضافة طريقة') ;
                #Update shipping_type
                Route::post('update-shipping_type', [shipping_typeController::class, 'update'])->name('updateshipping_type') ->defaults('title', 'تعديل طريقة') ;
                #Send notify
                // Route::post('send-notify-shipping_type', [shipping_typeController::class, 'send_notify'])->name('sendnotifyshipping_type') ->defaults('title', 'أرسال إشعار') ;
                Route::post('change-shipping_type-status', [shipping_typeController::class, 'change_shipping_type_status'])->name('changestatusshipping_type') ->defaults('title', 'حالة الطريقة') ;
                #Delete shipping_type
                Route::post('delete-shipping_type', [shipping_typeController::class, 'delete'])->name('deleteshipping_type') ->defaults('title', 'حذف طريقة') ;
                #Delete shipping_types
                Route::post('delete-shipping_types', [shipping_typeController::class, 'delete_all'])->name('deleteshipping_types') ->defaults('title', 'حذف اكثر من طريقة') ;

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

                Route::post('/post_upload_excel_order',[excelController::class, 'post_upload_excel_order'])->name('post_upload_excel_order') ->defaults('title', 'حفظ طلبات جماعية') ;

                Route::post('/post_upload_image', [excelController::class, 'post_upload_image'])->name('post_upload_image') ->defaults('title', 'رفع صور') ;
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
                Route::post('add-unit', [unitController::class, 'store'])->name('addunit') ->defaults('title', 'اضافة وحدة قياس') ;
                #Update unit
                Route::post('update-unit', [unitController::class, 'update'])->name('updateunit') ->defaults('title', 'تعديل وحدة قياس') ;
                #Delete unit
                Route::post('delete-unit', [unitController::class, 'delete'])->name('deleteunit') ->defaults('title', 'حذف وحدة قياس') ;
                #Delete units
                Route::post('delete-units', [unitController::class, 'delete_all'])->name('deleteunits') ->defaults('title', 'حذف اكثر من وحدة قياس') ;

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
                Route::post('add-offer', [offerController::class, 'store'])->name('addoffer') ->defaults('title', 'اضافة عرض') ;
                #Update offer
                Route::post('update-offer', [offerController::class, 'update'])->name('updateoffer') ->defaults('title', 'تعديل عرض') ;
                #Delete offer
                Route::post('delete-offer', [offerController::class, 'delete'])->name('deleteoffer') ->defaults('title', 'حذف عرض') ;
                #Delete offers
                Route::post('delete-offers', [offerController::class, 'delete_all'])->name('deleteoffers') ->defaults('title', 'حذف اكثر من عرض') ;

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
                Route::get('show-order/{id}', [orderController::class, 'show'])->name('showorder') ->defaults('title', 'عرض طلب') ;
                #Change User Status
                Route::post('change-order-status', [orderController::class, 'change_order_status'])->name('changestatusorder') ->defaults('title', 'تأكيد رفع الطلب') ;
                #change order
                Route::any('change-order', ['uses' => [orderController::class, 'change'], 'as' => 'changeorder', 'title' => 'تغيير حالة الطلب']);
                Route::any('update-order', ['uses' => [orderController::class, 'update'], 'as' => 'updateorder', 'title' => 'تعديل الطلب']);
                Route::post('change-order-provider', [orderController::class, 'change_provider'])->name('changeorderprovider') ->defaults('title', 'تعيين مندوب') ;
                Route::post('change-orders-provider', [orderController::class, 'change_providers'])->name('changeordersprovider') ->defaults('title', 'تعيين مندوب لاكثر من طلب') ;
                Route::post('add_order_report', [orderController::class, 'add_order_report'])->name('add_order_report') ->defaults('title', 'اضافة تقرير الى الطلب') ;
                // #Delete order
                Route::post('delete-order', [orderController::class, 'delete'])->name('deleteorder') ->defaults('title', 'حذف طلب') ;
                // #Delete orders
                // Route::post('delete-orders', [orderController::class, 'delete_all'])->name('deleteorders') ->defaults('title', 'حذف اكثر من طلب') ;

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
                Route::post('add-country', [countryController::class, 'store'])->name('addcountry') ->defaults('title', 'اضافة دولة') ;
                #Update country
                Route::post('update-country', [countryController::class, 'update'])->name('updatecountry') ->defaults('title', 'تعديل دولة') ;
                #Delete country
                Route::post('delete-country', [countryController::class, 'delete'])->name('deletecountry') ->defaults('title', 'حذف دولة') ;
                #Delete countrys
                Route::post('delete-countrys', [countryController::class, 'delete_all'])->name('deletecountrys') ->defaults('title', 'حذف اكثر من دولة') ;

                /********************************************* countryController End *********************************************/

                /******************************************** cityController Start ********************************************/
                Route::get('citys',[cityController::class, 'index'])->name('citys')
                ->defaults('title', 'المدن')
                ->defaults('child', [
                    'addcity',
                    'updatecity',
                    //'showcitydelivery,
                    //'updatecitydelivery,
                    'deletecity',
                    'deletecitys'
                ]);

                #Add city
                Route::post('add-city', [cityController::class, 'store'])->name('addcity') ->defaults('title', 'اضافة مدينة') ;
                #Update city
                Route::post('update-city', [cityController::class, 'update'])->name('updatecity') ->defaults('title', 'تعديل مدينة') ;
                Route::get('show-city-delivery/{city_id}', [cityController::class, 'show_city_delivery'])->name('showcitydelivery') ->defaults('title', 'صفحة اسعار التوصيل لباقي المدن') ;
                Route::post('update-city-delivery', [cityController::class, 'update_city_delivery'])->name('updatecitydelivery') ->defaults('title', 'حفظ سعر التوصيل لمدينة') ;
                #Delete city
                Route::post('delete-city', [cityController::class, 'delete'])->name('deletecity') ->defaults('title', 'حذف مدينة') ;
                #Delete citys
                Route::post('delete-citys', [cityController::class, 'delete_all'])->name('deletecitys') ->defaults('title', 'حذف اكثر من مدينة') ;

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
                Route::post('add-neighborhood', [neighborhoodController::class, 'store'])->name('addneighborhood') ->defaults('title', 'اضافة حي') ;
                #Update neighborhood
                Route::post('update-neighborhood', [neighborhoodController::class, 'update'])->name('updateneighborhood') ->defaults('title', 'تعديل حي') ;
                #Delete neighborhood
                Route::post('delete-neighborhood', [neighborhoodController::class, 'delete'])->name('deleteneighborhood') ->defaults('title', 'حذف حي') ;
                #Delete neighborhoods
                Route::post('delete-neighborhoods', [neighborhoodController::class, 'delete_all'])->name('deleteneighborhoods') ->defaults('title', 'حذف اكثر من حي') ;

                /********************************************* neighborhoodController End *********************************************/

                /******************************************** sliderController Start ********************************************/
                Route::get('sliders/{type}',[sliderController::class, 'index'])->name('sliders') ->defaults('title', 'الإعلانات') ->defaults('child', ['addslider', 'updateslider', 'deleteslider', 'deletesliders']);

                #Add slider
                Route::post('add-slider', [sliderController::class, 'store'])->name('addslider') ->defaults('title', 'اضافة إعلان') ;
                #Update slider
                Route::post('update-slider', [sliderController::class, 'update'])->name('updateslider') ->defaults('title', 'تعديل إعلان') ;
                #Delete slider
                Route::post('delete-slider', [sliderController::class, 'delete'])->name('deleteslider') ->defaults('title', 'حذف إعلان') ;
                #Delete sliders
                Route::post('delete-sliders', [sliderController::class, 'delete_all'])->name('deletesliders') ->defaults('title', 'حذف اكثر من إعلان') ;

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
                Route::post('add-promo_code', [promo_codeController::class, 'store'])->name('addpromo_code') ->defaults('title', 'اضافة كود') ;
                #Update promo_code
                Route::post('update-promo_code', [promo_codeController::class, 'update'])->name('updatepromo_code') ->defaults('title', 'تعديل كود') ;
                #Delete promo_code
                Route::post('delete-promo_code', [promo_codeController::class, 'delete'])->name('deletepromo_code') ->defaults('title', 'حذف كود') ;
                #Delete promo_codes
                Route::post('delete-promo_codes', [promo_codeController::class, 'delete_all'])->name('deletepromo_codes') ->defaults('title', 'حذف اكثر من كود') ;

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
                Route::post('add-bank_account', [bank_accountController::class, 'store'])->name('addbank_account') ->defaults('title', 'اضافة بنك') ;
                #Update bank_account
                Route::post('update-bank_account', [bank_accountController::class, 'update'])->name('updatebank_account') ->defaults('title', 'تعديل بنك') ;
                #Delete bank_account
                Route::post('delete-bank_account', [bank_accountController::class, 'delete'])->name('deletebank_account') ->defaults('title', 'حذف بنك') ;
                #Delete bank_accounts
                Route::post('delete-bank_accounts', [bank_accountController::class, 'delete_all'])->name('deletebank_accounts') ->defaults('title', 'حذف اكثر من بنك') ;

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
                Route::post('delete-bank_transfer', [bank_transferController::class, 'delete'])->name('deletebank_transfer') ->defaults('title', 'حذف تحويل') ;
                #Delete bank_transfers
                Route::post('delete-bank_transfers', [bank_transferController::class, 'delete_all'])->name('deletebank_transfers') ->defaults('title', 'حذف اكثر من تحويل') ;

                /********************************************* bank_transferController End *********************************************/

                /******************************************** contactController Start ********************************************/
                Route::get('contacts/{type}',[contactController::class, 'index'])->name('contacts') ->defaults('title', 'تواصل معنا') ->defaults('child', ['deletecontact', 'deletecontacts']);

                #Delete contact
                Route::post('delete-contact', [contactController::class, 'delete'])->name('deletecontact') ->defaults('title', 'حذف رسالة') ;
                #Delete contacts
                Route::post('delete-contacts', [contactController::class, 'delete_all'])->name('deletecontacts') ->defaults('title', 'حذف اكثر من رسالة') ;

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
                Route::post('delete-adminReport', [adminReportController::class, 'delete'])->name('deleteadminReport') ->defaults('title', 'حذف تقرير') ;
                #Delete adminReports
                Route::post('delete-adminReports', [adminReportController::class, 'delete_all'])->name('deleteadminReports') ->defaults('title', 'حذف اكثر من تقرير') ;

                /********************************************* adminReportController End *********************************************/
            });
        });
    });
});
Route::any('artisana/{command}', function($command){
    Artisan::call($command);
    dd(Artisan::output());

})->name('artisan');
