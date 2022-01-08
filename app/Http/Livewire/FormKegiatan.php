<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kegiatan;
use App\Models\User;
use PDO;

class FormKegiatan extends Component
{
    public $kegiatan;
    public $event;
    public $model = Kegiatan::class;

    public function render()
    {
        $fields = [
            'kegiatan' => 'text',
        ];

        return view('livewire.forms.scaffold', compact('fields'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->kegiatan = $data->kegiatan;
        }
    }

    public function submit()
    {
        $this->validate([
            'kegiatan'   => 'required',
        ]);

        $data = [
            'kegiatan'  => $this->kegiatan,
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
