<div class="position-relative" wire:click.outside="resetItemSearch">
    <label class="me-1 form-label">Item:</label>
    <input type="text" class="form-control @error('item_search') is-invalid  @enderror"
        wire:model.live.debounce.300ms="item_search">
    <ul wire:loading wire:target="item_search"
        class="list-group position-absolute z-10 shadow-sm bg-body-tertiary rounded w-100">
        <li class="list-group-item">Searching...</li>
    </ul>
    @if (!empty($item_search))
        <ul class="list-group position-absolute z-10 shadow-sm bg-body-tertiary rounded w-100">
            @if (!empty($items))
                @foreach ($items as $item)
                    <a wire:key="{{ $item['id'] }}"
                        wire:click="populateItem({{ $item['id'] }}, '{{ $item['details'] }}')"
                        class="text-decoration-none text-black link-primary list-group-item"
                        href="#" onClick="return false;"
                        aria-disabled="true">{{ $item['details'] }}</a>
                @endforeach
                {{-- @else
                <li class="list-group-item"> No results found </li> --}}
            @endif
        </ul>
    @endif
    @error('form.item_id')
        <span class="fs-6 text-danger">{{ $message }}</span>
    @enderror

    @error('item_search')
        <span class="fs-6 text-danger">{{ $message }}</span>
    @enderror
</div>