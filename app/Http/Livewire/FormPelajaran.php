<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pelajaran;
use App\Models\User;
use PDO;

class FormPelajaran extends Component
{
    public $Pelajaran;
    public $event;
    public $model = Pelajaran::class;

    public function render()
    {
        $fields = [
            'pelajaran' => 'text',
        ];

        return view('livewire.forms.scaffold', compact('fields'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->pelajaran = $data->pelajaran;
        }
    }

    public function submit()
    {
        $this->validate([
            'pelajaran'   => 'required',
        ]);

        $data = [
            'pelajaran'  => $this->pelajaran,
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
        return redirect('/Pelajaran');
    }
}
