<?php

namespace App\Livewire;

use App\Livewire\Forms\ItemForm;
use App\Models\Brand;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateItem extends Component
{
    use WithFileUploads;
    public ItemForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        
        if ($this->form->image) {
            Storage::disk('public')->delete($this->form->image);
            $this->form->image = $this->form->image->store('photos', 'public');
        }
        
        Item::create($this->form->all());

        $this->dispatch('item-created', [
            'title' => 'Success!',
            'text' => 'Product saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-item')->to(AllItems::class);
    }

    public function update() {
        $this->validate();
        
        if ($this->form->image) {
            Storage::disk('public')->delete($this->form->image);
            $this->form->image = $this->form->image->store('photos', 'public');
        } else {
            $this->form->image = $this->form->db_Image;
        }

        $this->form->item->update(
            $this->form->all()
        );

        $this->dispatch('item-created', [
            'title' => 'Success!',
            'text' => 'Item saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('item-updated');
        $this->dispatch('refresh-item')->to(AllItems::class);
    }

    #[On('item-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setItem($id);
    }

    #[On('item-delete')]
    public function delete($id) {
        $item = Item::findOrfail($id);
        $item->delete();
        
        $this->dispatch('item-deleted');
        $this->dispatch('refresh-item')->to(AllItems::class);
    }

    public function resetImage() {
        $this->form->image = '';
    }

    public function resetInputs() {
        $this->form->resetInputs();
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    #[Computed()]
    public function itemCategories() {
        return ItemCategory::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function brands() {
        return Brand::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function units() {
        return Unit::orderBy('name', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.create-item');
    }
}
