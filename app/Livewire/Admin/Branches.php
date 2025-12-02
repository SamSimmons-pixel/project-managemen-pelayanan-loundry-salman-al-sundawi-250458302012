<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Branch;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admindashboard')]
class Branches extends Component
{
    public $branches, $name, $address, $user_id, $branch_id;
    public $isOpen = 0;
    public $showNewAdminForm = false;
    public $newAdminName, $newAdminEmail, $newAdminPassword;

    public function render()
    {
        $users = User::where('role', 'branch_admin')->get();
        return view('livewire.admin.branches', ['users' => $users]);
    }

    public function toggleNewAdminForm()
    {
        $this->showNewAdminForm = !$this->showNewAdminForm;
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
        $this->address = '';
        $this->user_id = '';
        $this->branch_id = '';
        $this->newAdminName = '';
        $this->newAdminEmail = '';
        $this->newAdminPassword = '';
        $this->showNewAdminForm = false;
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
        ];

        if ($this->showNewAdminForm) {
            $rules['newAdminName'] = 'required';
            $rules['newAdminEmail'] = 'required|email|unique:users,email';
            $rules['newAdminPassword'] = 'required|min:8';
        } else {
            $rules['user_id'] = 'required';
        }

        $this->validate($rules);

        if ($this->showNewAdminForm) {
            $user = User::create([
                'name' => $this->newAdminName,
                'email' => $this->newAdminEmail,
                'password' => bcrypt($this->newAdminPassword),
                'role' => 'branch_admin',
            ]);
            $this->user_id = $user->id;
        }


        session()->flash('message',
            $this->branch_id ? 'Branch Updated Successfully.' : 'Branch Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }


    public function delete($id)
    {
        session()->flash('message', 'Branch Deleted Successfully.');
    }
}
