<?php

namespace App\Livewire;

use App\Exports\ServiceCategoriesExport;
use App\Models\ServiceCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllServiceCategories extends Component
{
    use WithPagination;
    public $searchQuery = '';
    public $pagination = 10;
    public $sortBy = 'created_at';
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

    #[On('refresh-service-category')]
    public function render()
    {
        $serviceCategories = ServiceCategory::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->pagination);

        return view('livewire.all-service-categories', [
            'serviceCategories' => $serviceCategories,
        ]);
    }

    public function exportPdf()
    {
        $serviceCategories = ServiceCategory::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->get()
                ->toArray();

        $pdf = Pdf::loadView('service.service-categories-pdf', ['serviceCategories' => $serviceCategories]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'serviceCategories.pdf');
    }

    public function exportExcel()
    {
        return (new ServiceCategoriesExport($this->searchQuery, $this->sortBy, $this->sortDirection))
            ->download('service-categories.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
