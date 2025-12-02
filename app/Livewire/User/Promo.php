<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Promo extends Component
{
    #[Layout('layouts.userdashboard', ['title' => 'Promos'])]
    public function render()
    {
        $promos = \App\Models\Promo::with('branchAdmin')->where('is_active', true)->where('valid_until', '>=', now())->get();
        return view('livewire.user.promo', [
            'promos' => $promos
        ]);
    }
}
