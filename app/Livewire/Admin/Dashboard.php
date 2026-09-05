<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Reservasi;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $reservations = Reservasi::with(['tamu', 'kamar'])
            ->whereIn('status', ['Menunggu', 'Checked-in'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact('reservations'));
    }

    public function create()
    {
        // Placeholder untuk '+ Tambah Data'
    }

    public function view($id)
    {
        // Placeholder untuk 'View'
    }

    public function edit($id)
    {
        // Placeholder untuk 'Edit'
    }

    public function delete($id)
    {
        // Placeholder untuk 'Delete'
    }
}
