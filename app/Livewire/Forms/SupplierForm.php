<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;
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
                    'required', 'min:3', 'unique:suppliers,name'
                ],
                'address' => [
                    'required', 'min:3', 'unique:suppliers,address'
                ],
                'email' => [
                    'required', 'email', 'unique:suppliers,email'
                ],
                'phone' => [
                    'required', 'max:15', 'unique:suppliers,phone'
                ],
            ];
        }

        return [
            'name' => [
                'required', 'min:3',
                Rule::unique('suppliers')->ignore($this->supplier->id),
            ],
            'address' => [
                'required', 'min:3',
                Rule::unique('suppliers')->ignore($this->supplier->id),
            ],
            'email' => [
                'required', 'email',
                Rule::unique('suppliers')->ignore($this->supplier->id),
            ],
            'phone' => [
                'required', 'max:15',
                Rule::unique('suppliers')->ignore($this->supplier->id),
            ],
        ];
    }

    public function setSupplier($id)
    {
        $this->supplier = Supplier::findOrfail($id);

        $this->name = $this->supplier->name;
        $this->address = $this->supplier->address;
        $this->email = $this->supplier->email;
        $this->phone = $this->supplier->phone;
    }

    public function resetInputs()
    {
        $this->reset(['name', 'address', 'email', 'phone']);
        $this->resetValidation();
    }

}
