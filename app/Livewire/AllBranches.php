<?php

namespace App\Livewire;

use App\Exports\BranchesExport;
use App\Models\Branch;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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

    #[On('refresh-branch')]
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

    public function exportPdf() {
        if (!$this->searchQuery) {
            $branches = Branch::query()
                ->get()
                ->toArray();
        } else {
            $branches = Branch::query()->where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('address', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('email', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('phone', 'like', '%' . $this->searchQuery . '%')
                ->get()
                ->toArray();    
        }

        $pdf = Pdf::loadView('branch.branches-pdf', ['branches' => $branches]);

        return response()->streamDownload(function() use($pdf) {
            echo $pdf->stream();
        }, 'branches.pdf');
    }

    public function exportExcel() {
        return (new BranchesExport($this->searchQuery))
            ->download('branches.xls');
    }

    public function updatedSearchQuery() {
        $this->resetPage();
    }
}
