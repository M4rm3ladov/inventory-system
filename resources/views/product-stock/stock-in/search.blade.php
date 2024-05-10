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
        <div class="d-flex flex-row ms-auto">
            <label class="my-auto me-2">Search:</label>
            <input wire:model.live.debounce.300ms="searchQuery" type="text" class="form-control">
        </div>
        <div class="ms-2">
            <button wire:click="resetFilter" type="button" class="btn btn-danger">
                <i class="fa fa-filter-circle-xmark"></i>
                <span class="ms-1">Reset Filter</span>
            </button>
        </div>
    </div>
    <div class="d-flex flex-row ms-auto mt-2">
        <label class="my-auto text-nowrap">Supplier:</label>
        <select wire:model.live="supplier" wire:change="filterChange" class="form-select form-select ms-2">
            <option value="All" selected>All</option>
            @foreach ($this->suppliers as $supplier)
                <option value="{{ $supplier->name }}">
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="ms-auto" style="width: 800px">
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
    </div>
    <div class="d-flex flex-row ms-auto mt-2">
        <label for="date-from" class="my-auto ms-auto form-label text-nowrap">Date From:</label>
        <input id="date-from" name="datetime" type="date" class="form-control datetimepicker ms-2"
            wire:model.live.debounce.300ms="dateFrom" wire:change="filterChange">
        <label for="date-to" class="my-auto ms-2 me-2 form-label text-nowrap">Date To:</label>
        <input id="date-to" name="datetime" type="date" class="form-control datetimepicker"
            wire:model.live.debounce.300ms="dateTo" wire:change="filterChange">
    </div>
</form>
