<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Companies;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Kota;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Post;
use Redirect,Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index() //companies
    {
        if(Auth::user()->usertype == 'developer')
        {
            $companies = DB::table('companies')
                        ->where('companies.id_user', '=', Auth::user()->id)
                        ->select('companies.*')
                        ->get();
        }
        else
            $companies = Companies::all();

        $lurah = Kelurahan::all();
        $camat = Kecamatan::all();
        $kota = Kota::all();
        return view('admin.companies')->with('companies', $companies)->with('lurah', $lurah)->with('camat', $camat)->with('kota', $kota);
    }

    public function store_com(Request $request) //save-company
    {
        if($request->input('id_klurahn')==0 || $request->input('id_kecamatan')==0 || $request->input('id_kota')==0)
            return redirect('/companies')->with('status2', 'Domisili belum ditambahkan, data kosong.');

        $types = array("pdf", "png", "jpg", "jpeg");

        if(in_array(request()->file_akta->getClientOriginalExtension(), $types) && in_array(request()->file_ktp->getClientOriginalExtension(), $types) && in_array(request()->file_foto->getClientOriginalExtension(), $types))
        {
            $companies = new Companies;
            $statusku = 'DIPROSES';
            $companies->nama_prshn = $request->input('nama_prshn');
            $companies->bentuk_prshn = $request->input('bentuk_prshn');
            $companies->nama_owner = $request->input('nama_owner');
            $companies->thn_est = $request->input('thn_est');
            $companies->alamat = $request->input('alamat');
            $companies->telepon = $request->input('telepon');
            $companies->website = $request->input('website');
            $companies->email = $request->input('email');
            $companies->id_klurahn = $request->input('id_klurahn');
            $companies->id_kecamatan = $request->input('id_kecamatan');
            $companies->id_kota = $request->input('id_kota');
            $companies->lat_prshn = $request->input('lat_prshn');
            $companies->long_prshn = $request->input('long_prshn');
            $companies->status_prshn = $statusku;

            request()->validate([
                'file_akta' => 'required|mimes:pdf,jpg,png,jpeg',
                'file_ktp' => 'required|mimes:pdf,jpg,png,jpeg',
                'file_foto' => 'required|mimes:pdf,jpg,png,jpeg',
            ]);  

            $fileName1 = request()->file_akta->getClientOriginalName();
            $fileName2 = request()->file_ktp->getClientOriginalName();
            $fileName3 = request()->file_foto->getClientOriginalName();
            
            request()->file_akta->move(public_path('z_akta'), $fileName1);
            request()->file_ktp->move(public_path('z_ktp'), $fileName2);
            request()->file_foto->move(public_path('z_foto'), $fileName3);

            $companies->file_akta = $fileName1;
            $companies->file_ktp = $fileName2;
            $companies->file_foto = $fileName3;
            $companies->id_user = Auth::user()->id;
            $companies->save();

            return redirect('/companies')->with('status', 'Perusahaan berhasil ditambahkan.');            
        }
        else
            return redirect('/companies')->with('status2', 'Format file tidak sesuai persyaratan (pdf/image), data kosong.');
    }

    public function update_comp(Request $request, $id_prshn)
    {
        $companies = Companies::findOrFail($id_prshn);

        $companies->nama_prshn = $request->input('nama_prshn');
        $companies->bentuk_prshn = $request->input('bentuk_prshn');
        $companies->nama_owner = $request->input('nama_owner');
        $companies->thn_est = $request->input('thn_est');
        $companies->alamat = $request->input('alamat');
        $companies->telepon = $request->input('telepon');
        $companies->website = $request->input('website');
        $companies->email = $request->input('email');
        $companies->id_klurahn = $request->input('id_klurahn');
        $companies->id_kecamatan = $request->input('id_kecamatan');
        $companies->id_kota = $request->input('id_kota');
        $companies->lat_prshn = $request->input('lat_prshn');
        $companies->long_prshn = $request->input('long_prshn');

        $companies->update();

        return back()->with('success','Data perusahaan berhasil diubah.');
    }
    
    public function show_detail($id_prshn)
    {
        $lurah = Kelurahan::all();
        $camat = Kecamatan::all();
        $kota = Kota::all();
        
        $companies = DB::table('companies')
                    ->where('companies.id_prshn', '=', $id_prshn)
                    ->join('kelurahan', 'companies.id_klurahn', '=', 'kelurahan.id')
                    ->join('kecamatan', 'companies.id_kecamatan', '=', 'kecamatan.id')
                    ->join('kota', 'companies.id_kota', '=', 'kota.id')
                    ->select('companies.id_prshn', 'companies.*', 'kelurahan.nama as lurahku', 'kecamatan.nama as camatku', 'kota.nama as kotaku')
                    ->first();

        return view('admin.companies.company-detail')->with('companies', $companies)->with('lurah', $lurah)->with('camat', $camat)->with('kota', $kota);
    }

    public function status_diproses($id_prshn)
    {
        $companies = Companies::findOrFail($id_prshn);
        $companies->status_prshn = 'DIPROSES';
        $companies->update();

        return back()->with('success','Data perusahaan sedang diproses.');
    }

    public function status_disetujui($id_prshn)
    {
        $companies = Companies::findOrFail($id_prshn);
        $companies->status_prshn = 'DISETUJUI';
        $companies->update();

        return back()->with('success','Data perusahaan telah disetujui.');
    }

    public function status_revisi($id_prshn)
    {
        $companies = Companies::findOrFail($id_prshn);
        $companies->status_prshn = 'REVISI';
        $companies->update();

        return back()->with('success','Data perusahaan harus direvisi.');
    }

    public function status_ditolak($id_prshn)
    {
        $companies = Companies::findOrFail($id_prshn);
        $companies->status_prshn = 'DITOLAK';
        $companies->update();

        return back()->with('success','Data perusahaan telah ditolak.');
    }

    public function del_comp($id_prshn)
    {
        $fn1 =  Companies::where('id_prshn', $id_prshn)->value('file_akta');
        $src1 = 'z_akta';
        if(file_exists($src1.'/'.$fn1))
            unlink($src1.'/'.$fn1);

        $fn2 =  Companies::where('id_prshn', $id_prshn)->value('file_foto');
        $src2 = 'z_foto';
        if(file_exists($src2.'/'.$fn2))
            unlink($src2.'/'.$fn2);

        $fn3 =  Companies::where('id_prshn', $id_prshn)->value('file_ktp');
        $src3 = 'z_ktp';
        if(file_exists($src3.'/'.$fn3))
            unlink($src3.'/'.$fn3);

        $companies = Companies::findOrFail($id_prshn);
        $companies->delete();

        return redirect('/companies')->with('status', 'Data perusahaan berhasil dihapus.');
    }
    
    public function update_file_akta($id_prshn)
    {
        $fn1 =  Companies::where('id_prshn', $id_prshn)->value('file_akta');

        if($fn1 != '' || $fn1 != null)
        {
            $src1 = 'z_akta';
            unlink($src1.'/'.$fn1);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->file_akta != null && in_array(request()->file_akta->getClientOriginalExtension(), $types))
        {
            $fileName1 = request()->file_akta->getClientOriginalName();
            request()->file_akta->move(public_path('z_akta'), $fileName1);
            
            $companies = Companies::findOrFail($id_prshn);
            $companies->file_akta = $fileName1;
            $companies->update();
            return back()->with('success','Dokumen akta berhasil diubah.');
        }
        else
        {
            $companies = Companies::findOrFail($id_prshn);
            $companies->file_akta = '';
            $companies->update();
            return back()->with('success2','Dokumen akta kosong atau salah format file.');
        }
    }

    public function update_file_ktp($id_prshn)
    {
        $fn2 =  Companies::where('id_prshn', $id_prshn)->value('file_ktp');

        if($fn2 != '' || $fn2 != null)
        {
            $src2 = 'z_ktp';
            unlink($src2.'/'.$fn2);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->file_ktp != null && in_array(request()->file_ktp->getClientOriginalExtension(), $types))
        {
            $fileName2 = request()->file_ktp->getClientOriginalName();
            request()->file_ktp->move(public_path('z_ktp'), $fileName2);

            $companies = Companies::findOrFail($id_prshn);
            $companies->file_ktp = $fileName2;
            $companies->update();
            return back()->with('success','Dokumen ktp berhasil diubah.');
        }
        else
        {
            $companies = Companies::findOrFail($id_prshn);
            $companies->file_ktp = '';
            $companies->update();
            return back()->with('success2','Dokumen ktp kosong atau salah format file.');
        }
    }

    public function update_file_foto($id_prshn)
    {
        $fn3 =  Companies::where('id_prshn', $id_prshn)->value('file_foto');

        if($fn3 != '' || $fn3 != null)
        {
            $src3 = 'z_foto';
            unlink($src3.'/'.$fn3);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->file_foto != null && in_array(request()->file_foto->getClientOriginalExtension(), $types))
        {
            $fileName3 = request()->file_foto->getClientOriginalName();
            request()->file_foto->move(public_path('z_foto'), $fileName3);

            $companies = Companies::findOrFail($id_prshn);
            $companies->file_foto = $fileName3;
            $companies->update();
            return back()->with('success','Dokumen foto berhasil diubah.');
        }
        else
        {
            $companies = Companies::findOrFail($id_prshn);
            $companies->file_foto = '';
            $companies->update();
            return back()->with('success2','Dokumen foto kosong atau salah format file.');
        }
    }

    public function getKecamatan2($id_kota)
    {    	
        $kecData['data'] = Kecamatan::orderby("nama","asc")
                            ->select('id','nama')
                            ->where('id_kota',$id_kota)
                            ->get();
        
        return response()->json($kecData);
     
    }

    public function getKelurahan2($id_kecamatan)
    {    	
        $kelData['data'] = Kelurahan::orderby("nama","asc")
                            ->select('id','nama')
                            ->where('id_kecamatan',$id_kecamatan)
                            ->get();
        
        return response()->json($kelData);
     
    }
}