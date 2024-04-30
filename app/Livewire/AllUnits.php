<?php

namespace App\Livewire;

use App\Exports\UnitsExport;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllUnits extends Component
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

    #[On('refresh-unit')]
    public function render()
    {
        $units = Unit::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->pagination);

        return view('livewire.all-units', [
            'units' => $units,
        ]);
    }

    public function exportPdf()
    {
        $units = Unit::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->get()
                ->toArray();

        $pdf = Pdf::loadView('product.units-pdf', ['units' => $units]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'product-units.pdf');
    }

    public function exportExcel()
    {
        return (new UnitsExport($this->searchQuery, $this->sortBy, $this->sortDirection))
            ->download('product-units.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
