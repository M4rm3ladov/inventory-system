<?php

namespace App\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class AllBranches extends Component
{
    use WithPagination;

    public function render()
    {
        $branches = Branch::query()
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

        return view('livewire.all-branches', [
            'branches'=> $branches,
        ]);
    }
}
