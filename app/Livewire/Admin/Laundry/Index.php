<?php

namespace App\Livewire\Admin\Laundry;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('MANAJEMEN LAUNDRY')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.laundry.index');
    }
}
