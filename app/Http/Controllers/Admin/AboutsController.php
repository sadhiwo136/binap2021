<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Abouts;
use App\User;

class AboutsController extends Controller
{
    public function index()
    {
        //$abouts = Abouts::all();
        $abouts = Abouts::paginate(10);
        return view('admin.abouts')->with('abouts', $abouts);
    }

    public function store(Request $request)
    {
        $abouts = new Abouts;

        $abouts->title = $request->input('title');
        $abouts->subtitle = $request->input('subtitle');
        $abouts->description = $request->input('description');

        $abouts->save();

        return redirect('/abouts')->with('status', 'Description added.');
    }

    public function edit($id)
    {
        $abouts = Abouts::findOrFail($id);
        return view('admin.abouts.edit')->with('abouts', $abouts);
    }

    public function update(Request $request, $id)
    {
        $abouts = Abouts::findOrFail($id);
        $abouts->title = $request->input('title');
        $abouts->subtitle = $request->input('subtitle');
        $abouts->description = $request->input('description');
        $abouts->update();       

        return redirect('abouts')->with('status', 'Description updated.');
    }

    public function delete($id)
    {
        $abouts = Abouts::findOrFail($id);
        $abouts->delete();

        return redirect('abouts')->with('status', 'Description Deleted.');
    }
}