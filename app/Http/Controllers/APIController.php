<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kegiatan;
use App\Models\Pelajaran;

class APIController extends Controller
{
    public function index(){
        $host = request()->getHttpHost().'/v1';
        $data = [
            'user' => "$host/user",
            'guru' => "$host/guru",
            'siswa' => "$host/siswa",
            'kegiatan' => "$host/kegiatan",
            'pelajaran' => "$host/pelajaran",
        ];

        return response()->json(['success' => true, 'data' => $data]);
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
        $data = Siswa::paginate(10);

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
}
