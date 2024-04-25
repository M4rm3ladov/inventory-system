<?php

namespace App\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class AllBranches extends Component
{
    use WithPagination;
    public $searchQuery = '';
    public $pagination = 10;

    public function render()
    {
        $branches = Branch::query();

        if (!$this->searchQuery) {
            $branches = $branches->paginate($this->pagination);
        } else {
            $branches = $branches->where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('address', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('email', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('phone', 'like', '%' . $this->searchQuery . '%')
                ->paginate($this->pagination);
        }

        return view('livewire.all-branches', [
            'branches' => $branches,
        ]);
    }

    public function updatedSearchQuery() {
        $this->resetPage();
    }
}
