<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\AktifitasSiswa;
use App\Models\Kegiatan;
use App\Models\User;
use PDO;

class FormAktifitasSiswa extends Component
{
    use WithFileUploads;

    public $id_siswa;
    public $kegiatan;
    public $keterangan;
    public $tanggal;
    public $field_kegiatan = [];
    public $field_attachment = [];
    public $data_kegiatan;
    public $attachment;
    public $data_attachment = [];
    public $event;
    public $model = AktifitasSiswa::class;

    public function selectKegiatan()
    {
        $kegiatan = Kegiatan::find($this->kegiatan);

        if($kegiatan) {
            if($kegiatan->data){
                if($kegiatan->data[0] == "{"){
                    $this->field_kegiatan[$kegiatan->deskripsi] = json_decode(str_replace("'", '"', $kegiatan->data), true);
                }else{
                    $this->field_kegiatan[$kegiatan->deskripsi] = $kegiatan->data;
                }
            }else{
                $this->field_kegiatan[$kegiatan->deskripsi] = $kegiatan->tipe;
            }
        }
    }

    public function deleteKegiatan($id)
    {
        unset($this->field_kegiatan[$id]);
    }

    public function addAttachment(){
        $count_attachment = count($this->field_attachment);
        $this->field_attachment["attachment_".$count_attachment] = 'file';
    }

    public function deleteAttachment($id){
        if(array_key_exists($id, $this->data_attachment) && Storage::exists($this->data_attachment[$id])) 
            Storage::delete($this->data_attachment[$id]);

        unset($this->field_attachment[$id]);
        unset($this->data_attachment[$id]);
    }

    public function updated($name, $value)
    {
        if(explode(".", $name)[0] == 'attachment'){
            $key = explode(".", $name)[1];
            $this->validate([
                $name => 'max:2048|mimetypes:image/jpeg,image/png,video/avi,video/mpeg,video/mp4,video/3gp,video/x-m4v',
            ]);

            $file = $value->storeAs('assets/aktifitas', $value->getClientOriginalName());
            $this->data_attachment[$key] = $file;
        }
    }

    public function render()
    {
        $form_name = "Aktifitas";
        foreach(Kegiatan::all() as $kegiatans) $kegiatan[$kegiatans->deskripsi] = $kegiatans->id;

        $fields = [
            'keterangan' => 'textarea',
            'tanggal' => 'date',
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
            $json_to_variable = ['attachment', 'kegiatan'];

            foreach($json_to_variable as $variable){
                foreach(json_decode($data->$variable, JSON_UNESCAPED_SLASHES) as $key => $var){
                    $this->$key = $var;
                }
            }

            $this->kegiatan = $data->kegiatan;
            $this->keterangan = $data->keterangan;
            $this->tanggal = $data->tanggal;
        }
    }

    public function submit()
    {
        $this->validate([
            'kegiatan'   => 'required',
            'keterangan'   => 'required',
            'tanggal'   => 'required',
        ]);

        $data = [
            'id_siswa'  => $this->id_siswa,
            'kegiatan'  => json_encode([
                'field_kegiatan' => $this->field_kegiatan,
                'data_kegiatan' => $this->data_kegiatan
            ], JSON_UNESCAPED_SLASHES),
            'keterangan'  => $this->keterangan,
            'tanggal'  => $this->tanggal,
            'attachment'  => json_encode([
                'field_attachment' => $this->field_attachment,
                'data_attachment' => $this->data_attachment
            ], JSON_UNESCAPED_SLASHES)
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
