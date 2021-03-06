<?php

namespace App\Http\Livewire;

use App\Models\Pelajaran;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewirePelajaran extends LivewireDatatable
{
    // public $status;
    public $model = Pelajaran::class;

    public function columns()
    {
        // dd(request()->getRequestUri());
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::name('pelajaran')->label('Pelajaran')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.actions.actions-edit', ['id' => $id, 'route' => 'pelajaran']);
            })->label('Action')->unsortable()
        ];
    }
}
