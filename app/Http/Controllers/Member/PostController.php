<?php

namespace App\Http\Controllers\Member;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        return view('member.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $categories = Category::orderByDesc('id')->get();
        return view('member.post.create', compact('categories'));
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
            'thumbnail.image' => 'Thumbnail hanya gambar',
            'thumbnail.mimes' => "Ekstensi hanya JPEG, JPG, dan PNG",
            'thumbnail.max' => 'Ukuran maksimum untuk thumbnail adalah 10Mb',
        ]);

        if ($request->hasFile('thumbnail')){
            $image = $request->file('thumbnail');
            $image_name = time() . "_" . $image->getClientOriginalName();
            $destination_path = public_path(getenv('CUSTOM_THUMBNAIL_LOCATION'));
            $image->move($destination_path, $image_name);
        }

        $category = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'thumbnail' => isset($image_name) ? $image_name : null,
            'slug' => Str::slug($request->title),
            'user_id' => Auth::user()->id
        ];

        Post::create($category);

        return redirect()->route('post.index')->with('success', 'Post has been created');
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
