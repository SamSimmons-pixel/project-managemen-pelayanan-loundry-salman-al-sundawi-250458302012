<?php

namespace App\Livewire\Admin;

use App\Models\Machine;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.branchadmindashboard')]
class MachineRental extends Component
{
    public $location = '';
    public $availability = '';
    public $selectedMachine;
    public $sortField = 'machine_id';
    public $sortDirection = 'asc';
    

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function editMachine($machineId)
    {
        $this->selectedMachine = Machine::find($machineId);
        $this->availability = $this->selectedMachine->availability;
        $this->dispatch('openEditModal');
    }

    public function updateMachine()
    {
        $this->validate(['availability' => 'required']);

        if ($this->selectedMachine) {
            $this->selectedMachine->update(['availability' => $this->availability]);
            session()->flash('message', 'Machine successfully updated.');
            $this->closeEditModal();
        }
    }

    public function deleteMachine()
    {
        if ($this->selectedMachine) {
            $this->selectedMachine->delete();
            session()->flash('message', 'Machine successfully deleted.');
            $this->closeEditModal();
        }
    }

    public function resetMachine()
    {
        if ($this->selectedMachine) {
            $this->selectedMachine->update([
                'status' => 'available',
                'payment_status' => 'unpaid',
            ]);
            session()->flash('message', 'Machine successfully reset.');
            $this->closeEditModal();
        }
    }

    public function finishMachine($machineId = null)
    {
        $machine = $this->selectedMachine;
        
        if ($machineId) {
            $machine = Machine::find($machineId);
        }

        if ($machine) {
            $machine->update([
                'status' => 'available',
                'payment_status' => 'unpaid',
            ]);
            session()->flash('message', 'Machine successfully reset.');
            
            if ($this->selectedMachine && $this->selectedMachine->id == $machine->id) {
                $this->closeEditModal();
            }
        }
    }

    public function closeEditModal()
    {
        $this->selectedMachine = null;
        $this->reset(['availability']);
        $this->dispatch('closeEditModal');
    }

    public function createMachine()
    {
        $this->validate([
            'location' => 'required',
            'availability' => 'required',
        ]);

        $existingIds = Machine::pluck('machine_id')->map(function ($id) {
            return (int)substr($id, 2);
        })->sort()->toArray();

        $nextId = 1;
        $count = count($existingIds);
        for ($i = 1; $i <= $count + 1; $i++) {
            if (!in_array($i, $existingIds)) {
                $nextId = $i;
                break;
            }
        }

        $machineId = 'M-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        Machine::create([
            'machine_id' => $machineId,
            'location' => $this->location,
            'status' => 'available',
            'availability' => $this->availability,
            'payment_status' => 'unpaid',
            'branch_admin_id' => auth()->user()->role === 'branch_admin' ? auth()->id() : null,
        ]);

        session()->flash('message', 'Machine successfully added.');

        $this->reset(['location', 'availability']);
        $this->dispatch('machineAdded');
    }

    public function render()
    {
        $query = Machine::query();
        
        if (auth()->user()->role === 'branch_admin') {
            $query->where('branch_admin_id', auth()->id());
        }

        return view('livewire.admin.machine-rental', [
            'machines' => $query->orderBy($this->sortField, $this->sortDirection)->get()
        ]);
    }
}
