<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BranchForm extends Form
{
    public Branch $branch;

    #[Validate('required|min:3|unique:branches')]
    public $name;

    #[Validate('required|min:3|unique:branches')]
    public $address;

    #[Validate('required|email|unique:branches')]
    public $email;

    #[Validate('required|max:15|unique:branches')]
    public $phone;

    public function setBranch($id)
    {
        $this->branch = Branch::findOrfail($id);

        $this->name = $this->branch->name;
        $this->address = $this->branch->address;
        $this->email = $this->branch->email;
        $this->phone = $this->branch->phone;
    }

    public function store() 
    {
        $this->validate();
        Branch::create($this->all());
        session()->flash('success', 'Branch has been created!');
        
        $this->resetValidation();
    }

    public function update()
    {
        $this->branch->update(
            $this->all()
        );
        session()->flash('success', 'Branch has been updated!');
        
        $this->resetValidation();
    }
}
