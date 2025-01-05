<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CmsPageModel;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'Published')->orderBy('id', 'desc')->paginate(12);
        $menus = CmsPageModel::where('active', true)->orderBy('order_by', 'asc')->get();
        return view('frontend.blog.index', compact('posts','menus'));
    }

    public function detail($slug)
    {
        $posts = Post::where('status', 'Published')->orderBy('id', 'desc')->paginate(5);
        $post = Post::where('status', 'Published')->where('slug', $slug)->firstOrFail();
        $menus = CmsPageModel::where('active', true)->orderBy('order_by', 'asc')->get();
        return view('frontend.blog.detail', compact('post', 'posts','menus'));
    }
}
