<?php

namespace App\Livewire\Forms;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ServiceForm extends Form
{
    public ?Service $service;
    public $isEditing = false;

    public $code = '';

    public $name = '';

    public $service_category_id = -1;

    public $image;

    public $db_Image;

    public $price_A = '';

    public $price_B = '';

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'code' => [
                    'required', 'min:3', 'unique:services,code'
                ],
                'name' => [
                    'required', 'min:3', 'unique:services,name'
                ],
                'service_category_id' => [
                    'exists:service_categories,id'
                ],
                'image' => ['nullable', 'image', 'max:5120'],
                'price_A' => [
                    'required', 'max:100000', 'numeric', 'min:1', 'lte:price_B'
                ],
                'price_B' => [
                    'required', 'max:100000', 'numeric', 'min:1',
                ],
            ];
        }

        return [
            'code' => [
                'required', 'min:3',
                Rule::unique('services')->ignore($this->service->id),
            ],
            'name' => [
                'required', 'min:3',
                Rule::unique('services')->ignore($this->service->id),
            ],
            'service_category_id' => [
                'exists:service_categories,id'
            ],
            'image' => ['nullable','image', 'max:5120'],
            'price_A' => [
                'required', 'max:100000', 'numeric', 'min:1', 'lte:price_B'
            ],
            'price_B' => [
                'required', 'max:100000', 'numeric', 'min:1',
            ],
        ];
    }

    public function setService($id, $categoryId)
    {
        $this->service = Service::findOrfail($id);
        $this->service_category_id = ServiceCategory::findOrfail($categoryId);

        $this->code = $this->service->code;
        $this->name = $this->service->name;
        $this->db_Image = $this->service->image;
        $this->service_category_id = $this->service->service_category_id;
        $this->price_A = $this->service->price_A;
        $this->price_B = $this->service->price_B;
    }

    public function resetInputs()
    {
        $this->reset(['code', 'name', 'image', 'db_Image', 'service_category_id', 'price_A', 'price_B']);
        $this->resetValidation();
    }
}
