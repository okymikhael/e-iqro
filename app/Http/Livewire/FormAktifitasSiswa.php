<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AktifitasSiswa;
use App\Models\Kegiatan;
use App\Models\User;
use PDO;

class FormAktifitasSiswa extends Component
{
    public $id_siswa;
    public $kegiatan;
    public $keterangan;
    public $tanggal;
    public $attachment;
    public $event;
    public $model = AktifitasSiswa::class;

    public function render()
    {
        $kegiatan = [];
        foreach(Kegiatan::all() as $kegiatans) $kegiatan[$kegiatans->deskripsi] = $kegiatans->id;

        $fields = [
            'kegiatan' => ['select' => $kegiatan],
            'hasil' => 'text', // sementara
            'Tambah Kegiatan' => ['button' => ['green']], // sementara
            'Hapus Kegiatan' => ['button' => ['red']], // sementara
            'keterangan' => 'textarea',
            'tanggal' => 'date',
            'attachment' => 'file',
            'Tambah Dokumen' => ['button' => ['green']], // sementara
        ];

        return view('livewire.forms.scaffold', compact('fields'));
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
            $this->nilai = $data->nilai;
        }
    }

    public function submit()
    {
        $this->validate([
            'kegiatan'   => 'required',
            'keterangan'   => 'required',
            'tanggal'   => 'required',
            'attachment'   => 'required',
        ]);

        $kegiatan = [
            [
                'id_kegiatan' => '1',
                'value' => '0'
            ],
            [
                'id_kegiatan' => '2',
                'value' => 'SM'
            ],
        ];

        $data = [
            'id_siswa'  => $this->id_siswa,
            'kegiatan'  => $kegiatan,
            'keterangan'  => $this->tanggal,
            'tanggal'  => $this->nilai,
            'attachment'  => $this->nilai,
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
