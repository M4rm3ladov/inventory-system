<?php

namespace App\Livewire;

use App\Livewire\Forms\BranchForm;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateBranch extends Component
{
    public BranchForm $form;
    public $isOpen = false;
    public $isEditing = false;

    // #[On('branch-create')]
    // public function create() {
    //     $this->isEditing = false;
    //     $this->resetInputs();
    //     $this->openModal();
    //     $this->formTitle = 'Add Branch';
    // }

    public function store() {
        $this->form->store();
        $this->dispatch('refresh-branch')->to(AllBranches::class);
    }

    public function update() {
        $this->form->update();
        $this->dispatch('refresh-branch')->to(AllBranches::class);
    }

    #[On('branch-edit')]
    public function edit($id)
    {
        $this->isEditing = true;
        $this->form->setBranch($id);
        $this->openModal();
    }

    public function resetInputs() {
        $this->form->resetInputs();
    }

    public function close() {
        $this->resetInputs();
        $this->isEditing = false;
        $this->closeModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.create-branch');
    }
}
