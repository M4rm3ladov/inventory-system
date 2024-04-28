<?php

namespace App\Livewire\Forms;

use App\Models\ServiceCategory;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ServiceCategoryForm extends Form
{
    public ?ServiceCategory $serviceCategory;
    public $isEditing = false;

    public $name = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'name' => [
                    'required', 'min:3', 'unique:service_categories'
                ]
            ];
        }
        return [
            'name' => [
                'required', 'min:3',
                Rule::unique('branches')->ignore($this->serviceCategory->id),
            ],
        ];
    }

    public function setServiceCategory($id)
    {
        $this->serviceCategory = ServiceCategory::findOrfail($id);

        $this->name = $this->serviceCategory->name;
    }

    public function resetInputs()
    {
        $this->reset(['name']);
        $this->resetValidation();
    }
}
