<form action="" method="" class="d-flex flex-column mt-3">
    <div class="d-flex flex-row">
        <div class="d-flex flex-row">
            <label class="my-auto">Show:</label>
            <select wire:model.live="pagination" class="form-select form-select mx-2" aria-label="Result Count">
                <option selected value="5">5</option>
                @for ($i = 10; $i <= 30; $i += 5)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <label class="my-auto">entries</label>
        </div>
        <div class="d-flex flex-row ms-auto me-2">
            <label class="my-auto me-2">Search:</label>
            <input wire:model.live.debounce.300ms="searchQuery" type="text" class="form-control">
        </div>
        <div class="">
            <button wire:click="resetFilter" type="button" class="btn btn-danger">
                <i class="fa fa-filter-circle-xmark"></i>
                <span class="ms-1">Reset Filter</span>
            </button>
        </div>
    </div>
    <div class="ms-auto mt-2" style="width: 800px">
        <div class="row ms-auto mt-2">
            <div class="col d-flex flex-row pe-0">
                <label class="my-auto text-nowrap">Category:</label>
                <select wire:model.live="category" wire:change="filterChange" class="form-select form-select ms-2">
                    <option value="All" selected>All</option>
                    @foreach ($this->itemCategories as $itemCategory)
                        <option value="{{ $itemCategory->name }}">
                            {{ $itemCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col d-flex flex-row ms-2">
                <label class="my-auto text-nowrap">Brand:</label>
                <select wire:model.live="brand" wire:change="filterChange" class="form-select form-select ms-2">
                    <option value="All" selected>All</option>
                    @foreach ($this->brands as $brand)
                        <option value="{{ $brand->name }}">
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col d-flex flex-row ms-2 ps-0">
                <label class="my-auto text-nowrap">Unit:</label>
                <select wire:model.live="unit" wire:change="filterChange" class="form-select form-select ms-2">
                    <option value="All" selected>All</option>
                    @foreach ($this->units as $unit)
                        <option value="{{ $unit->name }}">
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col d-flex flex-row justify-content-center">
                <label class="my-auto me-2 text-nowrap">Price A:</label>
                <div class="d-flex flex-row" style="width: 180px;">
                    <input wire:model.live.debounce.300ms="priceAFrom" wire:change="filterChange" type="number" class="form-control me-2">
                    <input wire:model.live.debounce.300ms="priceATo" wire:change="filterChange" type="number" class="form-control">
                </div>
            </div>
            <div class="col d-flex flex-row justify-content-center">
                <label class="my-auto me-2 text-nowrap">Price B:</label>
                <div class="d-flex flex-row" style="width: 180px;">
                    <input wire:model.live.debounce.300ms="priceBFrom" wire:change="filterChange" type="number" class="form-control me-2">
                    <input wire:model.live.debounce.300ms="priceBTo" wire:change="filterChange" type="number" class="form-control">
                </div>
            </div>
            <div class="col d-flex flex-row justify-content-center">
                <label class="my-auto me-2 text-nowrap">Unit Price:</label>
                <div class="d-flex flex-row" style="width: 180px;">
                    <input wire:model.live.debounce.300ms="unitPriceFrom" wire:change="filterChange" type="number" class="form-control me-2">
                    <input wire:model.live.debounce.300ms="unitPriceTo" wire:change="filterChange" type="number" class="form-control">
                </div>
            </div>
        </div>
    </div>
</form>
