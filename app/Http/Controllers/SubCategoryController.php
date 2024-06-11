<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use PDF;

class SubCategoryController extends Controller
{
    // index subcategory
    public function subCategory()
    {
        if (auth('admin')->user()->can('view-sub-category')) {
            $category = Category::latest()->get();
            $subCategory = SubCategory::latest()->paginate(10);
            return view('backend.subCategory.sub-category', compact('category', 'subCategory'));
        }
        abort(403, 'Unauthorized action.');
    }
    // store subcategory
    public function storeSubCustomer(Request $request)
    {
        if (auth('admin')->user()->can('create-sub-category')) {
            $request->validate([
                'category_id' => 'required',
                'sub_category_name' => 'required',
            ]);
            $SubCategory = new SubCategory();
            $SubCategory->category_id = $request->category_id;
            $SubCategory->sub_category_name = $request->sub_category_name;
            $SubCategory->save();
            return back()->with('message', 'Sub Category Store Sucessfully');
            abort(403, 'Unauthorized action.');
        }
    }
    // edit sub category
    public function showEditSubCategory($id)
    {
        $category = Category::latest()->get();
        $subCategory = SubCategory::find($id);
        return view('backend.subCategory.subCategoryEdit', compact('subCategory', 'category'));
    }
    public function editSubCategory($id)
    {
        if (auth('admin')->user()->can('edit-sub-category')) {
            $subCategory = SubCategory::find($id);
            $subCategory->update([
                'sub_category_name' => request('sub_category_name'),
                'category_id' => request('category_id')
            ]);
            return redirect()->route('subCategory');
        }
        abort(403, 'Unauthorized action.');
    }
    // delete sub category
    public function deleteSubCategory($id)
    {
        if (auth('admin')->user()->can('delete-sub-category')) {
            $subCategory = SubCategory::find($id);
            $subCategory->delete();
            return back()->with('message', 'Sub Category Delete Successfully');
        }
        abort(403, 'Unauthorized action.');
    }
    // pdf Sub Category
    public function pdfSubCategory()
    {
        $subCategory = SubCategory::latest()->get();
        $pdf = PDF::loadView('backend.subCategory.pdf.subCategory-invoice', [
            'subCategory' => $subCategory,
        ]);
        return $pdf->download('subCategory-invoice.pdf');
    }
}
