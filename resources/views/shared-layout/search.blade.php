<form action="" method="" class="d-flex flex-row justify-content-between mt-3">
    <div class="d-flex flex-row me-auto">
        <label class="my-auto">Show:</label>
        <select wire:model.live="pagination" class="form-select form-select-sm mx-2" aria-label="Result Count">
            @for ($i = 5; $i <= 30; $i+=5)
                @if ($i == 5)
                    <option selected value="5">5</option>
                @else
                    <option value="{{ $i }}">{{ $i }}</option>
                @endif
            @endfor
        </select>
        <label class="my-auto">entries</label>
    </div>
    <div class="d-flex flex-row">
        <label class="my-auto me-2">Search:</label>
        <input wire:model.live="searchQuery" type="text" class="form-control">
    </div>
</form>