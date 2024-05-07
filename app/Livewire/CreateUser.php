<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateUser extends Component
{
    public UserForm $form;
    public $isEditing = false;
    public $isPassVisible = false;

    public function store() {
        $this->validate();
        if ($this->isEditing) {
            
        }
        $this->form->password = Hash::make($this->form->password);
        User::create($this->form->all());

        $this->dispatch('user-created', [
            'title' => 'Success!',
            'text' => 'User saved successfully!',
            'icon' => 'success',
        ]);

        $this->resetInputs();
        $this->dispatch('refresh-user')->to(AllUsers::class);
    }

    public function update() {
        $this->validate();
        $this->form->user->update(
            $this->form->all()
        );

        $this->dispatch('user-created', [
            'title' => 'Success!',
            'text' => 'User saved successfully!',
            'icon' => 'success',
        ]);

        $this->close();

        $this->dispatch('user-updated');
        $this->dispatch('refresh-user')->to(AllUsers::class);
    }

    #[On('user-edit')]
    public function edit($id)
    {
        $this->form->isEditing = $this->isEditing = true;
        $this->form->setUser($id);
    }

    #[On('user-delete')]
    public function delete($id) {
        $unit = User::findOrfail($id);
        $unit->delete();
        
        $this->dispatch('user-deleted');
        $this->dispatch('refresh-user')->to(AllUsers::class);
    }

    #[On('reset-modal')]
    public function close() {
        $this->resetInputs();
        $this->form->isEditing = $this->isEditing = false;
    }

    public function resetInputs() {
        $this->isPassVisible = false;
        $this->form->resetInputs();
    }

    #[Computed()]
    public function branches() {
        return Branch::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function roles() {
        return Role::orderBy('name', 'ASC')->get();
    }

    public function togglePassword() {
        if ($this->isPassVisible) {
            $this->isPassVisible = false;
            return;
        }

        $this->isPassVisible = true;
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
