<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//Route::get('/', function () {
//    return view('welcome');
//});


// Trang home của website
Route::get('/', 'ShopController@index');

Route::get('/san-pham.html', 'ShopController@productAll')->name('shop.productAll'); // Tất cả sản phẩm
Route::get('/danh-muc/{slug}','ShopController@category')->name('shop.category');

Route::get('/chi-tiet-san-pham/{slug}', 'ShopController@product')->name('shop.product');
// Get product Attribute Price
Route::get('/get-product-price','ShopController@getProductPrice');



//Route::get('/lien-he', 'ShopController@contact');
Route::post('/gui-lien-he', 'ShopController@postcontact');


#Giỏ hàng
Route::get('/dat-hang', 'CartController@order');
Route::get('/gio-hang.html', 'CartController@show')->name('cart.show');
Route::get('cart/add/{id}','CartController@add')->name('cart.add');
Route::get('cart/remove/{rowId}','CartController@remove')->name('cart.remove');
Route::get('cart/destroy','CartController@destroy')->name('cart.destroy');
//Route::get('cart/add_detail/{id}','CartController@add_detail')->name('cart.add_detail');
Route::get('cart/update/{rowId}','CartController@update')->name('cart.update');

# Thanh toán
Route::get('thanh-toan','CheckoutController@checkout')->name('checkout');
Route::post('/add-customer','CheckoutController@add_customer');
Route::get('/login-checkout','CheckoutController@login_checkout')->name('checkoutLogin');
Route::post('/login-customer','CheckoutController@login_customer');
Route::get('/logout-checkout','CheckoutController@logout_checkout')->name('checkoutLogout');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');
Route::get('/selectAjaxDistrict/{id}','CheckoutController@selectAjaxDistrict');
Route::get('/selectAjaxWard/{id}','CheckoutController@selectAjaxWard');

// Xử lý thanh toán
Route::post('checkout/order','CheckoutController@order')->name('checkout.order');
Route::get('checkout/complete','CheckoutController@orderComplete')->name('checkout.complete');
// Theo dõi đơn hàng
Route::get('checkout/checkorder','CheckoutController@checkorder')->name('checkOrder');


// Danh sách tin tức
Route::get('/tin-tuc','ShopController@articles');
Route::get('/gioi-thieu.html','ShopController@aboutUs');

// Page
Route::get('/{slug}.html','ShopController@page');

// Chi tiết tin tức
Route::get('/chi-tiet-tin-tuc/{slug}','ShopController@detailArticle')->name('shop.detailArticle');



// Đăng Nhập
Route::get('/admin/login', 'AdminController@login')->name('admin.login');
Route::post('/admin/postLogin', 'AdminController@postLogin')->name('admin.postLogin');

// Đăng xuất
Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');
// Tìm kiếm
Route::get('/tim-kiem','ShopController@search')->name('shop.search');



// Login  google and facebook
Route::get('/auth/redirect/{provider}','SocialController@redirect');
Route::get('/auth/{provider}/callback', 'SocialController@callback');



// --------------------   QUẢN TRỊ ----------------------

Route::group(['prefix' => 'admin','as'=>'admin.','middleware' => 'checkLogin'], function () {
    // Trang chủ - quản trị
    Route::get('/', 'AdminController@index');

# Quản lý banner
    Route::get("banner/action","BannerController@action")->name("banner.action");
    Route::get('delete-banner/{id}','BannerController@delete')->name("banner.delete");// Xóa vĩnh viễn
    Route::resource('banner','BannerController');
# Quản lý user
    Route::get("user/action","UserController@action")->name("user.action");
    Route::get('delete-user/{id}','UserController@delete')->name("user.delete");
    Route::resource('user', 'UserController');
# Quản lý Permission
    #Quyền
    Route::get("permission/index","PermissionController@index")->name("permission.index");
    Route::post("permission/index","PermissionController@store");
    Route::get("delete-permission/{id}","PermissionController@delete")->name("permission.delete");
    #nhóm quyền
    Route::get("permission/group","GroupPermissionController@index")->name("groupPermission.index");
    Route::post("permission/group","GroupPermissionController@store");
    Route::get("delete-group-permission/{id}","GroupPermissionController@delete")->name("groupPermission.delete");
# Quản lý Role
    Route::get("role/index","RoleController@index")->name("role.index");
    Route::get("role/create","RoleController@create")->name("role.create");
    Route::post("role/create","RoleController@store")->name("role.store");
    Route::get("role/edit/{id}","RoleController@edit")->name("role.edit");
    Route::post("role/update/{id}","RoleController@update")->name("role.update");
    Route::get("delete-role/{id}","RoleController@delete")->name("role.delete");

# Quản lý product
    Route::get("product/action","ProductController@action")->name("product.action");
    Route::get('delete-product/{id}','ProductController@delete')->name("product.delete");
    Route::resource('product', 'ProductController');
   //  chi tiết hình ảnh sản phẩm
    Route::get('product/image/{id}', 'ProductImageController@index')->name('image.index');
    Route::post('product/image/{id}', 'ProductImageController@create');
    Route::get('product/image/{id}/action', 'ProductImageController@action')->name('image.action');
    Route::get('product/image/delete/{id}', 'ProductImageController@delete')->name('image.delete');
   // Quản lý thuộc tính -attribute
    Route::match(['get','post'],'product/add-attributes/{id}', 'ProductController@createAttributes');
    Route::match(['get','post'],'product/edit-attributes/{id}', 'ProductController@editAttributes');
    Route::get('update-attribute-status','ProductController@updateAttributeStatus');
    Route::get('delete-attribute/{id}','ProductController@deleteAttribute');

    #Quản lý  article
    Route::get("article/action","ArticleController@action")->name("article.action");
    Route::get('delete-article/{id}','ArticleController@delete')->name("article.delete");// Xóa vĩnh viễn
    Route::resource('article','ArticleController');

# Quản lý danh mục
    Route::get("category/action","CategoryController@action")->name("category.action");
    Route::get('delete-category/{id}','CategoryController@delete')->name("category.delete");// Xóa vĩnh viễn
    Route::resource('category','CategoryController');
# Quản lý thương hiệu
    Route::get("brand/action","BrandController@action")->name("brand.action");
    Route::get('delete-brand/{id}','BrandController@delete')->name("brand.delete");// Xóa vĩnh viễn
    Route::resource('brand','BrandController');
# Quản lý liên hệ
    Route::resource('contact','ContactController');
# QUản lý Đặt Hàng
    Route::resource('order','OrderController');
    Route::get('delete-order/{id}','OrderController@delete')->name("order.delete");// Xóa vĩnh viễn


});

