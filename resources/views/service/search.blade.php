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
    <div class="d-flex flex-row ms-auto mt-2">
        <label class="my-auto text-nowrap">Category:</label>
        <select wire:model.live="category" wire:change="categoryChange" class="form-select form-select ms-2"
            aria-label="Result Count">
            <option value={{ -1 }} selected>All</option>
            @foreach ($serviceCategories as $serviceCategory)
                <option value="{{ $serviceCategory->id }}">
                    {{ $serviceCategory->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="d-flex flex-row ms-auto mt-2">
        <div class="d-flex flex-row me-2">
            <label class="my-auto me-2 text-nowrap">Price A:</label>
            <div class="d-flex flex-row" style="width: 180px;">
                <input wire:model.live.debounce.300ms="priceAFrom" type="number" class="form-control me-2">
                <input wire:model.live.debounce.300ms="priceATo" type="number" class="form-control">
            </div>
        </div>
        <div class="d-flex flex-row ">
            <label class="my-auto me-2 text-nowrap">Price B:</label>
            <div class="d-flex flex-row" style="width: 180px;">
                <input wire:model.live.debounce.300ms="priceBFrom" type="number" class="form-control me-2">
                <input wire:model.live.debounce.300ms="priceBTo" type="number" class="form-control">
            </div>
        </div>
    </div>
</form>
