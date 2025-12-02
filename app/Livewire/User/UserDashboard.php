<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.userdashboard', ['title' => 'User Dashboard'])]
class UserDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $orders = $user->orders()->latest()->get();
        $totalSpent = $user->orders()->where('status', 'completed')->sum('price');
        $averageRating = $user->reviews()->avg('rating') ?? 0;

        return view('livewire.user.user-menu', compact('user', 'orders', 'totalSpent', 'averageRating'));
    }


}
