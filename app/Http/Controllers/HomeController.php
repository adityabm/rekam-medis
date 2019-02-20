<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Jenjang;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $total = Jenjang::leftJoin(DB::raw('(SELECT count(*) as jumlah,jenjang_id FROM pasien WHERE deleted_at IS NULL GROUP BY jenjang_id) as b'),'b.jenjang_id','=','jenjang.id')->get();

        $other = Pasien::whereNull('jenjang_id')->count();

        return view('home',compact('total','other'));
    }
}
