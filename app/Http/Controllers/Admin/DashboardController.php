<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function registered()
    {
        //$users = User::all();
        $users = User::paginate(10);
        return view('admin.member')->with('users', $users);
    }

    public function editmember(Request $request, $id)
    {
        $users = User::findOrFail($id);
        return view('admin.member-edit')->with('users', $users);
    }

    public function updatemember(Request $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->input('username');
        $users->phone = $request->input('phone');
        $users->usertype = $request->input('usertype');
        $users->update();

        return redirect('/role-member')->with('status', 'Your data is updated.');
    }

    public function deletemember($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('/role-member')->with('status', 'Your data is deleted.');
    }

    public function save_new(Request $request)
    {
        $users = new User;

        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = Hash::make($request->input('password'));

        $users->save();

        return back()->with('status', 'Anggota berhasil ditambahkan.');
    }
}