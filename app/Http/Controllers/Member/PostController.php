<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('member.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $category = Category::orderByDesc('id')->get();
        return view('member.post.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:10240'
        ],[
            'title.required' => 'Title wajib diisi',
            'description.required' => 'Description wajib diisi',
            'content.required' => 'Content wajib diisi',
            'category_id.required' => 'Category wajib diisi',
            'thumbnail.image' => 'Thumbnail wajib diisi',
        ]);

        if ($request->hasFile('thumbnail')){
            
            $image = $request->file('thumbnail');
            $image_name = time() . "_" . $image->getClientOriginalName();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
