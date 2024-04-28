<?php

namespace App\Livewire;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateSupplier extends Component
{
    public SupplierForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        Supplier::create($this->form->all());

        $this->dispatch('supplier-created', [
            'title' => 'Success!',
            'text' => 'Supplier saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-supplier')->to(AllSuppliers::class);
    }

    public function update() {
        $this->validate();
        $this->form->supplier->update(
            $this->form->all()
        );

        $this->dispatch('supplier-created', [
            'title' => 'Success!',
            'text' => 'Supplier saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('supplier-updated');
        $this->dispatch('refresh-supplier')->to(AllSuppliers::class);
    }

    #[On('supplier-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setSupplier($id);
    }

    #[On('supplier-delete')]
    public function delete($id) {
        $supplier = Supplier::findOrfail($id);
        $supplier->delete();
        
        $this->dispatch('supplier-deleted');
        $this->dispatch('refresh-supplier')->to(AllSuppliers::class);
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
        return view('livewire.create-supplier');
    }
}
