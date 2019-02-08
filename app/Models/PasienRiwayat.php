<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasienRiwayat extends Model
{
    use SoftDeletes;

	protected $table = 'riwayat_pasien';

    public function pasien()
    {
    	return $this->hasOne('App\Models\Pasien','pasien_id','id');
    }
}
