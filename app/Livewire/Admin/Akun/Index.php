<?php

namespace App\Livewire\Admin\Akun;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('MANAJEMEN AKUN')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.akun.index');
    }
}
