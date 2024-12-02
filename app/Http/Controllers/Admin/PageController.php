<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->search;
        $pages = Page::where('user_id', $user->id)->where(function($query) use ($search){
            if($search){
                $query->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%");
            }
        })->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('backend.admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ],[
            'title.required' => 'Title a field is required',
            'content.required' => 'Content a field is required',
        ]);

        $page = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'slug' => Str::slug($request->title),
            'user_id' => Auth::user()->id,
        ];

        Page::create($page);

        return redirect()->route('pages.index')->with('success', 'Page has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('backend.admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ],[
            'title.required' => 'Title a field is required',
            'content.required' => 'Content a field is required',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'slug' => Str::slug($request->title),
            'user_id' => Auth::user()->id
        ];

        Page::where('id', $page->id)->update($data);

        return redirect()->route('pages.index')->with('success', 'Page has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        Post::where('id', $page->id)->delete();
        return redirect()->route('pages.index')->with('success', 'Page has been deleted');
    }
}
