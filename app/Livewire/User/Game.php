<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.userdashboard', ['title' => 'Game'])]
class Game extends Component
{
    public function render()
    {
        return view('livewire.user.game');
    }
}
