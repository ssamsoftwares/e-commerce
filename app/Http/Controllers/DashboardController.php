<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $total['category'] = Category::count();
        $total['subCategory'] = SubCategory::count();
        $total['brand'] = Brand::count();
        $total['product'] = Product::count();
        $total['page'] = Page::count();
        $total['post'] = Post::count();
        return view('dashboard')->with(compact('total'));
    }
}
