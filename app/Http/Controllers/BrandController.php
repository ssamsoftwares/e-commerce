<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.withQueryString
     */
    public function index(Request $request, Brand $brands)
    {
        $query = Brand::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($subquery) use ($search) {
                $subquery->where('brand', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }
        $brands = $query->paginate(10);

        return view('admin.brand.all', compact('brands'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function Store(Request $request, Brand $brand)
    {
        $request->validate([
            'brand' => 'required|max:255|unique:brands,brand',
            // 'slug'=> 'required|max:255|unique:brands,slug',
            'image' => 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048',
        ]);
        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $imageName = time() . rand(0000, 9999) . '.' . $request->image->extension();
                $request->image->move(public_path('brand_images'), $imageName);
            }

            $brand->create([
                'brand' => ucfirst($request->brand),
                'slug' => Str::slug($request->brand),
                'image' => isset($imageName) ? 'brand_images/' . $imageName : null,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', "Brand Created Successfully!");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit')->with(compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'brand' => ['required',  'max:255', Rule::unique('brands', 'brand')->ignore($brand->id),],
            'slug' => ['required', 'max:255', Rule::unique('brands', 'slug')->ignore($brand->id)],
            'image' => 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048',
        ]);
        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $imageName = time() . rand(0000, 9999) . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('brand_images'), $imageName);

                // Delete old image if  exists.
                if (!empty($brand->image)) {
                    unlink(public_path() . '/' . $brand->image);
                }

                // Update the new Category.
                $brand->update([
                    'brand' => ucfirst($request->brand),
                    'slug' => Str::slug($request->slug),
                    'image' => 'brand_images/' . $imageName,
                    'status' => $request->status,
                ]);
            } else {
                // If no new image is uploaded.
                $result =     $brand->update([
                    'brand' => ucfirst($request->brand),
                    'slug' => Str::slug($request->slug),
                    'status' => $request->status,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Brand Update Successfully !');
    }

    /**
     * Show the form for View the specified resource.
     */
    public function view(Brand $brand)
    {
        return view('admin.brand.view')->with(compact('brand'));
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Brand $brand)
    {
        try {
            DB::beginTransaction();
            $brand->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Brand Delete Successfully !');
    }
}
