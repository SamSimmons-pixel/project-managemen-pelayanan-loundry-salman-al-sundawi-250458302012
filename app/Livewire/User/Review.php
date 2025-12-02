<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Models\Review as ReviewModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class Review extends Component
{
    public $rating = 0;
    public $comment = '';
    public $selectedOrder = '';

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    #[On('submitReview')]
    public function submitReview()
    {
        $this->validate([
            'selectedOrder' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5',
        ]);

        $order = Order::findOrFail($this->selectedOrder);

        ReviewModel::create([
            'user_id' => Auth::id(),
            'order_id' => $this->selectedOrder,
            'branch_id' => $order->branch_admin_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->dispatch('showSuccess', ['message' => 'Review submitted successfully!']);

        $this->reset(['rating', 'comment', 'selectedOrder']);
    }


    #[Layout('layouts.userdashboard', ['title' => 'Reviews'])]
    public function render()
    {
        $orders = Order::where('user_id', auth()->guard('web')->user()->id)
            ->where('status', 'Completed')
            ->get();
        return view('livewire.user.review', [
            'orders' => $orders,
        ]);
    }
}
