<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllUsers extends Component
{
    use WithPagination;

    #[Url(history: 'true')]
    public $searchQuery = '';

    #[Url()]
    public $pagination = 10;

    #[Url(history: 'true')]
    public $sortBy = '';

    #[Url(history: 'true')]
    public $sortDirection = 'DESC';

    #[Url(history: 'true')]
    public $role = 'All';

    #[Url(history: 'true')]
    public $branch = 'All';


    public function placeholder()
    {
        return <<<'HTML'
            <div>
                <div class="placeholder-glow mb-2">
                    <div class="placeholder placeholder-lg col-2"></div>
                </div>
                <div>
                    <button class="btn btn-primary disabled placeholder col-2 mr-2">
                    <button class="btn btn-primary disabled placeholder col-2 mr-2">
                    <button class="btn btn-primary disabled placeholder col-2">
                </div>
                <div class="placeholder-glow">
                    <div class="placeholder placeholder-lg col-2"></div>
                    <div class="placeholder placeholder-lg col-12"></div>
                </div>
            </div>
        HTML;
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        
        $this->sortBy = $sortByField;
        $this->sortDirection = 'DESC';
    }

    public function resetFilter()
    {
        $this->searchQuery = '';
        $this->sortBy = '';
        $this->sortDirection = 'DESC';
        $this->role = 'All';
        $this->branch = 'All';
    }

    public function filterChange()
    {
        $this->updatedSearchQuery();
    }

    #[Computed()]
    public function branches()
    {
        return Branch::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function roles()
    {
        return Role::orderBy('name', 'ASC')->get();
    }

    #[Computed()]
    public function users()
    {
        $users = User::search($this->searchQuery)
            ->select(
                DB::raw("CONCAT(users.first_name, ' ', users.mi, ' ' , users.last_name, users.suffix) as userName"),
                'branches.name AS branchName',
                'roles.name AS roleName',
                'users.*',
            )
            ->join('branches', 'users.branch_id', '=', 'branches.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->when($this->branch != 'All', function ($query) {
                $query->where('branches.name', $this->branch);
            })
            ->when($this->role != 'All', function ($query) {
                $query->where('roles.name', $this->role);
            });

        // order by for category relationship
        if ($this->sortBy == 'branch') {
            $users = $users->orderBy('branches.name', $this->sortDirection);
        } elseif ($this->sortBy == 'role') {
            $users = $users->orderBy('roles.name', $this->sortDirection);
        } elseif ($this->sortBy == 'name') {
            $users = $users->orderBy('userName', $this->sortDirection);
        } elseif ($this->sortBy == '') {
            $users = $users->orderBy('created_at', $this->sortDirection);
        } 
        else {
            $users = $users->orderBy($this->sortBy, $this->sortDirection);
        }

        // add pagination
        $users = $users->paginate($this->pagination);

        return $users;
    }

    #[On('refresh-user')]
    public function render()
    {
        return view('livewire.all-users');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
