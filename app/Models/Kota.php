<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';
    protected $fillable = ['nama', 'id_provinsi'];
    protected $searchableColumns = ['nama'];
}