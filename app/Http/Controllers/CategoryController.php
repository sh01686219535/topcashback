<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Merchant;
use PDF;

class CategoryController extends Controller
{
    //index category
    public function category(){
        if(auth('admin')->user()->can('view-category')){
        $merchant = Merchant::all();
        $category = Category::latest()->paginate(10);
        return view('backend.category.category',compact('category','merchant'));
    }
    abort(403, 'Unauthorized action.');
    }
    // store category
    public function addCategory(Request $request){
        if(auth('admin')->user()->can('create-category')){
        $request->validate([
            'category_name'=>'required',
        ]);
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
        return to_route('category')->with('message','Category Store Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
    //edit category
    public function showEditCategory($id){
        $category= Category::find($id);
        return view('backend.category.categoryEdit',compact('category'));

    }
    public function editCategory($id){
        if(auth('admin')->user()->can('edit-category')){
        $category= Category::find($id);
        $category->update([
            'category_name' => request('category_name'),

        ]);
        return redirect()->route('category');
    }
    abort(403, 'Unauthorized action.');
    }
    // delete category
    public function deleteCategory($id){
        if(auth('admin')->user()->can('delete-category')){
        $category = Category::find($id);
        $category->delete();
        return back()->with('message','Category Deleted Successfully');
    }
    abort(403, 'Unauthorized action.');
    }
    // PDF Category
    public function pdfCategory(){
        $category = Category::latest()->get();
        $pdf = PDF::loadView('backend.category.pdf.category-invoice',[
            'category'=>$category,
        ]);
        return $pdf->download('category-invoice.pdf');
    }
}
