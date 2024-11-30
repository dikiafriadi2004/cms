<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'Published')->orderBy('id', 'desc')->paginate(12);
        return view('frontend.blog.index', compact('posts'));
    }

    public function detail($slug)
    {
        $posts = Post::where('status', 'Published')->orderBy('id', 'desc')->paginate(5);
        $post = Post::where('status', 'Published')->where('slug', $slug)->firstOrFail();
        return view('frontend.blog.detail', compact('post', 'posts'));
    }
}
