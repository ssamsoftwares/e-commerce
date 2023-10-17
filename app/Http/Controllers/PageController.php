<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = Page::paginate(10)->withQueryString();
        return view('admin.pages.all', compact('pages'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.add');
    }

      /**
     *  View the form for creating a new resource.
     */

     public function show(Page $page){
        return view('admin.pages.view')->with(compact('page'));
     }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255','unique:'.Page::class],
            // 'slug' =>  ['string', 'slug', 'max:255', 'unique:'.Page::class],
            'body' => ['required', 'string',],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('pages', 'public'); // 'pages' is the directory name
            } else {
                $imagePath = null; // No image uploaded, set the path to null
            }

            $page = Page::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'image' => $request->$imagePath,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Pages Created Successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit')->with(compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('pages')->ignore($page->id),],
            'body' => ['required', 'string',],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        DB::beginTransaction();
        try {

            $page->update([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'body' => $request->body,
                'status' => $request->input('status', false) ? 'active' : 'inactive',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', $page->title . 'Page Updated Successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        DB::beginTransaction();
        try {
            $page->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'Page Not Deleted!');
        }
        DB::commit();
        return redirect()->back()->with('status', 'Page deleted successfully!');
    }


  
}
