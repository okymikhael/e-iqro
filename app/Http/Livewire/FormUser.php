<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\User;
use PDO;

class FormUser extends Component
{
    public $nip;
    public $name;
    public $alamat;
    public $email;
    public $password;
    public $old_password;
    public $event;
    public $model = User::class;

    public function render()
    {
        $form_name = "User";
        $fields = [
            'nip' => 'text',
            'name' => 'text',
            'email' => 'email',
            'alamat' => 'textarea',
            'password' => 'password',
        ];

        return view('livewire.forms.scaffold', compact('fields', 'form_name'));
    }

    public function mount(){
        $id = request()->segment(count(request()->segments()));
        $data = $this->model::find($id);
        $this->event = null;

        if($data){
            $this->event = $data;

            $this->nip = $data->nip;
            $this->name = $data->name;
            $this->alamat = $data->alamat;
            $this->email = $data->email;
            $this->old_password = $data->password;
        }
    }

    public function submit()
    {
        $this->validate([
            'nip'   => 'required',
            'alamat'   => 'required',
            'name'   => 'required',
            'email'   => 'required',
        ]);

        if($this->password && $this->old_password != $this->password) 
            $this->password = Hash::make($this->password);

        $data = [
            'nip'  => $this->nip,
            'name'  => $this->name,
            'alamat'  => $this->alamat,
            'email'  => $this->email,
            'password'  => $this->password ? $this->password : $this->old_password,
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
