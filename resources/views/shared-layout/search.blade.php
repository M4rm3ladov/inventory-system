<form action="" method="" class="d-flex flex-row justify-content-between mt-3">
    <div class="d-flex flex-row me-auto">
        <label class="my-auto">Show:</label>
        <select wire:model.live="pagination" class="form-select form-select-sm mx-2" aria-label="Result Count">
            <option selected value="5">5</option>
            @for ($i = 10; $i <= 30; $i += 5)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        <label class="my-auto">entries</label>
    </div>
    <div class="d-flex flex-row">
        <label class="my-auto me-2">Search:</label>
        <input wire:model.live.debounce.300ms="searchQuery" type="text" class="form-control">
    </div>
</form>
