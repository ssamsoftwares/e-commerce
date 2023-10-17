<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $subCategories = SubCategory::paginate(10);
        return view('admin.subCategory.all')->with(compact('subCategories'));
    }

   /**
    * Show the form for creating a new resource.
    */
    public function create(Request $request)
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.subcategory.add', compact('categories'));
    }
    
    
   /**
    * Store a newly created resource in storage.
    */

    public function Store(Request $request){
            $request->validate([
                'category_id' => 'required', 
                'sub_category' => 'required|max:255|unique:sub_categories,sub_category',
            ]);
     
        // dd($request->all());

        DB::beginTransaction();
        try{
            SubCategory::create([
                'category_id' => $request->category_id, 
                'sub_category' => $request->sub_category,
                'slug' => $request->sub_category,
            ]);

        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('status',$e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status','SubCategory Created Successfully!');
    }

      /**
    * Show the form for editing the specified resource.
    */
    public function edit(SubCategory $subcategory){

        $categories = Category::where('status', 'active')->get();
        return view('admin.subcategory.edit')->with(compact('subcategory','categories'));
    }
    
   /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, SubCategory $subcategory ){
       
        $request->validate([
            'sub_category' => ['required', 'max:255', Rule::unique('sub_categories', 'sub_category')->ignore($request->id), ],
             'slug' => ['required', 'max:255', Rule::unique('sub_categories', 'slug')->ignore($request->id)],
        ]);

        DB::beginTransaction();
        try{

            // $subcategory = SubCategory::find($request->id);
            $subcategory->update([
                'sub_category'=>$request->sub_category,
                'category_id'=>$request->category_id,
                'slug'=>$request->slug,
                'status'=>$request->sub_cat_status,
            ]);

        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('status',$e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status','SubCategory update succssfully!');
    }

     /**
    * Remove the specified resource from storage.
    */
    public function destroy(SubCategory $subcategory){
        DB::beginTransaction();
        try{
            $subcategory->delete();
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('status',$e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status','SubCategory Deleted !');
    }
}