<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.admindashboard')]
class ServicePackages extends Component
{
    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public $selectedPackageId;
    public $name;
    public $description;
    public $price_per_kg;
    public $status;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'price_per_kg' => 'required|numeric',
        'status' => 'required|in:Active,Unactive',
    ];

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price_per_kg = '';
        $this->status = 'Active';
        $this->selectedPackageId = null;
    }



    public function store()
    {
        $this->validate();

        \App\Models\ServicePackage::create([
            'name' => $this->name,
            'description' => $this->description,
            'price_per_kg' => $this->price_per_kg,
            'status' => $this->status,
        ]);

        $this->dispatch('close-create-modal');
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => 'New service package created successfully.',
        ]);

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $package = \App\Models\ServicePackage::findOrFail($id);
        $this->selectedPackageId = $package->id;
        $this->name = $package->name;
        $this->description = $package->description;
        $this->price_per_kg = $package->price_per_kg;
        $this->status = $package->status;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        $package = \App\Models\ServicePackage::findOrFail($this->selectedPackageId);
        $package->update([
            'name' => $this->name,
            'description' => $this->description,
            'price_per_kg' => $this->price_per_kg,
            'status' => $this->status,
        ]);

        $this->dispatch('close-edit-modal');
        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text' => 'Service package updated successfully.',
        ]);
    }



    public function delete($id)
    {
        \App\Models\ServicePackage::findOrFail($id)->delete();
        $this->dispatch('swal:success', [
            'title' => 'Deleted!',
            'text' => 'Service package has been deleted.',
        ]);
    }

    public function render()
    {
        $packages = \App\Models\ServicePackage::all();
        return view('livewire.admin.service-packages', compact('packages'));
    }
}
