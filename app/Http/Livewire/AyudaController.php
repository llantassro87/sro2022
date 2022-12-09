<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AyudaController extends Component
{
    public function render()
    {
        return view('livewire.ayuda')
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
