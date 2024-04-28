<?php

namespace App\Livewire\Forms;

use App\Models\Branch;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BranchForm extends Form
{
    public ?Branch $branch;
    public $isEditing = false;

    public $name = '';

    public $address = '';

    public $email = '';

    public $phone = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'name' => [
                    'required', 'min:3', 'unique:suppliers'
                ],
                'address' => [
                    'required', 'min:3', 'unique:suppliers'
                ],
                'email' => [
                    'required', 'email', 'unique:suppliers'
                ],
                'phone' => [
                    'required', 'max:15', 'unique:suppliers'
                ],
            ];
        }
        
        return [
            'name' => [
                'required', 'min:3',
                Rule::unique('branches')->ignore($this->branch->id),
            ],
            'address' => [
                'required', 'min:3',
                Rule::unique('branches')->ignore($this->branch->id),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('branches')->ignore($this->branch->id),
            ],
            'phone' => [
                'required', 'max:15',
                Rule::unique('branches')->ignore($this->branch->id),
            ],
        ];
    }

    public function mount() {
        $this->branch = new Branch();
    }

    public function setBranch($id)
    {
        $this->branch = Branch::findOrfail($id);

        $this->name = $this->branch->name;
        $this->address = $this->branch->address;
        $this->email = $this->branch->email;
        $this->phone = $this->branch->phone;
    }

    public function resetInputs()
    {
        $this->reset(['name', 'address', 'email', 'phone']);
        $this->resetValidation();
    }
}
