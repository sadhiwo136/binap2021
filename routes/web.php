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

Route::get('/register', function () {
    return view('admin.users.user-new');
});

Route::group(['middleware' => ['auth', 'admin']], function() {

    Route::get('/dashboard', function() {
        $c1 = User::count();
        
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
    
    //status change
    Route::get('/diproses/{id_prshn}', 'Admin\CompanyController@status_diproses');
    Route::get('/disetujui/{id_prshn}', 'Admin\CompanyController@status_disetujui');
    Route::get('/revisi/{id_prshn}', 'Admin\CompanyController@status_revisi');
    Route::get('/ditolak/{id_prshn}', 'Admin\CompanyController@status_ditolak');
    
});