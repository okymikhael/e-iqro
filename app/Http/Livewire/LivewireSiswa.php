<?php

namespace App\Http\Livewire;

use App\Models\Siswa;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewireSiswa extends LivewireDatatable
{
    // public $status;
    public $model = Siswa::class;

    public function columns()
    {
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::name('nama_lengkap')->label('Nama Lengkap')->searchable(),
            Column::name('nama_ibu')->label('Nama Ibu')->searchable(),
            Column::callback(['jenis_kelamin'], function ($jenis_kelamin) {
                return $jenis_kelamin == 'm' ? 'Laki Laki' : 'Perempuan';
            })->label('Jenis Kelamin')->unsortable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.actions.actions-show-edit-delete', ['id' => $id]);
            })->label('Action')->unsortable()
        ];
    }
}
