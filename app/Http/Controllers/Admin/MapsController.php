<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coordinates;

class MapsController extends Controller
{
    public function save_loc(Request $request)
    {
        $coordinates = new Coordinates;

        $coordinates->lat = $request->input('val-lat');
        $coordinates->long = $request->input('val-lng');

        $coordinates->save();

        return redirect('/maps')->with('status', 'Location added.');
    }

    public function index()
    {
        $coordinates = Coordinates::all();
        //$abouts = Abouts::paginate(10);
        return view('admin.maps')->with('coordinates', $coordinates);
    }

    public function del_loc($id)
    {
        $coord = Coordinates::findOrFail($id);
        $coord->delete();

        return redirect('/maps')->with('status', 'Coordinate deleted.');
    }
}
