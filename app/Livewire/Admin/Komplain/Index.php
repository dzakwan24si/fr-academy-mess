<?php

namespace App\Livewire\Admin\Komplain;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('KOMPLAIN FASILITAS')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.komplain.index');
    }
}
