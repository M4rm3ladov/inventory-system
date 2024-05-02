<?php

namespace App\Livewire\Forms;

use App\Models\Brand;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ItemForm extends Form
{
    public ?Item $item;
    public $isEditing = false;

    public $code = '';

    public $name = '';

    #[Validate('required', 'min:3')]
    public $description = '';

    #[Validate('exists:item_categories,id', as: 'category')]
    public $item_category_id = -1;

    #[Validate('exists:brands,id', as: 'brand')]
    public $brand_id = -1;
    
    #[Validate('exists:units,id', as: 'unit')]
    public $unit_id = -1;

    #[Validate('nullable','image', 'max:5120')]
    public $image;

    public $db_Image;

    #[Validate('required', 'max:100000', 'numeric', 'min:1')]
    public $unit_price = '';

    #[Validate('required', 'max:100000', 'numeric', 'min:1', 'gte:price_B')]
    public $price_A = '';

    #[Validate('required', 'max:100000', 'numeric', 'min:1')]
    public $price_B = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'code' => [
                    'required', 'min:3', 'unique:items,code'
                ],
                'name' => [
                    'required', 'min:3', 'unique:items,name'
                ],
            ];
        }

        return [
            'code' => [
                'required', 'min:3',
                Rule::unique('items')->ignore($this->item->id),
            ],
            'name' => [
                'required', 'min:3',
                Rule::unique('items')->ignore($this->item->id),
            ],
        ];
    }

    public function setItem($id, $categoryId, $brandId, $unitId)
    {
        $this->item = Item::findOrfail($id);
        $this->item_category_id = ItemCategory::findOrfail($categoryId);
        $this->brand_id = Brand::findOrfail($brandId);
        $this->unit_id = Unit::findOrfail($unitId);

        $this->code = $this->item->code;
        $this->name = $this->item->name;
        $this->description = $this->item->description;
        $this->db_Image = $this->item->image;
        $this->item_category_id = $this->item->item_category_id;
        $this->brand_id = $this->item->brand_id;
        $this->unit_id = $this->item->unit_id;
        $this->unit_price = $this->item->unit_price;
        $this->price_A = $this->item->price_A;
        $this->price_B = $this->item->price_B;
    }

    public function resetInputs()
    {
        $this->reset();
        $this->resetValidation();
    }
}
