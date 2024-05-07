<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;
    public $isEditing = false;

    #[Validate('required')]
    public $first_name = '';

    #[Validate('required')]
    public $last_name = '';

    #[Validate('min:2')]
    public $mi = '';

    #[Validate('min:2')]
    public $suffix = '';

    public $email = '';

    #[Validate('required|min:6')]
    public $password = '';
    
    #[Validate('exists:branches,id', as: 'branch')]
    public $branch_id = -1;

    #[Validate('exists:roles,id', as: 'role')]
    public $role_id = -1;

    public function rules()
    {
        if (!$this->isEditing) {
            return [
                'email' => [
                    'required', 'unique:users,email', 'email'
                ],
                'password' => [
                    'sometimes', 'min:6',
                ]
            ];
        }

        return [
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => [
                'sometimes', 'min:6',
            ]
        ];
    }

    public function setUser($id)
    {
        $this->user = User::findOrfail($id);

        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->mi = $this->user->mi;
        $this->suffix = $this->user->suffix;
        $this->email = $this->user->email;
        $this->branch_id = $this->user->branch_id;
        $this->role_id = $this->user->role_id;
    }

    public function resetInputs()
    {
        $this->reset();
        $this->resetValidation();
    }
}
