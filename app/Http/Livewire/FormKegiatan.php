<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kegiatan;
use App\Models\User;
use PDO;

class FormKegiatan extends Component
{
    public $kegiatan;
    public $deskripsi;
    public $tipe;
    public $data;
    public $group;
    public $event;
    public $model = Kegiatan::class;

    public function render()
    {
        $form_name = "Kegiatan";
        $fields = [
            'kegiatan' => 'text',
            'deskripsi' => 'textarea',
            'tipe' => ['select' => ['text' => 'text', 'textarea' => 'textarea', 'number' => 'number', 'time' => 'time', 'radio' => 'radio', 'select' => 'select']],
            'data' => 'textarea',
            'group' => 'text',
        ];

        return view('livewire.forms.scaffold', compact('fields', 'form_name'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->kegiatan = $data->kegiatan;
            $this->deskripsi = $data->deskripsi;
            $this->tipe = $data->tipe;
            $this->data = $data->data;
            $this->group = $data->group;
        }
    }

    public function submit()
    {
        $this->validate([
            'kegiatan'   => 'kegiatan',
            'deskripsi'   => 'deskripsi',
            'tipe'   => 'tipe',
            'data'   => 'data',
            'group'   => 'group',
        ]);

        $data = [
            'kegiatan'  => $this->kegiatan,
            'deskripsi'  => $this->deskripsi,
            'tipe'  => $this->tipe,
            'data'  => $this->data,
            'group'  => $this->group,
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
        return redirect('/kegiatan');
    }
}
