<?php

namespace App\Livewire;

use App\Livewire\Forms\UnitForm;
use App\Models\Unit;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateUnit extends Component
{
    public UnitForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        Unit::create($this->form->all());

        $this->dispatch('unit-created', [
            'title' => 'Success!',
            'text' => 'Unit of measurement saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-unit')->to(AllUnits::class);
    }

    public function update() {
        $this->validate();
        $this->form->unit->update(
            $this->form->all()
        );

        $this->dispatch('unit-created', [
            'title' => 'Success!',
            'text' => 'Unit of measurement saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('unit-updated');
        $this->dispatch('refresh-unit')->to(AllUnits::class);
    }

    #[On('unit-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setUnit($id);
    }

    #[On('unit-delete')]
    public function delete($id) {
        $unit = Unit::findOrfail($id);
        $unit->delete();
        
        $this->dispatch('unit-deleted');
        $this->dispatch('refresh-unit')->to(AllUnits::class);
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
        return view('livewire.create-unit');
    }
}
