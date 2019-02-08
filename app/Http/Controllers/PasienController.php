<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pasien;
use App\Models\PasienRiwayat;

use Auth;
use DB;

class PasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tambah()
    {
    	return view('pages.tambah');
    }

    public function edit($id)
    {
    	$pasien = Pasien::with(['riwayat'])->find($id);
    	return view('pages.edit',compact('pasien'));
    }

    public function proses(Request $request)
    {
    	$id = $request->get('id',null);
    	if($id){
    		$pasien = Pasien::find($id);
    	}else{
    		$rekam = Pasien::where('no_rekam_medis',$request->no_rekam_medis)->first();
    		if($rekam){
    			return response()->json(['success' => false,'message' => 'No Rekam Medis Sudah Digunakan']);
    		}

    		$pasien = new Pasien;
    	}

    	DB::beginTransaction();
    	$pasien->no_rekam_medis = $request->no_rekam_medis;
    	$pasien->nama = $request->nama;
    	$pasien->tanggal_lahir = $request->tanggal_lahir;
    	$pasien->alamat = $request->alamat;
    	$pasien->kontak = $request->kontak;
    	$pasien->jenis_kelamin = $request->jenis_kelamin;
    	$pasien->gol_darah = $request->gol_darah;
    	$pasien->save();

    	$riwayat = $request->get('riwayat',[]);
    	$del = PasienRiwayat::where('pasien_id',$pasien->id)->delete();
    	foreach ($riwayat as $rw) {
    		$riw = new PasienRiwayat;
    		$riw->pasien_id = $pasien->id;
    		$riw->diagnosa_sakit = $rw['diagnosa_sakit'];
    		$riw->tanggal_dirawat = $rw['tanggal_dirawat'];
    		$riw->lama_rawat = $rw['lama_rawat'];
    		$riw->tindakan = $rw['tindakan'];
    		$riw->obat = $rw['obat'];
    		$riw->save();
    	}	
    	DB::commit();

    	return response()->json(['success' => true,'message' => 'Berhasil']);
    }

    public function data()
    {
    	return view('pages.data');
    }

    public function getData(Request $request)
    {
	    $models = Pasien::with(['riwayat'])->leftJoin(DB::raw('(SELECT count(*) as jumlah,pasien_id FROM riwayat_pasien WHERE deleted_at IS NULL GROUP BY pasien_id) as b'),'b.pasien_id','=','pasien.id');
        $params = $request->get('params', false);
        $order  = $request->get('order', false);

        if ($params) {
            foreach ($params as $key => $val) {
                if ($val == '') continue;
                switch ($key) {
                    default:
                        $models = $models->where($key, $val);
                        break;
                }
            }
        }

        $count = $models->count();

        $search = $request->get('search',false);
        if($search){
        	$models = $models->where(function($q) use ($search){
        		$q->where('nama','like',"%$search%")
        		  ->orWhere('no_rekam_medis','like',"%$search%");
        	});
        }

        if ($order) {
            $order_direction = $request->get('order_direction', 'asc');
            if (empty($order_direction)) $order_direction = 'asc';

            switch ($order) {
                default:
                    $models = $models->orderBy($order, $order_direction);
                    break;
            }
        }

        $page    = $request->get('page', 1);
        $perpage = $request->get('perpage', 20);

        $models = $models->skip(($page - 1) * $perpage)->take($perpage)->get();
        foreach ($models as &$model) {
        }

        $result = [
            'data'  => $models,
            'count' => $count
        ];

        return response()->json($result);
    }

    public function hapus(Request $request)
    {
    	$id = $request->id;
    	$pasien = Pasien::find($id);
    	if(!$pasien){
    		return response()->json(['success' => false,'message' => 'Data Tidak Ditemukan']);
    	}

    	$pasien->delete();
    	return response()->json(['success' => true,'Berhasil']);
    }

    public function hapusRiwayat(Request $request)
    {
    	$id = $request->id;
    	$riwayat = PasienRiwayat::find($id);
    	if(!$riwayat){
    		return response()->json(['success' => false,'message' => 'Data Tidak Ditemukan']);
    	}

    	$riwayat->delete();
    	return response()->json(['success' => true,'Berhasil']);
    }
}
