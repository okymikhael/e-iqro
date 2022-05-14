<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kegiatan;
use App\Models\MeetOnline;
use App\Models\AktifitasSiswa;

class RouterController extends Controller
{
    public function login(){
        if(request()->user())
            return redirect('/');

        return view('pages/login');
    }

    public function logout(){
        if(request()->user()->currentAccessToken())
            request()->user()->currentAccessToken()->delete();
        
        if(request()->session())
            request()->session()->flush();

        return redirect('/');
    }

    public function dashboard(){
        $meet = MeetOnline::find(1);

        return view('pages/dashboard', compact('meet'));
    }

    public function meet_online(){
        $meet = MeetOnline::find(1);
        if(!$meet) $meet = new MeetOnline();

        $meet->link = request('link');
        $meet->tanggal = request('tanggal');
        $meet->provider = request('provider');
        $meet->save();

        return redirect('/');
    }

    public function index($route){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan', 'user', 'report', 'login'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/'.$route); 
    }

    public function show($route, $id){
        $list = ['siswa'];
        if(!in_array($route, $list)) abort(404);
        
        $siswa = Siswa::find($id);

        // only for siswa
        $data = AktifitasSiswa::where(['id_siswa' => $siswa->id])->limit(2)->orderBy('tanggal', 'DESC')->get();
        $latest = json_decode($data[0]['kegiatan'], true)['data_kegiatan'];
        $before = json_decode($data[1]['kegiatan'], true)['data_kegiatan'];

        // matching each array
        $temp_1 = [];
        $most_data = count($latest) > count($before) ? 'latest' : 'before';
        $less_data = $most_data == 'before' ? 'latest' : 'before';
        foreach($$most_data as $key => $val){
            $temp_1[$key] = array_key_exists($key, $$less_data) ? $$less_data[$key] : 0;
        }
        $diff_for_less=array_diff_key($$less_data,$$most_data);
        foreach($diff_for_less as $key => $val){
            $temp_1[$key] = array_key_exists($key, $$less_data) ? $$less_data[$key] : 0;
        }

        $temp_2 = [];
        $most_data_2 = $most_data == 'before' ? 'latest' : 'before';
        $less_data_2 = $most_data_2 == 'before' ? 'latest' : 'before';
        foreach($temp_1 as $key => $val){
            $temp_2[$key] = array_key_exists($key, $$less_data_2) ? $$less_data_2[$key] : 0;
        }
        $$less_data = $temp_1;
        $$most_data = $temp_2;


        // Find motorik kasar dan halus
        $spider_latest = [];
        $spider_before = [];
        $spider_kasar = [];
        $spider_halus = [];
        foreach($latest as $k => $v){
            $find = Kegiatan::where(['deskripsi' => $k])->first();
            if($find['group'] == 'MOTORIK KASAR'){
                $spider_latest['motorik_kasar'][$find['kegiatan']] = (int)$v;
                array_push($spider_kasar, $find['kegiatan']);
            }else if($find['group'] == 'MOTORIK HALUS'){
                $spider_latest['motorik_halus'][$find['kegiatan']] = (int)$v;
                array_push($spider_halus, $find['kegiatan']);
            }
        }
        
        foreach($before as $k => $v){
            $find = Kegiatan::where(['deskripsi' => $k])->first();
            if($find['group'] == 'MOTORIK KASAR'){
                $spider_before['motorik_kasar'][$find['kegiatan']] = (int)$v;
            }else if($find['group'] == 'MOTORIK HALUS'){
                $spider_before['motorik_halus'][$find['kegiatan']] = (int)$v;
            }
        }

        $spider = [
            'spider_latest' => $spider_latest,
            'spider_before' => $spider_before,
            'spider_kasar' => $spider_kasar,
            'spider_halus' => $spider_halus,
        ];
        
        return view('pages/show-'.$route)->with(['siswa' => $siswa, 'spider' => $spider]); 
    }

    public function create($route, $id){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan', 'user'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/form-'.$route); 
    }

    public function create_from_show($route, $id, $table){
        $list = ['aktifitas', 'nilai'];
        if(!in_array($table, $list)) abort(404);

        return view('pages/form-'.$table); 
    }

    public function edit($route, $id){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan', 'user'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/form-'.$route); 
    }

    public function edit_from_show($route, $id_from_show, $table, $id){
        $list = ['aktifitas', 'nilai'];
        if(!in_array($table, $list)) abort(404);

        return view('pages/form-'.$table); 
    }
}
