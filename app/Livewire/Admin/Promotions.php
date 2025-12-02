<?php

namespace App\Livewire\Admin;

use App\Models\Promo;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.branchadmindashboard')]
class Promotions extends Component
{
    public $code;
    public $discount_percentage;
    public $valid_until;

    public function mount()
    {
        if (Auth::user()->role !== 'branch_admin') {
            abort(403);
        }
    }

    public function render()
    {
        $promos = Promo::where('branch_admin_id', Auth::id())->latest()->get();
        return view('livewire.admin.promotions', [
            'promos' => $promos
        ]);
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|unique:promos,code',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_until' => 'required|date|after:today',
        ]);

        Promo::create([
            'code' => $this->code,
            'discount_percentage' => $this->discount_percentage,
            'valid_until' => $this->valid_until,
            'is_active' => true,
            'branch_admin_id' => Auth::id(),
        ]);

        $this->reset(['code', 'discount_percentage', 'valid_until']);
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        Promo::find($id)->delete();
    }

    public function toggleStatus($id)
    {
        $promo = Promo::find($id);
        $promo->is_active = !$promo->is_active;
        $promo->save();
    }
}
