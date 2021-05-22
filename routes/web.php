<?php

use Illuminate\Support\Facades\Input;
use App\Models\Abouts;
use App\Models\Coordinates;
use App\Models\Documents;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Companies;
use App\Models\Laporan;
use App\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/select', 'TestController@testfunction');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function() {

    Route::get('/register', function () {
        return view('admin.users.user-new');
    });

    Route::get('/dashboard', function() {
        $c1 = User::count();
        $d1 = Kelurahan::count();
        $d2 = Kecamatan::count();
        $m1 = Kota::count();
        $n1 = Companies::count();
        $L1 = Laporan::count();
        return view('admin.dashboard')->with('d1', $d1)->with('d2', $d2)->with('m1', $m1)->with('c1', $c1)->with('n1', $n1)->with('L1', $L1);
    });

    Route::post('/save-user', 'Admin\DashboardController@save_new');

    Route::get('/role-member', 'Admin\DashboardController@registered');

    Route::get('/role-edit/{id}', 'Admin\DashboardController@editmember');

    Route::put('/role-register-update/{id}', 'Admin\DashboardController@updatemember');

    Route::delete('/role-delete/{id}', 'Admin\DashboardController@deletemember');

    Route::get('/abouts','Admin\AboutsController@index');

    Route::post('/save-description', 'Admin\AboutsController@store');

    Route::post('/save-coordinates', 'Admin\MapsController@save_loc');

    Route::delete('/del-cor/{id}', 'Admin\MapsController@del_loc');

    Route::get('/abouts/{id}','Admin\AboutsController@edit');

    Route::put('/abouts-update/{id}', 'Admin\AboutsController@update');

    Route::delete('/abouts-delete/{id}', 'Admin\AboutsController@delete');

    //document part
    Route::get('/upload', 'Admin\UploadController@upload');
    Route::post('/upload/proses', 'Admin\UploadController@proses_upload');
    Route::delete('/upload-delete/{id}', 'Admin\UploadController@delete');

    /*Route::get('/maps', function() {
        return view('admin.maps');
    });*/

    Route::get('/maps','Admin\MapsController@index');

    Route::any ( '/search-abouts', function () {
        $q = Input::get ( 'q' );
        if($q != ""){
            $abouts = Abouts::where ( 'title', 'LIKE', '%' . $q . '%' )->orWhere ( 'subtitle', 'LIKE', '%' . $q . '%' )->orWhere ( 'description', 'LIKE', '%' . $q . '%' )->paginate (100)->setPath ( '' );
            $pagination = $abouts->appends ( array (
                        'q' => Input::get ( 'q' ) 
                ) );
            if (count ( $abouts ) > 0)
                return view('admin.abouts', compact('abouts'))->withQuery($q)->with('successMsg','Results found: '.count($abouts));                
            
            if(count ( $abouts ) == 0)
            {
                $abouts = Abouts::all();                
                return view('admin.empty');                
            }
        }
    } );

    //company
    Route::get('/companies','Admin\CompanyController@index');
    Route::post('/save-company','Admin\CompanyController@store_com');
    Route::get('/perusahaan/{id_prshn}', 'Admin\CompanyController@show_detail');
    //Route::delete('/del_comp/{id_prshn}', 'Admin\CompanyController@del_comp');
    Route::get('/del_comp/{id_prshn}', 'Admin\CompanyController@del_comp')->name('company.delete');
    Route::post('/update-company/{id_prshn}', 'Admin\CompanyController@update_comp');
    // /update_file
    Route::post('/update_file_akta/{id_prshn}', 'Admin\CompanyController@update_file_akta');
    Route::post('/update_file_ktp/{id_prshn}', 'Admin\CompanyController@update_file_ktp');
    Route::post('/update_file_foto/{id_prshn}', 'Admin\CompanyController@update_file_foto');
    //dropdown
    Route::get('/getKecamatan2/{id}', 'Admin\CompanyController@getKecamatan2');
    Route::get('/getKelurahan2/{id}', 'Admin\CompanyController@getKelurahan2');
    Route::get('/perusahaan/getKecamatan2/{id}', 'Admin\CompanyController@getKecamatan2');
    Route::get('/perusahaan/getKelurahan2/{id}', 'Admin\CompanyController@getKelurahan2');
    //status change
    Route::get('/diproses/{id_prshn}', 'Admin\CompanyController@status_diproses');
    Route::get('/disetujui/{id_prshn}', 'Admin\CompanyController@status_disetujui');
    Route::get('/revisi/{id_prshn}', 'Admin\CompanyController@status_revisi');
    Route::get('/ditolak/{id_prshn}', 'Admin\CompanyController@status_ditolak');
    // laporan
    Route::get('/laporan','LaporanController@index');
    Route::post('/save','LaporanController@simpan_laporan');
    Route::get('/laporan/{id_laporan}', 'LaporanController@detail_laporan');
    Route::delete('/del_laporan/{id_laporan}', 'LaporanController@del_laporan');
    Route::post('/respon_laporan/{id_laporan}', 'LaporanController@respon_laporan');
    // update foto laporan
    Route::post('/update_foto1/{id_laporan}', 'LaporanController@update_foto1');
    Route::post('/update_foto2/{id_laporan}', 'LaporanController@update_foto2');
    //kalo tidak ada perbedaan alamat view dari laporan admin dan warga lebih baik salah satu dihapus saja routingnya
    //pilih salah satu, kalo sudah login routing taruh di dalam jgn taruh di luar route middleware (web.php).
    //pembuatan view boleh bikin folder sendiri sesuai rolenya asal jgn bikin duplikat kalo sudah ada
    //warga
    Route::get('/laporanwarga', 'LaporanWargaController@index');
    Route::post('/savewarga','LaporanWargaController@simpan_laporan');
    Route::get('/laporanwarga/{id_laporan}', 'LaporanWargaController@detail_laporan');
    Route::delete('/del_laporanwarga/{id_laporan}', 'LaporanWargaController@del_laporan');
    Route::post('/update_laporan/{id_laporan}', 'LaporanWargaController@update_laporan');
    Route::post('/updatew_foto1/{id_laporan}', 'LaporanWargaController@updatew_foto1');
    Route::post('/updatew_foto2/{id_laporan}', 'LaporanWargaController@updatew_foto2');

    //proyek
    Route::get('/index_proyek/{id_prshn}','Proyek\ProyekController@index');
    Route::get('/projects','Proyek\ProyekController@all_item');

    Route::get('/add_proyek/{id_prshn}','Proyek\ProyekController@add_proyek');
    Route::get('/add_proyek/getKecamatan3/{id}', 'Proyek\ProyekController@getKecamatan3');
    Route::get('/add_proyek/getKelurahan3/{id}', 'Proyek\ProyekController@getKelurahan3');
    Route::get('/test_alert','Proyek\ProyekController@test_alert')->name('test_alert');
    Route::post('/store_proyek/{id_prshn}','Proyek\ProyekController@store_proyek')->name('store_proyek');
    Route::get('/store_proyek/{id_prshn}','Proyek\ProyekController@store_proyek')->name('store_proyek'); //alternatif
    Route::get('/delete_proyek/{id}', 'Proyek\ProyekController@delete_proyek');
    Route::get('/proyek_info/{id}','Proyek\ProyekController@proyek_info');
    Route::get('/proyek_info/getKecamatan3/{id}', 'Proyek\ProyekController@getKecamatan3');
    Route::get('/proyek_info/getKelurahan3/{id}', 'Proyek\ProyekController@getKelurahan3');

    Route::post('/update_proyek/{id}','Proyek\ProyekController@update_proyek')->name('update_proyek');
    Route::post('/update_siteplan/{id}', 'Proyek\ProyekController@update_siteplan')->name('update_siteplan');
    Route::post('/update_ukl_upl/{id}', 'Proyek\ProyekController@update_ukl_upl')->name('update_ukl_upl');
    Route::post('/update_imb/{id}', 'Proyek\ProyekController@update_imb')->name('update_imb');
    Route::post('/update_ipb/{id}', 'Proyek\ProyekController@update_ipb')->name('update_ipb');
    Route::post('/update_sertifikat_tanah/{id}', 'Proyek\ProyekController@update_sertifikat_tanah')->name('update_sertifikat_tanah');
    Route::post('/update_akta_notaris/{id}', 'Proyek\ProyekController@update_akta_notaris')->name('update_akta_notaris');
    Route::post('/update_sertifikat_psu/{id}', 'Proyek\ProyekController@update_sertifikat_psu')->name('update_sertifikat_psu');
});