<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kegiatan;
use App\Models\Pelajaran;
use App\Models\MeetOnline;
use App\Models\AktifitasSiswa;

class APIController extends Controller
{
    public function index(){
        $host = request()->getSchemeAndHttpHost().'/api/v1';
        $data = [
            'meet' => "$host/meet",
            'user' => "$host/user",
            'siswa' => "$host/siswa",
            'kegiatan' => "$host/kegiatan",
            'motorik' => "$host/motorik",
            'spider_chart' => "$host/spider_chart",
        ];

        return response()->json(['success' => true, 'data' => $data])->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }

    public function user(){
        $data = User::paginate(10);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function guru(){
        $data = Guru::paginate(10);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function siswa(){
        $data = Siswa::orderBy('created_at', 'desc');
        $req = request()->all();
        foreach($req as $key => $value)
            $data = $data->where($key, $value);

        $data = $data->paginate(10);


        return response()->json(['success' => true, 'data' => $data]);
    }

    public function kegiatan(){
        $data = Kegiatan::paginate(10);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function pelajaran(){
        $data = Pelajaran::paginate(10);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function motorik(){
        $user = request()->user();
        $data = AktifitasSiswa::where('id_siswa', $user->id);
        $req = request()->all();
        foreach($req as $key => $value)
            $data = $data->where($key, $value);

        $data = $data->paginate(10);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function meet(){
        $data = MeetOnline::find(1);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function spider_chart(){
        $user = request()->user();
        $data = AktifitasSiswa::where(['id_siswa' => $user->id])->limit(2)->orderBy('tanggal', 'DESC')->get();
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
        foreach($latest as $k => $v){
            $find = Kegiatan::where(['deskripsi' => $k])->first();
            if($find['group'] == 'MOTORIK KASAR'){
                $spider_latest['motorik_kasar'][$find['kegiatan']] = ['value' => $v, 'description' => $k];
            }else if($find['group'] == 'MOTORIK HALUS'){
                $spider_latest['motorik_halus'][$find['kegiatan']] = ['value' => $v, 'description' => $k];
            }
        }
        
        foreach($before as $k => $v){
            $find = Kegiatan::where(['deskripsi' => $k])->first();
            if($find['group'] == 'MOTORIK KASAR'){
                $spider_before['motorik_kasar'][$find['kegiatan']] = ['value' => $v, 'description' => $k];
            }else if($find['group'] == 'MOTORIK HALUS'){
                $spider_before['motorik_halus'][$find['kegiatan']] = ['value' => $v, 'description' => $k];
            }
        }

        $spider = [
            'spider_latest' => $spider_latest,
            'spider_before' => $spider_before,
        ];

        return response()->json(['success' => true, 'data' => $spider]);
    }
}
