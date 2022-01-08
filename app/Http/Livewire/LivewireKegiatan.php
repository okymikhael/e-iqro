<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewireKegiatan extends LivewireDatatable
{
    // public $status;
    public $model = Kegiatan::class;

    public function columns()
    {
        // dd(request()->getRequestUri());
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::name('kegiatan')->label('kegiatan')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.actions.actions-edit-delete', ['id' => $id]);
            })->label('Action')->unsortable()
        ];
    }
}
