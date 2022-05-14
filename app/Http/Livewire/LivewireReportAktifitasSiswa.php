<?php

namespace App\Http\Livewire;

use App\Models\AktifitasSiswa;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewireReportAktifitasSiswa extends LivewireDatatable
{
    // public $status;
    public $model = AktifitasSiswa::class;

    public function builder()
    {
        return AktifitasSiswa::query()->orderBy('created_at', 'desc');
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::name('keterangan')->label('keterangan')->searchable(),
            Column::name('tanggal')->label('Tanggal')->searchable(),

            Column::callback(['id', 'id_siswa'], function ($id, $id_siswa) {
                return view('livewire.actions.actions-edit-delete-from-show', ['id' => $id, 'id_from_show' => $id_siswa, 'route' => 'siswa', 'table' => 'aktifitas']);
            })->label('Action')->unsortable()
        ];
    }
}
