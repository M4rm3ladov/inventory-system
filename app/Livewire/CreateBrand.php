<?php

namespace App\Livewire;

use App\Livewire\Forms\BrandForm;
use App\Models\Brand;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateBrand extends Component
{
    public BrandForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        Brand::create($this->form->all());

        $this->dispatch('brand-created', [
            'title' => 'Success!',
            'text' => 'Brand saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-brand')->to(AllBrands::class);
    }

    public function update() {
        $this->validate();
        $this->form->brand->update(
            $this->form->all()
        );

        $this->dispatch('brand-created', [
            'title' => 'Success!',
            'text' => 'Brand saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('brand-updated');
        $this->dispatch('refresh-brand')->to(AllBrands::class);
    }

    #[On('brand-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setBrand($id);
    }

    #[On('brand-delete')]
    public function delete($id) {
        $brand = Brand::findOrfail($id);
        $brand->delete();
        
        $this->dispatch('brand-deleted');
        $this->dispatch('refresh-brand')->to(AllBrands::class);
    }

    public function resetInputs() {
        $this->form->resetInputs();
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.create-brand');
    }
}
