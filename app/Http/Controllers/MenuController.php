<?php

namespace App\Http\Controllers;

use App\Models\CmsPageModel;
use Illuminate\Http\Request;

class MenuController extends Controller
{
   public function index(){
        $cmsMenu = CmsPageModel::orderBy('order_by', 'asc')->paginate(10);
        return view('backend.admin.menu.index', compact('cmsMenu'));
   }

   public function updateOrder(Request $request, $id)
    {
        $page = CmsPageModel::find($id);
        if (!$page) {
            return redirect()->route('admin.menu.index')->with('error', 'Menu item not found');
        }

        $action = $request->input('action');

        if ($action === 'up') {
            $this->moveUp($page);
        } elseif ($action === 'down') {
            $this->moveDown($page);
        }

        return redirect()->route('admin.menu.index')->with('success', 'Order updated successfully!');
    }

    protected function moveUp($page)
    {
        $previousPage = CmsPageModel::where('order_by', '<', $page->order_by)->orderBy('order_by', 'desc')->first();

        if ($previousPage) {
            $tempOrder = $page->order_by;
            $page->order_by = $previousPage->order_by;
            $previousPage->order_by = $tempOrder;

            $page->save();
            $previousPage->save();
        }
    }

    protected function moveDown($page)
    {
        $nextPage = CmsPageModel::where('order_by', '>', $page->order_by)->orderBy('order_by', 'asc')->first();

        if ($nextPage) {
            $tempOrder = $page->order_by;
            $page->order_by = $nextPage->order_by;
            $nextPage->order_by = $tempOrder;

            $page->save();
            $nextPage->save();
        }
    }

    public function toggleActive($id)
    {
        $page = CmsPageModel::find($id);
        if ($page) {
            $page->active = !$page->active;
            $page->save();
        }

        return redirect()->route('admin.menu.index')->with('success', 'Status updated successfully!');
    }

    public function updateOrderBy(Request $request)
    {
        $orderedIds = $request->input('order');
        foreach ($orderedIds as $index => $id) {
            CmsPageModel::where('id', $id)
                ->update(['order_by' => $index]);
        }
        return response()->json(['success' => true]);
    }
}
