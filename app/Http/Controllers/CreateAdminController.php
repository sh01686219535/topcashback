<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Role;

class CreateAdminController extends Controller
{
    public function adminList()
    {
        if (auth('admin')->user()->can('view-admin')) {
        $list = Admin::latest()->get();
        return view('backend.createAdmin.adminList', compact('list'));
    }
    abort(403, 'Unauthorized action.');
    }

    public function createAdmin()
    {
        if (auth('admin')->user()->can('create-admin')) {
        $adminCreate = Role::all();
        return view('backend.createAdmin.createAdmin', compact('adminCreate'));
    }
    abort(403, 'Unauthorized action.');
    }
    public function adminCreate()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'user_role' => 'required',
        ]);
        $imageExtension = request()->file('image')->extension();
        $imageName = "photo_" . uniqid() . "_" . time() . "." . $imageExtension;
        request()->file('image')->move('images', $imageName);


        $admin = Admin::create([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'password' => bcrypt(request('password')),
            'image' => $imageName,
            'user_role' => request('user_role'),
            
        ]);
        $admin->roles()->attach(request('user_role'));


        return to_route('adminList');
    }
    public function showEditAdmin($id){
    if (auth('admin')->user()->can('edit-admin')) {
       $adminCreate = Role::get();
        $test = Admin::find($id);
        return view('backend.createAdmin.editAdmin', compact('test','adminCreate'));
    }
    abort(403, 'Unauthorized action.');
    }
    public function editAdmin($id)
    {

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'user_role' => 'required',
        ]);
        $imageExtension = request()->file('image')->extension();
        $imageName = "photo_" . uniqid() . "_" . time() . "." . $imageExtension;
        request()->file('image')->move('images', $imageName);
        $test = Admin::find($id);
        $test->update([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'password' => bcrypt(request('password')),
            'image' => $imageName,
            'user_role' => request('user_role'),

        ]);
        return redirect()->route('adminList');
    }
    public function deleteAdmin($id)
    {
        if (auth('admin')->user()->can('delete-admin')) {
        Admin::findOrFail($id)->delete();
        return redirect()->back();
    }
    abort(403, 'Unauthorized action.');
    }
}
