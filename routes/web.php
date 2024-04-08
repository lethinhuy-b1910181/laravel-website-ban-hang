<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CheckOutController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\ProviderController;
use App\Http\Controllers\Backend\ReceiptController;
use App\Http\Controllers\Backend\ReceiptDetailController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShipperController;



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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('home.shop');
Route::post('autocomplete-ajax', [HomeController::class, 'autocomplete_ajax'])->name('home.autocomplete');
Route::get('/produce', [HomeController::class, 'produce'])->name('home.produce');
Route::get('/blog', [HomeController::class, 'blog'])->name('home.blog');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/login-submit', [AdminController::class, 'login_submit'])->name('admin.login-submit');
Route::post('user/login-submit', [UserDashboardController::class, 'login_submit'])->name('user.login-submit');
Route::get('/admin/logout', [AdminController::class,'logout'])->name('admin.logout');
Route::get('/user/logout', [UserDashboardController::class,'logout'])->name('user.logout');

Route::get('shipper/login', [ShipperController::class, 'login'])->name('shipper.login');
Route::post('shipper/login-submit', [ShipperController::class, 'login_submit'])->name('shipper.login-submit');
Route::get('shipper/logout', [ShipperController::class,'logout'])->name('shipper.logout');

/*Product Detail controller*/ 
Route::get('product-detail/{slug}', [FrontEndProductController::class, 'showProduct'])->name('product-detail'); 
/*Product Detail controller*/  

/*Add to Cart controller*/ 
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart'); 
Route::get('cart-details', [CartController::class, 'cartDetails'])->name('cart-details'); 
Route::post('cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity'); 
Route::get('clear-cart', [CartController::class, 'clearCart'])->name('cart.clear-cart'); 
Route::get('cart/remove-product/{id}', [CartController::class, 'removeProduct'])->name('cart.remove-product');
Route::get('cart-count', [CartController::class, 'getCartCount'])->name('cart.cart-count'); 
Route::get('cart-products', [CartController::class, 'getCartProducts'])->name('cart.cart-product'); 
Route::get('product-total', [CartController::class, 'cartTotal'])->name('cart.product-total'); 
Route::get('get-product/{id}', [CartController::class, 'getProduct'])->name('get-product'); 

Route::get('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon'); 


Route::middleware(['web', 'permission:product']) 
->prefix('admin') // 
->name('admin.') 
->group(function () {

        /** Start Category Route */
        Route::put('category-change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
        Route::resource('category', CategoryController::class);
        /** End Category Route */
    
        /** Start Brand Route */
        Route::put('brand-change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
        Route::resource('brand', BrandController::class);
        /** End Brand Route */
    
        /** Start Color Route */
        Route::resource('product-color', ColorController::class);
        /** End Color Route */
    
        /** Start Provider Route */
        Route::resource('provider', ProviderController::class);
        /** End Provider Route */

        /** Profile Route */
        Route::get('profile', [AdminController::class , 'profile'])->name('profile');
        /**End Profile Route */

        Route::put('product-change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
        Route::get('multi-image/delete{id}',[ProductController::class, 'MultiImageDelete'])->name('multi-image.delete');

        Route::resource('product', ProductController::class);
});

Route::middleware(['web', 'permission:receipt']) 
->prefix('admin') // 
->name('admin.') 
->group(function () {
     /** Profile Route */
     Route::get('profile', [AdminController::class , 'profile'])->name('profile');
     /**End Profile Route */
    /** Start Receipt Detail Route */
    Route::delete('receipt-detail-delete-all', [ReceiptDetailController::class, 'deleteAll'])->name('receipt-detail-delete-all');
    Route::resource('receipt-detail', ReceiptDetailController::class);

    /** End Receipt Detail Route */
     /** Start Receipt Route */

     Route::put('receipt-change-status', [ReceiptController::class, 'changeStatus'])->name('receipt.change-status');
     Route::get('get-providers', [ReceiptController::class, 'getProviders'])->name('get-providers');
     Route::get('receipt-view/{receipt}', [ReceiptController::class, 'view'])->name('receipt-view');
     Route::resource('receipt', ReceiptController::class);

 
     /** End Receipt Route */
});
Route::middleware(['web', 'permission:blog']) 
->prefix('admin') // 
->name('admin.') 
->group(function () {
         /** Profile Route */
         Route::get('profile', [AdminController::class , 'profile'])->name('profile');
         /**End Profile Route */

    /** Start Slider Route */
    Route::put('slider-change-status', [SliderController::class, 'changeStatus'])->name('slider.change-status');
    Route::resource('slider', SliderController::class);
    /** End Slider Route */

     /** Start Blog Route */
     /** End Blog Route */
});

Route::middleware(['web', 'permission:order']) 
->prefix('admin') 
->name('admin.') 
->group(function () {
         /** Start Order Detail Route */
    Route::get('order/new-order', [OrderController::class, 'indexNewOrder'])->name('order.new-order');
    Route::get('order/wait-ship', [OrderController::class, 'indexWaitShip'])->name('order.wait-ship');
    Route::get('order/shipping', [OrderController::class, 'indexShipping'])->name('order.shipping');
    Route::get('order/completed', [OrderController::class, 'indexCompleted'])->name('order.completed');
    Route::get('order/canceled', [OrderController::class, 'indexCanceled'])->name('order.canceled');

Route::get('order-count', [OrderController::class, 'getCartCount'])->name('order.order-count'); 


    Route::put('order/change-status/{id}', [OrderController::class, 'changeStatus1'])->name('order.chang-status');
    Route::resource('order', OrderController::class);
    /** End Order Detail Route */

});

Route::middleware(['web',  'superadmin']) 
->prefix('admin') 
->name('admin.') 
->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::put('staff-change-status', [AdminController::class, 'changeStatus'])->name('staff.change-status');
    Route::get('staff-create', [AdminController::class, 'createStaff'])->name('staff.create');
    Route::post('staff-store', [AdminController::class, 'store'])->name('staff.store');
    Route::get('staff-index', [AdminController::class, 'indexStaff'])->name('staff.index');

    Route::put('shipper-change-status', [AdminController::class, 'changeStatusShipper'])->name('shipper.change-status');
    Route::get('shipper-create', [AdminController::class, 'createShipper'])->name('shipper.create');
    Route::post('shipper-store', [AdminController::class, 'storeShipper'])->name('shipper.store');
    Route::get('shipper-index', [AdminController::class, 'indexShipper'])->name('shipper.index');

    Route::post('change-role', [RoleController::class, 'changeRole'])->name('role.change-role');
    Route::get('login-as/{admin}', [AdminController::class, 'loginAs'])->name('loginAs');

    Route::resource('role', RoleController::class); 

    Route::resource('coupon', CouponController::class); 
});



Route::middleware(['web',  'shipper']) 
->prefix('shipper') 
->name('shipper.') 
->group(function () {
    Route::get('new-order', [ShipperController::class, 'newOrder'])->name('new-order');
    Route::put('change-status/{id}', [ShipperController::class, 'changeStatus1'])->name('chang-status');
    Route::put('change-status-2/{id}', [ShipperController::class, 'changeStatus2'])->name('chang-status-2');
    Route::put('shipper-change-status', [ShipperController::class, 'changeStatus'])->name('change-status-3');

    Route::resource('shipper', ShipperController::class); 
});



Route::middleware(['web', 'user']) 
    ->prefix('user') 
    ->name('user.') 
    ->group(function (){
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::put('profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('wishlist/add-product', [WishlistController::class, 'addToWishList'])->name('wishlist.add-to-wishlist');

    Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('wait-confirm', [UserOrderController::class, 'indexWaitConfirm'])->name('orders.wait-confirm');
    Route::get('wait-ship', [UserOrderController::class, 'indexWaitShip'])->name('orders.wait-ship');
    Route::get('shipping', [UserOrderController::class, 'indexShipping'])->name('orders.shipping');
    Route::get('completed', [UserOrderController::class, 'indexCompleted'])->name('orders.completed');
    Route::get('canceled', [UserOrderController::class, 'indexCanceled'])->name('orders.canceled');

    // Route::get('search', [UserOrderController::class, 'search'])->name('order.index');

    Route::get('orders/show/{id}', [UserOrderController::class, 'show'])->name('orders.show');

    Route::get('get-district/{city_id}', [UserAddressController::class, 'getDistrict'])->name('get-district');
    Route::get('get-ward/{district_id}', [UserAddressController::class, 'getWard'])->name('get-ward');

    Route::resource('address',UserAddressController::class);

    Route::get('checkout', [CheckOutController::class, 'index'])->name('checkout');
    Route::post('checkout/address-create', [CheckOutController::class, 'createAddress'])->name('checkout.address.create');
    Route::post('checkout/form-submit', [CheckOutController::class, 'checkOutFormSubmit'])->name('checkout.form-submit');

    Route::get('payment', [PaymentController::class, 'index'])->name('payment');
    Route::post('payment/vn-pay', [PaymentController::class, 'vnPay'])->name('payment.vn-pay');
    Route::post('payment/check-out', [PaymentController::class, 'vnPay'])->name('payment.check-out');

});


// Route::middleware(['web', 'admin']) 
//     ->prefix('admin') // 
//     ->name('admin.') 
//     ->group(function () {
//     Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
//     /** Profile Route */
//     Route::get('profile', [adminController::class , 'profile'])->name('profile');
//     /**End Profile Route */

//     /** Start Slider Route */
//     Route::put('slider-change-status', [SliderController::class, 'changeStatus'])->name('slider.change-status');
//     Route::resource('slider', SliderController::class);
//     /** End Slider Route */

//     /** Start Category Route */
//     Route::put('category-change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
//     Route::resource('category', CategoryController::class);
//     /** End Category Route */

//     /** Start Brand Route */
//     Route::put('brand-change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
//     Route::resource('brand', BrandController::class);
//     /** End Brand Route */
   
//         Route::put('product-change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
//         Route::get('multi-image/delete{id}',[ProductController::class, 'MultiImageDelete'])->name('multi-image.delete');

//         Route::resource('product', ProductController::class);

//         /** End Product Route */
   
    

//     /** Start Color Route */

//     Route::resource('product-color', ColorController::class);

//     /** End Color Route */

//     /** Start Provider Route */

//     Route::resource('provider', ProviderController::class);

//     /** End Provider Route */

//     /** Start Receipt Route */

//     Route::put('receipt-change-status', [ReceiptController::class, 'changeStatus'])->name('receipt.change-status');
//     Route::get('get-providers', [ReceiptController::class, 'getProviders'])->name('get-providers');
//     Route::get('receipt-view/{receipt}', [ReceiptController::class, 'view'])->name('receipt-view');
//     Route::resource('receipt', ReceiptController::class);

//     /** End Receipt Route */
//     /** Start Receipt Detail Route */
//     Route::delete('receipt-detail-delete-all', [ReceiptDetailController::class, 'deleteAll'])->name('receipt-detail-delete-all');
//     Route::resource('receipt-detail', ReceiptDetailController::class);

//     /** End Receipt Detail Route */


//     /** Start Order Detail Route */
//     Route::put('order/change-status/{id}', [OrderController::class, 'changeStatus1'])->name('order.chang-status');
//     Route::resource('order', OrderController::class);

// /** End Receipt Detail Route */
// });