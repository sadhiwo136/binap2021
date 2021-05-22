<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id_prshn';
    protected $fillable = ['nama_prshn', 'bentuk_prshn', 'nama_owner', 'thn_est', 'alamat', 'lat_prshn', 'long_prshn', 'telepon', 'website', 'email', 'file_akta', 'file_foto', 'file_ktp', 'id_klurahn', 'id_kecamatan', 'id_kota', 'id_user', 'status_prshn'];
}