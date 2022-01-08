<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function index($route){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan', 'report'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/'.$route); 
    }

    // public function show($route, $id){
    //     $list = ['siswa'];
    //     if(!in_array($route, $list)) abort(404);

    //     return view('pages/show-'.$route); 
    // }

    public function create($route, $id){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/form-'.$route); 
    }

    public function edit($route, $id){
        $list = ['siswa', 'guru', 'pelajaran', 'kegiatan'];
        if(!in_array($route, $list)) abort(404);

        return view('pages/form-'.$route); 
    }
}
