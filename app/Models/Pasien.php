<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
	use SoftDeletes;

	protected $table = 'pasien';

    public function riwayat()
    {
    	return $this->hasMany('App\Models\PasienRiwayat','pasien_id');
    }

    public function jenjang()
    {
    	return $this->hasOne('App\Models\Jenjang','id','jenjang_id');
    }
}
