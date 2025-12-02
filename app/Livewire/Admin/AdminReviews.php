<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admindashboard')]
class AdminReviews extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function render()
    {
        $branchAdmins = User::where('role', 'branch_admin')->get()->map(function ($admin) {
            // Get reviews linked to orders managed by this branch admin
            $reviews = Review::whereHas('order', function ($query) use ($admin) {
                $query->where('branch_admin_id', $admin->id);
            })->with(['user', 'order'])->latest()->get();

            $avgRating = $reviews->avg('rating');

            return [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'reviews' => $reviews,
                'average_rating' => $avgRating ? round($avgRating, 1) : 0,
                'review_count' => $reviews->count(),
            ];
        })->sortByDesc('average_rating');

        return view('livewire.admin.admin-reviews', [
            'branchAdmins' => $branchAdmins,
        ]);
    }
}
