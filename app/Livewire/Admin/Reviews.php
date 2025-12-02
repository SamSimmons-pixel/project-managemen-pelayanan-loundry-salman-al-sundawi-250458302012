<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.branchadmindashboard')]
class Reviews extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'branch_admin') {
            abort(403);
        }
    }
    public function render()
    {
        $branchAdmins = User::where('role', 'branch_admin')->get()->map(function ($admin) {
            $reviews = Review::whereHas('order', function ($query) use ($admin) {
                $query->where('branch_admin_id', $admin->id);
            })->with(['user', 'order'])->latest()->get();

            return [
                'admin' => $admin,
                'reviews' => $reviews,
            ];
        });

        return view('livewire.admin.reviews', [
            'branchAdmins' => $branchAdmins,
        ]);
    }
}
