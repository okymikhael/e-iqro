<?php

namespace App\Http\Livewire;

use App\Models\AktifitasSiswa;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewireAktifitasSiswa extends LivewireDatatable
{
    // public $status;
    public $model = AktifitasSiswa::class;

    public function builder()
    {
        return AktifitasSiswa::query()->where('id_siswa', \Request::segment(3));
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::name('kegiatan')->label('Kegiatan')->searchable(),
            Column::name('tanggal')->label('Tanggal')->searchable(),

            Column::callback(['id', 'id_siswa'], function ($id, $id_siswa) {
                return view('livewire.actions.actions-edit-delete-from-show', ['id' => $id, 'id_from_show' => $id_siswa, 'route' => 'siswa', 'table' => 'aktifitas']);
            })->label('Action')->unsortable()
        ];
    }
}
