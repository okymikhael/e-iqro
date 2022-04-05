<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use PDO;

class FormUser extends Component
{
    public $name;
    public $email;
    public $password;
    public $role;
    public $event;
    public $model = User::class;

    public function render()
    {
        $form_name = "User";
        $fields = [
            'name' => 'text',
            'email' => 'email',
            'password' => 'password',
            // 'role' => ['select' => ['Guru' => 'guru', 'Siswa' => 'siswa']],
        ];

        return view('livewire.forms.scaffold', compact('fields', 'form_name'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->name = $data->name;
            $this->email = $data->email;
            $this->password = $data->password;
        }
    }

    public function submit()
    {
        $this->validate([
            'name'   => 'required',
            'email'   => 'required',
            'password'   => 'required',
        ]);

        $data = [
            'name'  => $this->name,
            'email'  => $this->email,
            'password'  => $this->password,
            'role'  => $this->role,
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
        return redirect('/user');
    }
}
