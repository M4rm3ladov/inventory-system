<?php

namespace App\Livewire;

use App\Exports\ItemCategoriesExport;
use App\Models\ItemCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllItemCategories extends Component
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

    #[On('refresh-item-category')]
    public function render()
    {
        $itemCategories = ItemCategory::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->pagination);

        return view('livewire.all-item-categories', [
            'itemCategories' => $itemCategories,
        ]);
    }

    public function exportPdf()
    {
        $itemCategories = ItemCategory::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->get()
                ->toArray();

        $pdf = Pdf::loadView('product.item-categories-pdf', ['itemCategories' => $itemCategories]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'itemCategories.pdf');
    }

    public function exportExcel()
    {
        return (new ItemCategoriesExport($this->searchQuery))
            ->download('item-categories.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
