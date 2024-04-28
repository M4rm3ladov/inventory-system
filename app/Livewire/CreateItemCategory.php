<?php

namespace App\Livewire;

use App\Livewire\Forms\ItemCategoryForm;
use App\Models\ItemCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateItemCategory extends Component
{
    public ItemCategoryForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        ItemCategory::create($this->form->all());

        $this->dispatch('item-category-created', [
            'title' => 'Success!',
            'text' => 'Product category saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-item-category')->to(AllItemCategories::class);
    }

    public function update() {
        $this->validate();
        $this->form->itemCategory->update(
            $this->form->all()
        );

        $this->dispatch('item-category-created', [
            'title' => 'Success!',
            'text' => 'Product category saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('item-category-updated');
        $this->dispatch('refresh-item-category')->to(AllItemCategories::class);
    }

    #[On('item-category-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setItemCategory($id);
    }

    #[On('item-category-delete')]
    public function delete($id) {
        $itemCategory = ItemCategory::findOrfail($id);
        $itemCategory->delete();
        
        $this->dispatch('item-category-deleted');
        $this->dispatch('refresh-item-category')->to(AllItemCategories::class);
    }

    public function resetInputs() {
        $this->form->resetInputs();
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.create-item-category');
    }
}
