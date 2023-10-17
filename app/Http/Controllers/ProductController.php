<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.product.all')->with(compact('products'));
    }


    /**
     * View the form for creating a new resource.
     */

    public function show(Product $product)
    {
        $product = Product::with('category', 'subCategory', 'brand')
            ->find($product->id);

        // echo "<pre>";
        // print_r($product->toArray());
        // die;
        return view('admin.product.view')->with(compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::where('status', 'active')->get();
        $subcategories = SubCategory::where('status', 'active')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('admin.product.add')->with(compact('categories', 'subcategories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function Store(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_name' => 'required|max:255|unique:products,product_name,' . $product->id,
            // 'slug' => 'required|max:255|unique:products,slug,' . $product->id,
            'sku' => 'required',
            'price' => 'required|integer',
            'offer_price' => 'required|integer',
            'quantity' => 'required|integer',
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            dd($errors);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $imagePaths = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $imageName = time() . rand(0000, 9999) . '.' . $file->extension();
                    $file->move(public_path('product_images'), $imageName);
                    $imagePaths[] = 'product_images/' . $imageName;
                }
            }
            $product = Product::create([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'brand_id' => $request->brand_id,
                'product_name' => $request->product_name,
                'slug' => Str::slug($request->product_name),
                'sku' => $request->sku,
                'price' => $request->price,
                'offer_price' => $request->offer_price,
                'quantity' => $request->quantity,
                'short_description' => $request->short_description ? $request->short_description : null,
                'description' => $request->description ? $request->description : null,
                'image' => !empty($imagePaths) ? json_encode($imagePaths) : null,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Product Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        $subcategories = SubCategory::where('status', 'active')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('admin.product.edit')->with(compact('product', 'categories', 'subcategories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => ['required|exists:categories,id'],
            'subcategory_id' => ['required|exists:sub_categories,id'],
            'brand_id' => ['required|exists:brands,id'],
            'product_name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'sku' => ['required'],
            'price' => ['required|integer'],
            'offer_price' => ['required|integer'],
            'quantity' => ['required|integer'],
            'short_description' => ['required'],
            'description' => ['required'],
            'image' => ['nullable|array'],
            'image.*' => ['image|mimes:jpeg,png,jpg,gif|max:2048'],
        ];

        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails()) {
        //     $errors = $validator->errors()->all();
        //     dd($errors);
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        DB::beginTransaction();
        try {

            $product = Product::find($request->id);

            if($reqImg = $request->file('image')){
                $destination = "/product_images/";
                $oldImages = json_decode($product->image);

                foreach($reqImg as $img){

                    $rand = Str::random(5);
                    $imgName = $rand.'-'.time().'-'. $img->getClientOriginalName();
                    $img->move(public_path().$destination,$imgName);
                    $imageData[]= '/product_images/'.$imgName;
                }
                $allimgs = array_merge($oldImages,$imageData);
                // $product->image = json_encode($allimgs);
                $product->update([
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'brand_id' => $request->brand_id,
                    'product_name' => $request->product_name,
                    'slug' => $request->slug,
                    'sku' => $request->sku,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'status' => $request->product_status,
                    'image' => json_encode($allimgs),
                ]);

            }else{
                $product->update([
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'brand_id' => $request->brand_id,
                    'product_name' => $request->product_name,
                    'slug' => $request->slug,
                    'sku' => $request->sku,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'status' => $request->product_status,
                ]);

            }

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Product Updated Successfully!');
    }

    /**
     * Update  time delete images
     */

    public function updateTimeDeleteImg(Request $request)
    {
        $deleteIMG = Product::find($request->id);
        if ($reqImg = $request->imagename) {
            // $destination = "/Images/";
            $oldImages = json_decode($deleteIMG->image, true);
            // Delete Image on folder
            if (!empty($oldImages)) {
                foreach ($oldImages as $oldImage) {
                    if (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    }
                }
            }
            // Delete Image on folder End

            if (($key = array_search($reqImg, $oldImages)) !== false) {
                unset($oldImages[$key]);
            }
            $newArr = array_values($oldImages);
            $deleteIMG->image = json_encode($newArr);
            $deleteIMG->update();
            return response()->json(["msg" => 'success']);
        }
    }

    /**
     * Show the form for View the specified resource.
     */
    public function view(Product $product)
    {
        return view('admin.product.view')->with('product');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', 'Product Deleted!');
    }


    /**
     * Remove the all selected resource from storage.
     */

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->ids;
            // DB::enableQueryLog();
            Product::whereIn('id', $ids)->delete();
            // $queries = DB::getQueryLog();
            DB::commit();
            // return response()->json(['success' => "Products Deleted successfully.", 'queries' => $queries]);
            return response()->json(['success' => "Products Deleted successfully."]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Get subcategory product add form
     */
    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        $subcategories = SubCategory::where('category_id', $categoryId)->pluck('sub_category', 'id');
        return response()->json($subcategories);
    }
}
