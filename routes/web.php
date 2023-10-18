<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});


// Admin Routes
Route::middleware(['auth','role:admin'])->group(function() {

});


Route::middleware(['auth','verified'])->group(function () {

    // dashboard
    Route::get('/dashboard',  DashboardController::class)->name('dashboard');

    // User Profile
    Route::get('/logout', function( Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'update_password'])->name('profile.update_password');


// Pages route
Route::get('page', [PageController::class, 'index'])->name('pages');
Route::get('view-page/{page?}', [PageController::class, 'show'])->name('page.view');
Route::get('add-page', [PageController::class, 'create'])->name('page.add');
Route::post('add-page', [PageController::class, 'store'])->name('page.store');
Route::get('edit-page/{page}',[PageController::class, 'edit'])->name('page.edit');
Route::post('edit-page/{page}',[PageController::class, 'update'])->name('page.update');
Route::get('/delete-page/{page?}',[PageController::class, 'destroy'])->name('page.destroy');


// Post Route
Route::get('post', [PostController::class, 'index'])->name('posts');
Route::get('view-post/{post?}', [PostController::class, 'show'])->name('post.view');
Route::get('add-post', [PostController::class, 'create'])->name('post.add');
Route::post('add-post', [PostController::class, 'store'])->name('post.store');
Route::get('edit-post/{post}',[PostController::class, 'edit'])->name('post.edit');
Route::post('edit-post/{post?}',[PostController::class, 'update'])->name('post.update');
Route::get('/delete-post/{post?}',[PostController::class, 'destroy'])->name('post.destroy');

// Brand Route
Route::get('brand', [BrandController::class, 'index'])->name('brands');
Route::get('add-brand', [BrandController::class, 'create'])->name('brand.add');
Route::post('add-brand', [BrandController::class, 'store'])->name('brand.store');
Route::get('edit-brand/{brand}',[BrandController::class, 'edit'])->name('brand.edit');
Route::post('edit-brand/{brand?}',[BrandController::class, 'update'])->name('brand.update');
Route::get('/delete-brand/{brand?}',[BrandController::class, 'destroy'])->name('brand.destroy');


// Category Route
Route::get('category', [CategoryController::class, 'index'])->name('category');
Route::get('add-category', [CategoryController::class, 'create'])->name('category.add');
Route::post('add-category', [CategoryController::class, 'store'])->name('category.store');
Route::get('edit-category/{category}',[CategoryController::class, 'edit'])->name('category.edit');
Route::post('edit-category/{category?}',[CategoryController::class, 'update'])->name('category.update');
Route::get('/delete-category/{category?}',[CategoryController::class, 'destroy'])->name('category.destroy');


// Sub Category Route
Route::get('sub-category', [SubCategoryController::class, 'index'])->name('subCategory');
Route::get('add-sub-category', [SubCategoryController::class, 'create'])->name('subCategory.add');
Route::post('add-sub-category', [SubCategoryController::class, 'store'])->name('subCategory.store');
Route::get('edit-sub-category/{subcategory}',[SubCategoryController::class, 'edit'])->name('subCategory.edit');
Route::post('edit-sub-category/{subcategory?}',[SubCategoryController::class, 'update'])->name('subCategory.update');
Route::get('/delete-sub-category/{subcategory?}',[SubCategoryController::class, 'destroy'])->name('subCategory.destroy');


// Products Route
Route::get('product', [ProductController::class, 'index'])->name('products');
Route::get('view-product/{product?}', [ProductController::class, 'show'])->name('product.view');

Route::get('add-product', [ProductController::class, 'create'])->name('product.add');
Route::post('add-product', [ProductController::class, 'store'])->name('product.store');
Route::get('edit-product/{product}',[ProductController::class, 'edit'])->name('product.edit');
Route::post('edit-product/{product?}',[ProductController::class, 'update'])->name('product.update');

Route::post('detete-product-img/{product?}',[ProductController::class, 'updateTimeDeleteImg'])->name('product.updateTimeDeleteImg');


Route::get('/delete-product/{product?}',[ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/delete-all-product/{product?}',[ProductController::class, 'deleteAll'])->name('product.deleteAll');

// Get Category
Route::post('/get-subcategory/{product?}',[ProductController::class, 'getSubcategories'])->name('product.getSubcategories');


});

// Create dynaic page
Route::get('dynamic-page/{slug}', [FrontEndController::class, 'createPage'])->name('pages.dynamicPage');
// Route::get('view_posts', [FrontEndController::class, 'posts'])->name('ShowPosts');

require __DIR__.'/auth.php';
