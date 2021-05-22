<?php

namespace App\Http\Controllers\Proyek;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
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
use Carbon\Carbon;

class ProyekController extends Controller
{
    public function index($id_prshn)
    {        
        $projects = DB::table('proyek')
                    ->where('proyek.id_prshn', '=', $id_prshn)
                    ->join('companies', 'companies.id_prshn', '=', 'proyek.id_prshn')
                    ->select('proyek.*')
                    ->get();
        
        $nama = DB::table('companies')
                    ->where('companies.id_prshn', '=', $id_prshn)
                    ->select('companies.nama_prshn','companies.id_prshn')
                    ->first();
        
        return view('developer.dashboard')->with('projects', $projects)->with('nama', $nama);
    }

    public function all_item()
    {
        if(Auth::user()->usertype == 'admin')
        {
            $projects = DB::table('proyek')
                        ->join('companies', 'companies.id_prshn', '=', 'proyek.id_prshn')
                        ->join('kota', 'kota.id', '=', 'proyek.id_kota')
                        ->select('proyek.*','companies.nama_prshn as namaku', 'kota.nama as kotaku')
                        ->get();
            return view('developer.admin_list')->with('projects', $projects);
        }

        if(Auth::user()->usertype == 'developer')
        {
            $projects = DB::table('proyek')
                        ->join('companies', 'companies.id_prshn', '=', 'proyek.id_prshn')
                        ->join('kota', 'kota.id', '=', 'proyek.id_kota')
                        ->whereIn('proyek.id_prshn', function($companies)
                        {
                            $companies->select('id_prshn')
                                        ->from('companies')
                                        ->where('companies.id_user', '=', Auth::user()->id);
                        })
                        ->select('proyek.*','companies.nama_prshn as namaku', 'kota.nama as kotaku')
                        ->get();
            return view('developer.admin_list')->with('projects', $projects);
        }
    }

    public function add_proyek($id_prshn)
    {
        $nama = DB::table('companies')
                    ->where('companies.id_prshn', '=', $id_prshn)
                    ->select('companies.nama_prshn','companies.id_prshn')
                    ->first();

        $kota = Kota::all();
        $lurah = Kelurahan::all();
        $camat = Kecamatan::all();
        return view('developer.proyek_new')->with('nama', $nama)->with('kota', $kota)->with('lurah', $lurah)->with('camat', $camat);
    }

    public function getKecamatan3($id)
    {    	
        $data['data'] = Kecamatan::orderby("nama","asc")
                            ->select('id','nama')
                            ->where('id_kota',$id)
                            ->get();
        
        return response()->json($data);
     
    }

    public function getKelurahan3($id)
    {    	
        $data['data'] = Kelurahan::orderby("nama","asc")
                            ->select('id','nama')
                            ->where('id_kecamatan',$id)
                            ->get();
        
        return response()->json($data);
     
    }

    public function test_alert()
    {
        echo "<script>";
        echo "alert('format file sudah benar');";
        echo "</script>";

        return back();
    }

    public function store_proyek(Request $request, $id_prshn)
    {
        try
        {
            $proyek = new Proyek;
            $proyek->status_thp_terakhir = '1';
            $proyek->tgl_entri = Carbon::now();

            $proyek->id_prshn = $id_prshn;
            $proyek->lokasi = $request->input('lokasi');
            $proyek->longitude_loc = $request->input('longitude_loc');
            $proyek->latitude_loc = $request->input('latitude_loc');

            $proyek->id_klurahn = $request->input('id_klurahn');
            $proyek->id_kecamatan = $request->input('id_kecamatan');
            $proyek->id_kota = $request->input('id_kota');
            $proyek->luas_area = $request->input('luas_area');
            $proyek->jml_unit = $request->input('jml_unit');
            $proyek->jenis_produk = $request->input('jenis_produk');
            $proyek->tgl_mulai = $request->input('tgl_mulai');
            $proyek->tgl_target = $request->input('tgl_target');

            request()->validate([
                'siteplan' => 'required|mimes:pdf,jpg,png,jpeg',
                'ukl_upl' => 'required|mimes:pdf,jpg,png,jpeg',
                'imb' => 'required|mimes:pdf,jpg,png,jpeg',
                'ipb' => 'required|mimes:pdf,jpg,png,jpeg',
                'sertifikat_tanah' => 'required|mimes:pdf,jpg,png,jpeg',
                'akta_notaris' => 'required|mimes:pdf,jpg,png,jpeg',
                'sertifikat_psu' => 'required|mimes:pdf,jpg,png,jpeg',
            ]);
            
            $proyek->siteplan = $request->input('siteplan');
            $proyek->ukl_upl = $request->input('ukl_upl');
            $proyek->imb = $request->input('imb');
            $proyek->ipb = $request->input('ipb');
            $proyek->sertifikat_tanah = $request->input('sertifikat_tanah');
            $proyek->akta_notaris = $request->input('akta_notaris');
            $proyek->sertifikat_psu = $request->input('sertifikat_psu');  

            $fileName1 = request()->siteplan->getClientOriginalName();
            $fileName2 = request()->ukl_upl->getClientOriginalName();
            $fileName3 = request()->imb->getClientOriginalName();
            $fileName4 = request()->ipb->getClientOriginalName();
            $fileName5 = request()->sertifikat_tanah->getClientOriginalName();
            $fileName6 = request()->akta_notaris->getClientOriginalName();
            $fileName7 = request()->sertifikat_psu->getClientOriginalName();        
            
            request()->siteplan->move(public_path('proyek/1/'), $fileName1);
            request()->ukl_upl->move(public_path('proyek/2/'), $fileName2);
            request()->imb->move(public_path('proyek/3/'), $fileName3);
            request()->ipb->move(public_path('proyek/4/'), $fileName4);
            request()->sertifikat_tanah->move(public_path('proyek/5/'), $fileName5);
            request()->akta_notaris->move(public_path('proyek/6/'), $fileName6);
            request()->sertifikat_psu->move(public_path('proyek/7/'), $fileName7);

            $proyek->siteplan = $fileName1;
            $proyek->ukl_upl = $fileName2;
            $proyek->imb = $fileName3;
            $proyek->ipb = $fileName4;
            $proyek->sertifikat_tanah = $fileName5;
            $proyek->akta_notaris = $fileName6;
            $proyek->sertifikat_psu = $fileName7;
            
            $proyek->save();
            //return back()->with('status', 'Perusahaan berhasil ditambahkan.');
            //return redirect('/index_proyek/$id_prshn')->with('status', 'Perusahaan berhasil ditambahkan.');
            return Redirect::to("/index_proyek"."/".$id_prshn)->with('status', 'Proyek berhasil ditambahkan.');
        }
        catch (Throwable $e)
        {
            return back()->with('status2', 'Proyek gagal ditambahkan.');
        }
    }

    public function update_proyek(Request $request, $id)
    {
        try
        {
            $proyek = Proyek::findOrFail($id);

            $proyek->last_modified = Carbon::now();
            $proyek->lokasi = $request->input('lokasi');
            $proyek->longitude_loc = $request->input('longitude_loc');
            $proyek->latitude_loc = $request->input('latitude_loc');
            $proyek->id_klurahn = $request->input('id_klurahn');
            $proyek->id_kecamatan = $request->input('id_kecamatan');
            $proyek->id_kota = $request->input('id_kota');
            $proyek->luas_area = $request->input('luas_area');
            $proyek->jml_unit = $request->input('jml_unit');
            $proyek->jenis_produk = $request->input('jenis_produk');
            $proyek->tgl_mulai = $request->input('tgl_mulai');
            $proyek->tgl_target = $request->input('tgl_target');
            $proyek->status_thp_terakhir = $request->input('status_thp_terakhir');

            if($request->input('status_thp_terakhir') != '1')
            {
                $proyek->tgl_thp_terakhir = Carbon::now()->toDateString();
            }

            $proyek->update();

            return back()->with('status','Data proyek berhasil diubah.');
        }
        catch (Throwable $e)
        {
            return back()->with('status2', 'Data proyek gagal diubah.');
        }
    }

    public function update_siteplan($id)
    {
        $fn1 =  Proyek::where('id', $id)->value('siteplan');

        if($fn1 != '' || $fn1 != null)
        {
            $src1 = 'proyek/1';
            if(file_exists($src1.'/'.$fn1))
                unlink($src1.'/'.$fn1);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->siteplan != null && in_array(request()->siteplan->getClientOriginalExtension(), $types))
        {
            $fileName1 = request()->siteplan->getClientOriginalName();
            request()->siteplan->move(public_path('proyek/1'), $fileName1);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->siteplan = $fileName1;
            $proyek->update();
            return back()->with('status','Dokumen siteplan berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->siteplan = '';
            $proyek->update();
            return back()->with('status2','Dokumen siteplan kosong atau salah format file.');
        }
    }

    public function update_ukl_upl($id)
    {
        $fn2 =  Proyek::where('id', $id)->value('ukl_upl');

        if($fn2 != '' || $fn2 != null)
        {
            $src2 = 'proyek/2';
            if(file_exists($src2.'/'.$fn2))
                unlink($src2.'/'.$fn2);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->ukl_upl != null && in_array(request()->ukl_upl->getClientOriginalExtension(), $types))
        {
            $fileName2 = request()->ukl_upl->getClientOriginalName();
            request()->ukl_upl->move(public_path('proyek/2'), $fileName2);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->ukl_upl = $fileName2;
            $proyek->update();
            return back()->with('status','Dokumen ukl_upl berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->ukl_upl = '';
            $proyek->update();
            return back()->with('status2','Dokumen ukl_upl kosong atau salah format file.');
        }
    }

    public function update_imb($id)
    {
        $fn3 =  Proyek::where('id', $id)->value('imb');

        if($fn3 != '' || $fn3 != null)
        {
            $src3 = 'proyek/3';
            if(file_exists($src3.'/'.$fn3))
                unlink($src3.'/'.$fn3);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->imb != null && in_array(request()->imb->getClientOriginalExtension(), $types))
        {
            $fileName3 = request()->imb->getClientOriginalName();
            request()->imb->move(public_path('proyek/3'), $fileName3);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->imb = $fileName3;
            $proyek->update();
            return back()->with('status','Dokumen imb berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->imb = '';
            $proyek->update();
            return back()->with('status2','Dokumen imb kosong atau salah format file.');
        }
    }

    public function update_ipb($id)
    {
        $fn4 =  Proyek::where('id', $id)->value('ipb');

        if($fn4 != '' || $fn4 != null)
        {
            $src4 = 'proyek/4';
            if(file_exists($src4.'/'.$fn4))
                unlink($src4.'/'.$fn4);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->ipb != null && in_array(request()->ipb->getClientOriginalExtension(), $types))
        {
            $fileName4 = request()->ipb->getClientOriginalName();
            request()->ipb->move(public_path('proyek/4'), $fileName4);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->ipb = $fileName4;
            $proyek->update();
            return back()->with('status','Dokumen ipb berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->ipb = '';
            $proyek->update();
            return back()->with('status2','Dokumen ipb kosong atau salah format file.');
        }
    }

    public function update_sertifikat_tanah($id)
    {
        $fn5 =  Proyek::where('id', $id)->value('sertifikat_tanah');

        if($fn5 != '' || $fn5 != null)
        {
            $src5 = 'proyek/5';
            if(file_exists($src5.'/'.$fn5))
                unlink($src5.'/'.$fn5);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->sertifikat_tanah != null && in_array(request()->sertifikat_tanah->getClientOriginalExtension(), $types))
        {
            $fileName5 = request()->sertifikat_tanah->getClientOriginalName();
            request()->sertifikat_tanah->move(public_path('proyek/5'), $fileName5);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->sertifikat_tanah = $fileName5;
            $proyek->update();
            return back()->with('status','Dokumen sertifikat_tanah berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->sertifikat_tanah = '';
            $proyek->update();
            return back()->with('status2','Dokumen sertifikat_tanah kosong atau salah format file.');
        }
    }

    public function update_akta_notaris($id)
    {
        $fn6 =  Proyek::where('id', $id)->value('akta_notaris');

        if($fn6 != '' || $fn6 != null)
        {
            $src6 = 'proyek/6';
            if(file_exists($src6.'/'.$fn6))
                unlink($src6.'/'.$fn6);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->akta_notaris != null && in_array(request()->akta_notaris->getClientOriginalExtension(), $types))
        {
            $fileName6 = request()->akta_notaris->getClientOriginalName();
            request()->akta_notaris->move(public_path('proyek/6'), $fileName6);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->akta_notaris = $fileName6;
            $proyek->update();
            return back()->with('status','Dokumen akta_notaris berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->akta_notaris = '';
            $proyek->update();
            return back()->with('status2','Dokumen akta_notaris kosong atau salah format file.');
        }
    }

    public function update_sertifikat_psu($id)
    {
        $fn7 =  Proyek::where('id', $id)->value('sertifikat_psu');

        if($fn7 != '' || $fn7 != null)
        {
            $src7 = 'proyek/7';
            if(file_exists($src7.'/'.$fn7))
                unlink($src7.'/'.$fn7);
        }

        $types = array("pdf", "png", "jpg", "jpeg");

        if(request()->sertifikat_psu != null && in_array(request()->sertifikat_psu->getClientOriginalExtension(), $types))
        {
            $fileName7 = request()->sertifikat_psu->getClientOriginalName();
            request()->sertifikat_psu->move(public_path('proyek/7'), $fileName7);
            
            $proyek = Proyek::findOrFail($id);
            $proyek->sertifikat_psu = $fileName7;
            $proyek->update();
            return back()->with('status','Dokumen sertifikat_psu berhasil diubah.');
        }
        else
        {
            $proyek = Proyek::findOrFail($id);
            $proyek->sertifikat_psu = '';
            $proyek->update();
            return back()->with('status2','Dokumen sertifikat_psu kosong atau salah format file.');
        }
    }

    public function delete_proyek($id)
    {
        $fn1 = Proyek::where('id', $id)->value('siteplan');
        $src1 = 'proyek/1';
        if(file_exists($src1.'/'.$fn1))
            unlink($src1.'/'.$fn1);

        $fn2 = Proyek::where('id', $id)->value('ukl_upl');
        $src2 = 'proyek/2';
        if(file_exists($src2.'/'.$fn2))
            unlink($src2.'/'.$fn2);
        
        $fn3 = Proyek::where('id', $id)->value('imb');
        $src3 = 'proyek/3';
        if(file_exists($src3.'/'.$fn3))
            unlink($src3.'/'.$fn3);

        $fn4 = Proyek::where('id', $id)->value('ipb');
        $src4 = 'proyek/4';
        if(file_exists($src4.'/'.$fn4))
            unlink($src4.'/'.$fn4);

        $fn5 = Proyek::where('id', $id)->value('sertifikat_tanah');
        $src5 = 'proyek/5';
        if(file_exists($src5.'/'.$fn5))
            unlink($src5.'/'.$fn5);

        $fn6 = Proyek::where('id', $id)->value('akta_notaris');
        $src6 = 'proyek/6';
        if(file_exists($src6.'/'.$fn6))
            unlink($src6.'/'.$fn6);

        $fn7 = Proyek::where('id', $id)->value('sertifikat_psu');
        $src7 = 'proyek/7';
        if(file_exists($src7.'/'.$fn7))
            unlink($src7.'/'.$fn7);

        $projects = Proyek::findOrFail($id);
        $projects->delete();

        return back()->with('status', 'Data perusahaan berhasil dihapus.');
    }

    public function proyek_info($id)
    {
        $lurah = Kelurahan::all();
        $camat = Kecamatan::all();
        $kota = Kota::all();
        
        $projects = DB::table('proyek')
                    ->where('proyek.id', '=', $id)
                    ->join('kelurahan', 'proyek.id_klurahn', '=', 'kelurahan.id')
                    ->join('kecamatan', 'proyek.id_kecamatan', '=', 'kecamatan.id')
                    ->join('kota', 'proyek.id_kota', '=', 'kota.id')
                    ->select('proyek.id', 'proyek.*', 'kelurahan.nama as lurahku', 'kecamatan.nama as camatku', 'kota.nama as kotaku')
                    ->first();

        return view('developer.proyek_info')->with('projects', $projects)->with('lurah', $lurah)->with('camat', $camat)->with('kota', $kota);
    }
}