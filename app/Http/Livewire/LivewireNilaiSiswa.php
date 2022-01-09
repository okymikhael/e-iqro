<?php

namespace App\Http\Livewire;

use App\Models\NilaiSiswa;
use App\Models\Pelajaran;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewireNilaiSiswa extends LivewireDatatable
{
    public $model = NilaiSiswa::class;

    public function builder()
    {
        return NilaiSiswa::query()->where('id_siswa', \Request::segment(3));
    }

    public function columns()
    {
        // dd(request()->getRequestUri());
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::callback(['id_pelajaran'], function ($id_pelajaran) {
                return Pelajaran::find($id_pelajaran)->pelajaran;
            })->label('Pelajaran')->unsortable(),
            Column::name('nilai')->label('Nilai')->searchable(),
            Column::name('tanggal')->label('tanggal')->searchable(),

            Column::callback(['id', 'id_siswa'], function ($id, $id_siswa) {
                return view('livewire.actions.actions-edit-delete-from-show', ['id' => $id, 'id_from_show' => $id_siswa, 'route' => 'siswa', 'table' => 'nilai']);
            })->label('Action')->unsortable()
        ];
    }
}
