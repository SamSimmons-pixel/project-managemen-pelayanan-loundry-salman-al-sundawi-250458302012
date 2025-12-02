<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admindashboard')]
class Customers extends Component
{
    use WithPagination;

    public function render()
    {
        $customers = User::where('role', 'customer')->paginate(10);
        return view('livewire.admin.customers', [
            'customers' => $customers,
        ]);
    }
}
