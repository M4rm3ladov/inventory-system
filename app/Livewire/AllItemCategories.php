<?php

namespace App\Livewire;

use App\Exports\ItemCategoriesExport;
use App\Models\ItemCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllItemCategories extends Component
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
    public function itemCategories() {
        return ItemCategory::search($this->searchQuery)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->pagination);
    }

    #[On('refresh-item-category')]
    public function render()
    {
        return view('livewire.all-item-categories');
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
        return (new ItemCategoriesExport($this->searchQuery, $this->sortBy, $this->sortDirection))
            ->download('item-categories.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
