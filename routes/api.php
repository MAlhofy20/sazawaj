<?php
//header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//header("Content-Type: form-data; charset=UTF-8");
//header('Access-Control-Max-Age: 1000');

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\api\paymentController;
use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\apiController;
use App\Http\Controllers\api\orderController;

/*
|--------------------------------------------------------------------------
| API start
|--------------------------------------------------------------------------
| By : AbdelRahman - at : 11/2020
*/

Route::middleware('api_lang')->group(function () {

    /********* my_fatoorah [adminOrderController::class ,'print_order'] *********/
    Route::any('my_fatoorah_methods', [paymentController::class,'my_fatoorah_methods'])->name('my_fatoorah_methods');
    Route::any('my_fatoorah', [paymentController::class,'my_fatoorah'])->name('my_fatoorah');
    Route::any('my_fatoorah_success', [paymentController::class,'my_fatoorah_success'])->name('my_fatoorah_success');
    Route::any('my_fatoorah_faild', [paymentController::class,'my_fatoorah_faild'])->name('my_fatoorah_faild');

    /*
    | AuthController start
    */

    #sign up
    Route::any('register', [authController::class,'register']);
    #sign in
    Route::any('login', [authController::class,'login']);
    #logout
    Route::any('logout', [authController::class,'logout']);
    #destroy
    Route::any('destroy-user', [authController::class,'destroy_user']);
    #forgetPassword
    Route::any('forget-password', [authController::class,'forgetPassword']);
    #resetPassword
    Route::any('reset-password', [authController::class,'resetPassword']);
    #active account
    Route::any('active-account', [authController::class,'activeAccount']);
    #resend active code
    Route::any('resend-code', [authController::class,'resendCode']);
    #update user
    Route::any('update-user', [authController::class,'updateUser']);
    #show user
    Route::any('show-user', [authController::class,'showUser']);

    /*
    | apiController start
    */

    #Genrate PDF
    Route::get('report-pdf/{id}', [apiController::class,'report_pdf'])->name('report_pdf');
    #upload image
    Route::any('upload-image', [apiController::class,'uploadImage']);
    #home
    Route::any('home', [apiController::class,'home']);
    Route::any('client_home', [apiController::class,'client_home']);
    #sections
    Route::any('app-data', [apiController::class,'app_data']);
    Route::any('branches', [apiController::class,'branches']);
    Route::any('cities', [apiController::class,'cities']);
    Route::any('neighborhoods', [apiController::class,'neighborhoods']);
    Route::any('sub_sections', [apiController::class,'sub_sections']);
    Route::any('rate-provider',    [apiController::class,'rate_provider']);
    Route::any('providers', [apiController::class,'providers']);
    Route::any('show-provider', [apiController::class,'show_provider']);
    Route::any('exercises', [apiController::class,'exercises']);
    Route::any('show-exercise', [apiController::class,'show_exercise']);
    #services
    Route::any('sliders', [apiController::class,'sliders']);
    Route::any('sections', [apiController::class,'sections']);
    Route::any('services_with_sections', [apiController::class,'services_with_sections']);
    Route::any('services', [apiController::class,'services']);
    Route::any('show-service', [apiController::class,'show_service']);
    Route::any('show-favourites', [apiController::class,'show_favourites']);
    Route::any('add-to-favourite', [apiController::class,'add_to_favourite']);
    #offers
    Route::any('offers', [apiController::class,'offers']);
    Route::any('show-offer', [apiController::class,'show_offer']);
    #articals
    Route::any('articals', [apiController::class,'articals']);
    Route::any('show-artical', [apiController::class,'show_artical']);
    #chats
    Route::any('all-rooms',   [apiController::class,'all_rooms']);
    Route::any('all-chats',   [apiController::class,'all_chats']);
    Route::any('store-chat',  [apiController::class,'store_chat']);
    Route::any('delete-room', [apiController::class,'delete_room']);
    Route::any('delete-chat', [apiController::class,'delete_chat']);
    #provider services
    Route::any('all-provider-services', [apiController::class,'all_provider_services']);
    Route::any('store-service',         [apiController::class,'store_service']);
    Route::any('update-service',        [apiController::class,'update_service']);
    Route::any('delete-service',        [apiController::class,'delete_service']);
    Route::any('delete-service-image',  [apiController::class,'delete_service_image']);
    #intro
    Route::any('intro', [apiController::class,'intro']);
    #page
    Route::any('page', [apiController::class,'page']);
    #contact us
    Route::any('contact-us', [apiController::class,'contactUs']);
    #notification
    //show
    Route::any('show-notification', [apiController::class,'showNotification']);
    //delete
    Route::any('delete-notification', [apiController::class,'deleteNotification']);
    #bank
    //account
    Route::any('bank-account', [apiController::class,'bankAccount']);
    //transfer
    Route::any('bank-transfer', [apiController::class,'bankTransfer']);
    #addresses
    Route::any('all-addresses',   [apiController::class,'all_addresses']);
    Route::any('show-address',    [apiController::class,'show_address']);
    Route::any('store-address',   [apiController::class,'store_address']);
    Route::any('update-address',  [apiController::class,'update_address']);
    Route::any('delete-address',  [apiController::class,'delete_address']);

    /*
    | orderController start
    */

    #show Cart
    Route::any('show-cart', [orderController::class,'show_cart']);
    #add Cart
    Route::any('show-times', [orderController::class,'show_times']);
    Route::any('check-price', [orderController::class,'check_price']);
    Route::any('check-order-total',     [orderController::class,'check_order_total']);
    Route::any('add-to-cart', [orderController::class,'add_to_cart']);
    #update & Delete All Cart
    Route::any('update-to-cart', [orderController::class,'update_to_cart']);
    #check promo
    Route::any('check-promo', [orderController::class,'checkPromo']);
    #store order
    Route::any('store-order', [orderController::class,'storeOrder']);
    Route::any('store-order-market', [orderController::class,'storeOrderMarket']);
    #show all orders
    Route::any('show-all-orders', [orderController::class,'showAllOrders']);
    Route::any('search-all-orders', [orderController::class,'searchAllOrders']);
    Route::any('show-all-provider-orders', [orderController::class,'showAllProviderOrders']);
    #show order
    Route::any('show-order', [orderController::class,'showOrder']);
    #change order status
    Route::any('change-order-status', [orderController::class,'change_order_status']);
    #update location
    Route::any('update-location', [orderController::class,'update_location']);
    #get address
    Route::any('get-address', [orderController::class,'get_address']);

    #######api token
    #check promo
    Route::any('api-check-order-total', [orderController::class,'api_check_order_total']);
    Route::any('api-check-promo', [orderController::class,'api_checkPromo']);
    #store order
    Route::any('api-store-order', [orderController::class,'api_storeOrder']);
    #show all orders
    Route::any('api-show-all-orders', [orderController::class,'api_showAllOrders']);
    #show order
    Route::any('api-show-order', [orderController::class,'api_showOrder']);

});
