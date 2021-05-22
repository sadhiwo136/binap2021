<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinates extends Model
{
    protected $table = 'coordinates';
    protected $fillable = ['lat', 'long'];
}
