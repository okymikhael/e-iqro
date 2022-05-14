<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LivewireUser extends LivewireDatatable
{
    // public $status;
    public $model = User::class;

    public function columns()
    {
        // dd(request()->getRequestUri());
        return [
            NumberColumn::name('id')->label('ID')->sortBy('id')->defaultSort('asc'),
            Column::name('nip')->label('NIP')->searchable(),
            Column::name('name')->label('Nama')->searchable(),
            Column::name('email')->label('Email')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.actions.actions-edit', ['id' => $id, 'route' => 'user']);
            })->label('Action')->unsortable()
        ];
    }
}
