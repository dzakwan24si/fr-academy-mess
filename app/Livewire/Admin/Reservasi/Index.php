<?php

namespace App\Livewire\Admin\Reservasi;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('RESERVASI KAMAR')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.reservasi.index');
    }
}
