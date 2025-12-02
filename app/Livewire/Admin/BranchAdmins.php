<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.admindashboard')]
class BranchAdmins extends Component
{
    public $users, $name, $email, $password, $address, $user_id;
    public $isOpen = 0;

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
    public function render()
    {
        $this->users = User::where('role', 'branch_admin')->get();
        return view('livewire.admin.branch-admins');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->address = '';
        $this->user_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => 'required',
            'address' => 'required',
        ]);

        User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'address' => $this->address,
            'role' => 'branch_admin',
        ]);

        session()->flash('message',
            $this->user_id ? 'Branch admin updated successfully.' : 'Branch admin created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->address = $user->address;

        $this->openModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Branch admin deleted successfully.');
    }
}
