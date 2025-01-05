<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use App\Models\CmsPageModel;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index($slug = null, $subSlug = null)
    {
        if (is_null($slug)) {
            $page = CmsPageModel::where('slug', '/')->firstOrFail();
        } elseif (is_null($subSlug)) {
            $page = CmsPageModel::where('slug', '/' . $slug)->firstOrFail();
        } else {
            $page = CmsPageModel::where('slug', '/' . $slug . '/' . $subSlug)->firstOrFail();
        }

        $posts = Post::where('status', 'Published')->orderBy('id', 'desc')->paginate(3);
        $menus = CmsPageModel::where('active', true)->orderBy('order_by', 'asc')->get();
        $data = [
            'posts' => $posts,
        ];

        return view('frontend.home.index', compact('menus','page', 'data'));
    }
}
