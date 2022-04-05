<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class RouterController extends Controller
{
    public function index($route){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan', 'user', 'report', 'login'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/'.$route); 
    }

    public function show($route, $id){
        $list = ['siswa'];
        if(!in_array($route, $list)) abort(404);
        
        $siswa = Siswa::find($id);

        return view('pages/show-'.$route)->with(['siswa' => $siswa]); 
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
