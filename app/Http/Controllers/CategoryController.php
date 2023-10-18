<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request, Category $category)
     {
         $query = Category::query();
         if ($request->has('search')) {
             $search = $request->input('search');
             $query->where(function ($subquery) use ($search) {
                 $subquery->where('category', 'like', '%' . $search . '%')
                     ->orWhere('slug', 'like', '%' . $search . '%')
                     ->orWhere('status', 'like', '%' . $search . '%');
             });
         }
         $category = $query->paginate(10);

         return view('admin.category.all', compact('category'));
     }
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
       return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request, Category $category)
    {
       $request->validate([
          'category' => 'required|max:255|unique:categories,category',
          // 'slug'=>'required|max:255|unique:categories,slug',
          'image' => 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048',
       ]);
       DB::beginTransaction();
       try {

          if ($request->hasFile('image')) {
             $imageName = time() . rand(0000, 9999) . '.' . $request->image->extension();
             $request->image->move(public_path('category_images'), $imageName);
          }
          $category->create([
             'category' => ucfirst($request->category),
             'slug' => Str::slug($request->category),
             'image' =>  $request->image ? 'category_images/' . $imageName : Null,
          ]);
       } catch (Exception $e) {
          DB::rollBack();
          return redirect()->back()->with('status', $e->getMessage());
       }
       DB::commit();
       return redirect()->back()->with('status', 'Category Create successfully Done!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
       return view('admin.category.edit')->with(compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
       $request->validate([
          'category' => ['required',  'max:255', Rule::unique('categories', 'category')->ignore($request->id),
            ],
          'slug' => ['required','max:255',Rule::unique('categories','slug')->ignore($request->id)],
          'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
          ]);

       DB::beginTransaction();
       try {
          if ($request->hasFile('image')) {
             $imageName = time() . rand(0000, 9999) . '.' . $request->image->getClientOriginalExtension();
             $request->image->move(public_path('category_images'), $imageName);
             // Delete old image if  exists.
             if (!empty($category->image)) {
                unlink(public_path() . '/' . $category->image);
             }

             // Update the new Category.
             $category->update([
                'category' => ucfirst($request->category),
                'slug' => Str::slug($request->slug),
                'image' => 'category_images/' . $imageName,
                'status' => $request->status,
             ]);
          } else {
             // If no new image is uploaded.
             $category->update([
                'category' => ucfirst($request->category),
                'slug' => Str::slug($request->slug),
                'status' => $request->status,
             ]);
          }
       } catch (Exception $e) {
          DB::rollBack();
          return redirect()->back()->with('status', $e->getMessage());
       }
       DB::commit();
       return redirect()->back()->with('status', "Category Update succefully done!");
    }

    /**
     * Show the form for View the specified resource.
     */

    public function view(Category $category)
    {
       return view('admin.category.view')->with(compact('category'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
       DB::beginTransaction();
       try {
          $category->delete();
       } catch (Exception $e) {
          DB::rollBack();
          return redirect()->back()->with('status', $e->getMessage());
       }
       DB::commit();
       return redirect()->back()->with('status', "Category Deleted Successfully Done!");
    }
 }
