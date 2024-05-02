<?php

namespace App\Livewire\Forms;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ServiceForm extends Form
{
    public ?Service $service;
    public $isEditing = false;

    public $code = '';

    public $name = '';

    #[Validate('exists:service_categories,id')]
    public $service_category_id = -1;

    #[Validate('nullable','image', 'max:5120')]
    public $image;

    public $db_Image;

    #[Validate('required', 'max:100000', 'numeric', 'min:1', 'gte:price_B')]
    public $price_A = '';

    #[Validate('required', 'max:100000', 'numeric', 'min:1')]
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
