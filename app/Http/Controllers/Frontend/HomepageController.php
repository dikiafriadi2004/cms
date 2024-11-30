<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'Published')->orderBy('id', 'desc')->paginate(3);
        return view('frontend.home.index', compact('posts'));
    }
}
