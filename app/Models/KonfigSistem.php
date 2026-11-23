<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfigSistem extends Model
{
    protected $table = 'konfig_sistem';
    protected $primaryKey = 'id_konfig';
    protected $fillable = ['nm_konfig', 'nilai', 'deskripsi'];
}
