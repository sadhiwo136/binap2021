<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Laporan;
use App\User;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        if(Auth::user()->usertype == 'warga')
        {
            $laporan = DB::table('laporan')
                        ->where('laporan.id_pelapor', '=', Auth::user()->id)
                        ->select('laporan.*')
                        ->get();            
        }
        
        if(Auth::user()->usertype == 'admin')
             $laporan = Laporan::all();
   
        return view('warga.laporanwarga')->with('laporan', $laporan);                            
    }

    public function simpan_laporan(Request $request)
    {
        $laporan = new Laporan;
 
        $laporan->id_pelapor = Auth::user()->id;
        $laporan->judul = $request->input('judul');
        $laporan->deskripsi = $request->input('deskripsi');

        request()->validate([
            'foto1' => 'required|mimes:jpg,png,jpeg',
            'foto2' => 'required|mimes:jpg,png,jpeg'
        ]);

        $filefoto1 = request()->foto1->getClientOriginalName();
        $filefoto2 = request()->foto2->getClientOriginalName();

        request()->foto1->move(public_path('fotoo1'), $filefoto1);
        request()->foto2->move(public_path('fotoo2'), $filefoto2);

        $laporan->foto1 = $filefoto1;
        $laporan->foto2 = $filefoto2;

        $laporan->save();

        return redirect('/laporan')->with('status', 'Laporan berhasil ditambahkan!');
    }

    public function respon_laporan(Request $request, $id_laporan)
    {
        $laporan = Laporan::findOrFail($id_laporan);

        $laporan->status_terakhir = $request->input('status_terakhir');
        $laporan->SKPD_terkait = $request->input('SKPD_terkait');
        $laporan->jawaban_SKPD = $request->input('jawaban_SKPD');
        $laporan->feedback_pelapor = $request->input('feedback_pelapor');
        $laporan->tanggal_status_terakhir = $request->input('tanggal_status_terakhir');

        $laporan->update();

        return back()->with('success', 'Data laporan berhasil diubah');
    }

    public function detail_laporan($id_laporan)
    {
        $userss = User::all();
        $laporan = DB::table('laporan')
                    ->join('users', 'laporan.id_pelapor', '=', 'users.id')
                    ->select('users.name', 'laporan.*')
                    ->where('id_laporan', $id_laporan)
                    ->first();
        return view('admin.laporan.laporan-detail')->with('laporan', $laporan)->with('users', $userss);

    }

    public function del_laporan($id_laporan)
    {
        $ft1 = Laporan::where('id_laporan', $id_laporan)->value('foto1');
        $src1 = 'fotoo1';

        if(file_exists($src1.'/'.$ft1) && ($ft1 != '' || $ft1 != null))
            unlink($src1.'/'.$ft1);

        $ft2 = Laporan::where('id_laporan', $id_laporan)->value('foto2');
        $src2 = 'fotoo2';

        if(file_exists($src2.'/'.$ft2) && ($ft2 != '' || $ft2 != null))
            unlink($src2.'/'.$ft2);

        $laporan = Laporan::findOrFail($id_laporan);
        $laporan->delete();

        return redirect('/laporan')->with('status', 'Data laporan berhasil dihapus');
    }

    public function update_foto1($id_laporan)
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

    public function update_foto2($id_laporan)
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
