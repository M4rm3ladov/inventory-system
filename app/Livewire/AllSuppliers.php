<?php

namespace App\Livewire;

use App\Exports\SuppliersExport;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
#[Lazy()]
class AllSuppliers extends Component
{
    use WithPagination;

    #[Url(history:'true')]
    public $searchQuery = '';

    #[Url()]
    public $pagination = 10;

    #[Url(history:'true')]
    public $sortBy = 'created_at';
    
    #[Url(history:'true')]
    public $sortDirection = 'DESC';

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

    public function setSortBy($sortByField) {
        if ($this->sortBy === $sortByField) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDirection = 'DESC';
    }

    #[Computed()]
    public function suppliers() {
        return Supplier::search($this->searchQuery)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->pagination);

    }

    #[On('refresh-supplier')]
    public function render()
    {
        return view('livewire.all-suppliers');
    }

    public function exportPdf()
    {
        $suppliers = Supplier::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->get()
                ->toArray();

        $pdf = Pdf::loadView('supplier.suppliers-pdf', ['suppliers' => $suppliers]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'suppliers.pdf');
    }

    public function exportExcel()
    {
        return (new SuppliersExport($this->searchQuery, $this->sortBy, $this->sortDirection))
            ->download('suppliers.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
