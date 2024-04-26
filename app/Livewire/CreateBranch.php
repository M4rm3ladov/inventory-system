<?php

namespace App\Livewire;

use App\Livewire\Forms\BranchForm;
use App\Models\Branch;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateBranch extends Component
{
    public BranchForm $form;
    public $isEditing = false;

    public function store() {
        $this->validate();
        Branch::create($this->form->all());

        $this->dispatch('branch-created', [
            'title' => 'Success!',
            'text' => 'Branch saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        //return $this->redirect('/branches');
        $this->dispatch('refresh-branch')->to(AllBranches::class);
    }

    public function update() {
        $this->validate();
        $this->form->branch->update(
            $this->form->all()
        );

        $this->dispatch('branch-created', [
            'title' => 'Success!',
            'text' => 'Branch saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('branch-updated');
        $this->dispatch('refresh-branch')->to(AllBranches::class);
    }

    #[On('branch-edit')]
    public function edit($id)
    {
        $this->isEditing = true;
        $this->form->setBranch($id);
    }

    #[On('branch-delete')]
    public function delete() {
        $this->dispatch('branch-deleted');
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
