<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
     public function index()
     {  $posts = Post::paginate(10);
        return view('admin.post.all')->with(compact('posts'));
     }
     
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.post.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            //'slug' =>  ['required', 'string', 'slug', 'max:255', 'unique:'.Post::class],
            'description' => ['required', 'string',],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
            $imageName = time() . rand(0000, 9999) . '.' . $request->image->extension();
            $request->image->move(public_path('post_images'), $imageName);
            }

            $post = Post::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'image' =>  $request->image?'post_images/' . $imageName:Null,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('status', $e->getMessage());
        }

        DB::commit();
        return redirect()->back()->with('status', 'Post Created Successfully!');
    }

     /**
     *  View the form for creating a new resource.
     */

     public function show(Post $post){
        return view('admin.post.view')->with(compact('post'));
     }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit')->with(compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id),],
            'description' => 'required|string',
            'status' => 'required',
            'image' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        DB::beginTransaction();

                 try {
                    if ($request->hasFile('image')) {
                        $imageName = time() . rand(0000, 9999) . '.' . $request->image->getClientOriginalExtension();
                        $request->image->move(public_path('post_images'), $imageName);

                        // Delete old image if  exists.
                        if (!empty($post->image)) {
                            unlink(public_path() . '/' . $post->image);
                        }

                        // Update the new post.
                        $post->update([
                            'title' => $request->title,
                            'slug' => Str::slug($request->slug),
                            'image' => 'post_images/' . $imageName,
                            'description' => $request->description,
                            'status' => $request->status,
                        ]);
                    } else {
                        // If no new image is uploaded.
                        $post->update([
                            'title' => $request->title,
                            'slug' => Str::slug($request->slug),
                            'description' => $request->description,
                            'status' => $request->status,
                        ]);
                    }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('status', $post->title . 'post Updated Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'Post Not Deleted!');
        }
        DB::commit();
        return redirect()->back()->with('status', 'Post deleted successfully!');
    }
}
