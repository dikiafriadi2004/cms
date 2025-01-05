<?php

namespace App\Http\Controllers;

use App\Models\CmsPageModel;
use Illuminate\Http\Request;

class CmsPageController extends Controller
{
    public function index(){
        $cmsPages = CmsPageModel::paginate(10);
        return view('backend.admin.cms.index', compact('cmsPages'));
    }

    public function create(){
        return view('backend.admin.cms.create');
    }

    public function store(Request $request)
    {
        $request->validate(CmsPageModel::rules());
        CmsPageModel::create($request->all());
        return redirect()->route('admin.cms.index')->with('success', 'Berhasil menambahkan halaman baru.');
    }

    public function edit($id)
    {
        $cmsPage = CmsPageModel::find($id);
        return view('backend.admin.cms.create', compact('cmsPage'));
    }

    public function update(Request $request, $id)
    {
        $cmsPage = CmsPageModel::find($id);
        $request->validate(CmsPageModel::rules());
        $cmsPage->update($request->all());
        return redirect()->route('admin.cms.index')->with('success', 'Success mengupdate halaman.');
    }

    public function destroy($id)
    {
        $cmsPage = CmsPageModel::find($id);
        $cmsPage->delete();
        return redirect()->route('admin.cms.index')->with('success', 'Success menghapus halaman.');
    }
}
