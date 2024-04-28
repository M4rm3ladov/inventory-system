<?php

namespace App\Livewire;

use App\Livewire\Forms\ServiceCategoryForm;
use App\Models\ServiceCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateServiceCategory extends Component
{
    public ServiceCategoryForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        ServiceCategory::create($this->form->all());

        $this->dispatch('service-category-created', [
            'title' => 'Success!',
            'text' => 'Service category saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-service-category')->to(AllServiceCategories::class);
    }

    public function update() {
        $this->validate();
        $this->form->serviceCategory->update(
            $this->form->all()
        );

        $this->dispatch('service-category-created', [
            'title' => 'Success!',
            'text' => 'Service category saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('service-category-updated');
        $this->dispatch('refresh-service-category')->to(AllServiceCategories::class);
    }

    #[On('service-category-create')]
    public function create() {
        $this->form->isEditing = false;
    }

    #[On('service-category-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setServiceCategory($id);
    }

    #[On('service-category-delete')]
    public function delete($id) {
        $serviceCategory = ServiceCategory::findOrfail($id);
        $serviceCategory->delete();
        
        $this->dispatch('service-category-deleted');
        $this->dispatch('refresh-service-category')->to(AllServiceCategories::class);
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
        return view('livewire.create-service-category');
    }
}
