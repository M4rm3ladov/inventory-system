<?php

namespace App\Livewire;

use App\Models\Branch;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class AllBranches extends Component
{
    use WithPagination;
    public $searchQuery = '';
    public $pagination = 10;

    public function placeholder() {
        return <<<'HTML'
            <div>
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

        sleep(5);
        return view('livewire.all-branches', [
            'branches' => $branches,
        ]);
    }

    public function updatedSearchQuery() {
        $this->resetPage();
    }
}
