<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class UserMenu extends Component
{
    #[Layout('layouts.userdashboard', ['title' => 'User Menu'])]
    public function render()
    {
        
        return view('livewire.user.user-menu');
    }
}
