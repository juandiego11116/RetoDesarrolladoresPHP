<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Select2Dropdown extends Component
{
    public $ottDocument = '';

    public $document_type = [
        'TI',
        'CC',
        'PassPort',
    ];
    public function render()
    {
        return view('livewire.select2-dropdown');
    }
}
