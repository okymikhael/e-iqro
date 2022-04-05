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
    public $field_kegiatan = [];
    public $event;
    public $model = AktifitasSiswa::class;

    public function selectKegiatan()
    {
        $kegiatan = Kegiatan::find($this->kegiatan);
        if($kegiatan) $this->field_kegiatan[$kegiatan->deskripsi] = $kegiatan->data ? $kegiatan->data : $kegiatan->tipe;
    }

    public function deleteKegiatan($id)
    {
        unset($this->field_kegiatan[$id]);
    }

    public function render()
    {
        $form_name = "Aktifitas";
        foreach(Kegiatan::all() as $kegiatans) $kegiatan[$kegiatans->deskripsi] = $kegiatans->id;

        $fields = [
            'keterangan' => 'textarea',
            'tanggal' => 'date',
            'attachment' => 'file',
            'Tambah Dokumen' => ['button' => ['green'], 'id' => 'tambah_dokumen'], // sementara
            'kegiatan' => ['select' => $kegiatan, 'id' => 'select_kegiatan'],
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
            $this->nilai = $data->nilai;
        }
    }

    public function submit()
    {
        dd(request()->all());
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
