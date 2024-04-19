<div class="d-flex flex-row me-auto">
    <label class="my-auto">Show:</label>
    <select class="form-select form-select-sm mx-2" aria-label="Result Count">
        @for ($i = 1; $i <= 10; $i++)
            @if ($i == 10)
                <option selected value="10">10</option>
            @else
                <option value="{{ $i }}">{{ $i }}</option>
            @endif
        @endfor
    </select>
    <label class="my-auto">entries</label>
</div>