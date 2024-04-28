<?php

namespace App\Livewire\Forms;

use App\Models\ItemCategory;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ItemCategoryForm extends Form
{
    public ?ItemCategory $itemCategory;
    public $isEditing = false;

    public $name = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'name' => [
                    'required', 'min:3', 'unique:item_categories'
                ]
            ];
        }
        return [
            'name' => [
                'required', 'min:3',
                Rule::unique('item_categories')->ignore($this->itemCategory->id),
            ],
        ];
    }

    public function setItemCategory($id)
    {
        $this->itemCategory = ItemCategory::findOrfail($id);

        $this->name = $this->itemCategory->name;
    }

    public function resetInputs()
    {
        $this->reset(['name']);
        $this->resetValidation();
    }
}

