<div class="position-relative" wire:click="searchQuery">
    <label class="me-1 form-label">Item:</label>
    <input type="text" class="form-control @error('searchQuery') is-invalid  @enderror"
        wire:model.live.debounce.300ms="searchQuery">
    <ul wire:loading class="list-group position-absolute z-10 shadow-sm bg-body-tertiary rounded w-100">
        <li class="list-group-item">Searching...</li>
    </ul>
    @if (!empty($searchQuery))
        <ul class="list-group position-absolute z-10 shadow-sm bg-body-tertiary rounded w-100">
            @foreach ($this->items as $item)
                <li class="list-group-item" wire:key="{{ $item->id }}"
                    wire:click="populateItem({{ $item }})">
                    {{ $item->details }}
                </li>
            @endforeach
        </ul>
    @endif

    @error('searchQuery')
        <span class="fs-6 text-danger">{{ $message }}</span>
    @enderror
</div>
