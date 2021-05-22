<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Laporan;
use App\User;
use Illuminate\Support\Facades\Auth;

class LaporanWargaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $laporan = Laporan::all();
        return view('warga.laporanwarga')->with('laporan', $laporan);
    }

    public function simpan_laporan(Request $request)
    {
        $laporan = new Laporan;

        $laporan->id_pelapor = Auth::user()->id;
        $laporan->judul = $request->input('judul');
        $laporan->deskripsi = $request->input('deskripsi');

        // request()->validate([
        //     'foto1' => 'required|mimes:jpg,png,jpeg',
        //     'foto2' => 'required|mimes:jpg,png,jpeg'
        // ]);

        if(request()->foto1 != null)
        {
            $filefoto1 = request()->foto1->getClientOriginalName();
            request()->foto1->move(public_path('fotoo1'), $filefoto1);
            $laporan->foto1 = $filefoto1;
        }
        else
        {
            $laporan->foto1 = '';
        }
        if(request()->foto2 != null)
        {
            $filefoto2 = request()->foto2->getClientOriginalName();
            request()->foto2->move(public_path('fotoo2'), $filefoto2);
            $laporan->foto2 = $filefoto2;
        }
        else
        {
            $laporan->foto2 = '';
        }

        $laporan->save();

        return redirect('/laporanwarga')->with('status', 'Laporan berhasil ditambahkan!');
    }

    public function detail_laporan($id_laporan)
    {
        $userss = User::all();
        $laporan = DB::table('laporan')
                    ->join('users', 'laporan.id_pelapor', '=', 'users.id')
                    ->select('users.name', 'laporan.*')
                    ->where('id_laporan', $id_laporan)
                    ->first();
        return view('warga.laporanwargadet')->with('laporan', $laporan)->with('users', $userss);

    }

    public function del_laporan($id_laporan)
    {
        $ft1 = Laporan::where('id_laporan', $id_laporan)->value('foto1');
        $src1 = 'fotoo1';
        unlink($src1.'/'.$ft1);

        $ft2 = Laporan::where('id_laporan', $id_laporan)->value('foto2');
        $src2 = 'fotoo2';
        unlink($src2.'/'.$ft2);

        $laporan = Laporan::findOrFail($id_laporan);
        $laporan->delete();

        return redirect('/laporanwarga')->with('status', 'Data laporan berhasil dihapus');
    }

    public function update_laporan(Request $request, $id_laporan)
    {
        $laporan = Laporan::findOrFail($id_laporan);

        $laporan->id_pelapor = Auth::user()->id;
        $laporan->judul = $request->input('judul');
        $laporan->deskripsi = $request->input('deskripsi');

        $laporan->update();

        return back()->with('success', 'Data laporan berhasil diubah');
    }

    public function updatew_foto1($id_laporan)
    {
        $ft1 = Laporan::where('id_laporan', $id_laporan)->value('foto1');

        if($ft1 != '' || $ft1 != null)
        {
            $src1 = 'fotoo1';
            unlink($src1.'/'.$ft1);
        }

        if(request()->foto1 != null)
        {
            $filefoto1 = request()->foto1->getClientOriginalName();
            request()->foto1->move(public_path('fotoo1'), $filefoto1);

            $laporan = Laporan::findOrFail($id_laporan);
            $laporan->foto1 = $filefoto1;
            $laporan->update();
            return back()->with('success', 'Foto berhasil diubah');
        }
        else
        {
            $laporan = Laporan::findOrFail($id_laporan);
            $laporan->foto1 = '';
            $laporan->update();
            return back()->with('success', 'Dokumen kosong');
        }
    }

    public function updatew_foto2($id_laporan)
    {
        $ft2 = Laporan::where('id_laporan', $id_laporan)->value('foto2');

        if($ft2 != '' || $ft2 != null)
        {
            $src2 = 'fotoo2';
            unlink($src2.'/'.$ft2);
        }

        if(request()->foto2 != null)
        {
            $filefoto2 = request()->foto2->getClientOriginalName();
            request()->foto2->move(public_path('fotoo2'), $filefoto2);

            $laporan = Laporan::findOrFail($id_laporan);
            $laporan->foto2 = $filefoto2;
            $laporan->update();
            return back()->with('success', 'Foto berhasil diubah');
        }
        else
        {
            $laporan = Laporan::findOrFail($id_laporan);
            $laporan->foto2 = '';
            $laporan->update();
            return back()->with('success', 'Dokumen kosong');
        }
    }

}
