<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\User;
use PDO;

class FormSiswa extends Component
{
    public $nama_lengkap;
    public $nama_panggilan;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $nama_ayah;
    public $telp_ayah;
    public $nama_ibu;
    public $telp_ibu;
    public $active;
    public $event;
    public $model = Siswa::class;

    public function render()
    {
        $fields = [
            'nama_lengkap' => 'text',
            'nama_panggilan' => 'text',
            'tempat_lahir' => 'text',
            'tanggal_lahir' => 'text',
            'jenis_kelamin' => 'text',
            'alamat' => 'textarea',
            'nama_ayah' => 'text',
            'telp_ayah' => 'text',
            'nama_ibu' => 'text',
            'telp_ibu' => 'text',
            'active' => ['Aktif' => 1, 'Tidak Aktif' => 0],
        ];

        return view('livewire.forms.scaffold', compact('fields'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->nama_lengkap = $data->nama_lengkap;
            $this->nama_panggilan = $data->nama_panggilan;
            $this->tempat_lahir = $data->tempat_lahir;
            $this->tanggal_lahir = $data->tanggal_lahir;
            $this->jenis_kelamin = $data->jenis_kelamin;
            $this->alamat = $data->alamat;
            $this->nama_ayah = $data->nama_ayah;
            $this->telp_ayah = $data->telp_ayah;
            $this->nama_ibu = $data->nama_ibu;
            $this->telp_ibu = $data->telp_ibu;
            $this->active = $data->active;
        }
    }

    public function submit()
    {
        $this->validate([
            'nama_lengkap'   => 'required',
            'nama_panggilan'   => 'required',
            'tempat_lahir'   => 'required',
            'tanggal_lahir'   => 'required',
            'jenis_kelamin'   => 'required',
            'alamat'   => 'required',
            'nama_ayah'   => 'required',
            'telp_ayah'   => 'required',
            'nama_ibu'   => 'required',
            'telp_ibu'   => 'required',
        ]);

        $data = [
            'nama_lengkap'  => $this->nama_lengkap,
            'nama_panggilan'  => $this->nama_panggilan,
            'tempat_lahir'  => $this->tempat_lahir,
            'tanggal_lahir'  => $this->tanggal_lahir,
            'jenis_kelamin'  => $this->jenis_kelamin,
            'alamat'  => $this->alamat,
            'nama_ayah'  => $this->nama_ayah,
            'telp_ayah'  => $this->telp_ayah,
            'nama_ibu'  => $this->nama_ibu,
            'telp_ibu'  => $this->telp_ibu,
            'active'  => $this->active,
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
        return redirect('/siswa');
    }
}
