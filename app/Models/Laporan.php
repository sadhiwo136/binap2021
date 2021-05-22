<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    protected $fillable = ['deskripsi', 'foto1', 'foto2', 'id_pelapor', 'tanggal_laporan', 'status_terakhir', 'SKPD_terakhir', 'jawaban_SKPD', 'feedback_pelapor', 'tanggal_status_terakhir'];
}
