<?php

namespace App\Livewire\Forms;

use App\Models\Brand;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BrandForm extends Form
{
    public ?Brand $brand;
    public $isEditing = false;

    public $name = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'name' => [
                    'required', 'min:3', 'unique:brands,name'
                ]
            ];
        }
        return [
            'name' => [
                'required', 'min:3',
                Rule::unique('brands')->ignore($this->brand->id),
            ],
        ];
    }

    public function setBrand($id)
    {
        $this->brand = Brand::findOrfail($id);

        $this->name = $this->brand->name;
    }

    public function resetInputs()
    {
        $this->reset(['name']);
        $this->resetValidation();
    }
}

