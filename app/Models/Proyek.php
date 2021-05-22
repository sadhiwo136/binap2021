<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';
    protected $primaryKey = 'id';
    protected $fillable = ['lokasi','longitude_loc','latitude_loc','id_klurahn','id_kecamatan','id_kota','luas_area','jml_unit','jenis_produk','tgl_entri','tgl_mulai','tgl_target','siteplan','ukl_upl','imb','ipb','sertifikat_tanah','akta_notaris','id_prshn','status_thp_terakhir','tgl_thp_terakhir','last_modified','sertifikat_psu'];

    public $timestamps = false;
}
