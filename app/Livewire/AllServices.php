<?php

namespace App\Livewire;

use App\Exports\ServicesExport;
use App\Models\Service;
use App\Models\ServiceCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy()]
class AllServices extends Component
{
    use WithPagination;
    public $searchQuery = '';
    public $pagination = 10;

    public $sortBy = 'created_at';
    public $sortDirection = 'DESC';
    public $category = -1;

    public $priceAFrom = '';
    public $priceATo = '';
    public $priceBFrom = '';
    public $priceBTo = '';

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
        $this->category = -1;
        $this->priceAFrom = '';
        $this->priceATo = '';
        $this->priceBFrom = '';
        $this->priceBTo = '';
    }

    public function categoryChange()
    {
        $this->updatedSearchQuery();
    }

    #[On('refresh-service')]
    public function render()
    {
        $services = Service::search($this->searchQuery)
            ->select('services.name AS serviceName', 'services.*', 'service_categories.name AS categoryName')
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.id')
            ->when($this->category != -1, function ($query) {
                $query->where('service_category_id', $this->category);
            })
            ->when($this->priceAFrom && $this->priceATo != '', function ($query) {
                $query->whereBetween('price_A', [$this->priceAFrom, $this->priceATo]);
            })
            ->when($this->priceBFrom && $this->priceBTo != '', function ($query) {
                $query->whereBetween('price_B', [$this->priceBFrom, $this->priceBTo]);
            });

        // order by for category relationship
        if ($this->sortBy == 'category') {
            $services = $services->orderBy('categoryName', $this->sortDirection);
        } else {
            $services = $services->orderBy($this->sortBy, $this->sortDirection);
        }
        // add pagination
        $services = $services->paginate($this->pagination);

        return view('livewire.all-services', [
            'services' => $services,
            'serviceCategories' => ServiceCategory::all()
        ]);
    }

    public function exportPdf()
    {
        $services = Service::search($this->searchQuery)
            ->select('services.name AS serviceName', 'services.*', 'service_categories.name AS categoryName')
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.id')
            ->when($this->category != -1, function ($query) {
                $query->where('service_category_id', $this->category);
            })
            ->when($this->priceAFrom && $this->priceATo != '', function ($query) {
                $query->whereBetween('price_A', [$this->priceAFrom, $this->priceATo]);
            })
            ->when($this->priceBFrom && $this->priceBTo != '', function ($query) {
                $query->whereBetween('price_B', [$this->priceBFrom, $this->priceBTo]);
            })
            ->get()
            ->toArray();

        $pdf = Pdf::loadView('service.services-pdf', ['services' => $services]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'services.pdf');
    }

    public function exportExcel()
    {
        return (new ServicesExport(
            $this->searchQuery,
            $this->sortBy,
            $this->sortDirection,
            $this->category,
            $this->priceAFrom,
            $this->priceATo,
            $this->priceBFrom,
            $this->priceBTo
        ))
            ->download('services.xls');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }
}
