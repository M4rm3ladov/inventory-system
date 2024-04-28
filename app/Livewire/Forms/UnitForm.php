<?php

namespace App\Livewire\Forms;

use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UnitForm extends Form
{
    public Unit $unit;
    public $isEditing = false;

    public $name = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'name' => [
                    'required', 'min:3', 'unique:units'
                ]
            ];
        }
        return [
            'name' => [
                'required', 'min:3',
                Rule::unique('units')->ignore($this->unit->id),
            ],
        ];
    }

    public function setUnit($id)
    {
        $this->unit = Unit::findOrfail($id);

        $this->name = $this->unit->name;
    }

    public function resetInputs()
    {
        $this->reset(['name']);
        $this->resetValidation();
    }
}
