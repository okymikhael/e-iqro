<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Guru;
use App\Models\User;
use PDO;

class FormGuru extends Component
{
    public $nip;
    public $nama_guru;
    public $alamat;
    public $event;
    public $model = Guru::class;

    public function render()
    {
        $fields = [
            'nip' => 'text',
            'nama_guru' => 'text',
            'alamat' => 'textarea',
        ];

        return view('livewire.forms.scaffold', compact('fields'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->nip = $data->nip;
            $this->nama_guru = $data->nama_guru;
            $this->alamat = $data->alamat;
        }
    }

    public function submit()
    {
        $this->validate([
            'nip'   => 'required',
            'nama_guru'   => 'required',
            'alamat'   => 'required',
        ]);

        $data = [
            'nip'  => $this->nip,
            'nama_guru'  => $this->nama_guru,
            'alamat'  => $this->alamat,
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
        return redirect('/guru');
    }
}
