<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\NilaiSiswa;
use App\Models\Pelajaran;
use App\Models\User;
use PDO;

class FormNilaiSiswa extends Component
{
    public $id_siswa;
    public $pelajaran;
    public $tanggal;
    public $nilai;
    public $event;
    public $model = NilaiSiswa::class;

    public function render()
    {
        $form_name = "Nilai";
        $pelajaran = [];
        foreach(Pelajaran::all() as $pelajarans) $pelajaran[$pelajarans->pelajaran] = $pelajarans->id;

        $fields = [
            'pelajaran' => ['select' => $pelajaran],
            'tanggal' => 'date',
            'nilai' => 'number',
        ];

        return view('livewire.forms.scaffold', compact('fields', 'form_name'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;
        $this->id_siswa = \Request::segment(3);

        if($data){
            $this->event = $data;

            $this->pelajaran = $data->id_pelajaran;
            $this->tanggal = $data->tanggal;
            $this->nilai = $data->nilai;
        }
    }

    public function submit()
    {
        $this->validate([
            'pelajaran'   => 'required',
            'tanggal'   => 'required',
            'nilai'   => 'required',
        ]);

        $data = [
            'id_siswa'  => $this->id_siswa,
            'id_pelajaran'  => $this->pelajaran,
            'tanggal'  => $this->tanggal,
            'nilai'  => $this->nilai,
        ];

        if($this->event){
            $this->model::find($this->event->id)->update($data);
        }else{
            $this->model::create($data);
        }

        //flash message
        session()->flash('message', 'Data Berhasil Disimpan.');

        $this->dispatchBrowserEvent('swal', [
            'title' => "created",
            'text'  => "usercreated",
            'icon'  => 'success',
            'timer' => 3000
        ]);

        //redirect
        return redirect('/siswa/detail/'.$this->id_siswa);
    }
}
