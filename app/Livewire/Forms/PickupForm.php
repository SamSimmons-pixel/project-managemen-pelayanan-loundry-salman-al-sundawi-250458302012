<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class PickupForm extends Form
{
    public $service_type;
    public $weight;
    public $pickup_address;
    public $pickup_time;
    public $branch_admin_id;

    public function rules()
    {
        return [
            'service_type' => 'required',
            'weight' => 'required|numeric',
            'pickup_address' => 'required',
            'pickup_time' => 'required|date',
            'branch_admin_id' => 'required|exists:users,id',
        ];
    }
}
