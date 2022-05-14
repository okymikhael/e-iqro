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
        $m_kasar = AktifitasSiswa::where(['id_siswa' => $user->id, 'group' => 'MOTORIK KASAR'])->distinct()->get();
        // $m_kasar = AktifitasSiswa::where(['id_siswa' => $user->id, 'group' => 'MOTORIK KASAR'])->orderBy('created_at', 'desc')->groupBy('keterangan')->get();
        dd($m_kasar);

        return response()->json(['success' => true, 'data' => $m_kasar]);
    }
}
