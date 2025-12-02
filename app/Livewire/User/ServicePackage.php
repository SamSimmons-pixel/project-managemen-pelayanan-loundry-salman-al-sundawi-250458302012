<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ServicePackage extends Component
{
    #[Layout('layouts.userdashboard', ['title' => 'Service Packages'])]
    public function render()
    {
        return view('livewire.user.service-package');
    }
}
