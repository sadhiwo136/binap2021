<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class TestController extends Controller
{
    public function testfunction()
    {
        $data1 = DB::table('kelurahan')->get();
        $data2 = DB::table('kecamatan')->get();
        $data3 = DB::table('kota')->get();
        return view('select', compact('data1','data2','data3'));
    }

    public function getKecamatan($id_kota)
    {    	
        $kecData['data'] = Kecamatan::orderby("nama","asc")
                            ->select('id','nama')
                            ->where('id_kota',$id_kota)
                            ->get();
        
        return response()->json($kecData);
     
    }

    public function getKelurahan($id_kecamatan)
    {    	
        $kelData['data'] = Kelurahan::orderby("nama","asc")
                            ->select('id','nama')
                            ->where('id_kecamatan',$id_kecamatan)
                            ->get();
        
        return response()->json($kelData);
     
    }
}