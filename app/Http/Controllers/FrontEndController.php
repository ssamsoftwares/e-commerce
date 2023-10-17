<?php

namespace App\Http\Controllers;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    /**
     * Post listing show.
     */
    public function posts(){
        $posts = Post::latest()->get();
        return view('frontend.posts',["posts"=>$posts]);
    }

      /**
     * Dynamic create pages
     */

     public function createPage($slug)
     {
         // $pages = Page::all();
         $page = Page::whereSlug($slug)->first();
         if (!$page) {
             abort(404);
         } 
         return response()->view('frontend.dynamic-page', compact('page'));
     }
}