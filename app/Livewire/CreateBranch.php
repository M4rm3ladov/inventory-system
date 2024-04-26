<?php

namespace App\Livewire;

use App\Livewire\Forms\BranchForm;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateBranch extends Component
{
    public BranchForm $form;
    public $isEditing = false;

    public function store() {
        $this->dispatch('success-alert', [
            'title' => 'Success!',
            'text' => 'Data saved successfully!',
            'icon' => 'success',
        ]);
        // $this->form->store();
        // $this->dispatch('refresh-branch')->to(AllBranches::class);
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
    }

    public function delete() {
        dump('here');
    }

    public function resetInputs() {
        $this->form->resetInputs();
    }

    public function close() {
        $this->resetInputs();
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.create-branch');
    }
}
