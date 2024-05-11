<div wire:ignore.self class="modal fade" id="stockReturnModal" tabindex="-1" aria-labelledby="stockReturnLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="stockReturnModalLabel">{{ $isEditing ? 'Edit Stock Return Record' : 'Add Stock Return Record' }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-1 ">
                        <input type="text" wire:model="form.item_id">
                        @error('form.item_id')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1 ">
                        @livewire('search-item')
                    </div>
                    <div class="mb-1 w-25">
                        <label class="me-1 form-label">Quantity:</label>
                        <input type="number" class="form-control @error('form.quantity') is-invalid  @enderror"
                            wire:model="form.quantity">
                        @error('form.quantity')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Supplier:</label>
                        <select wire:model="form.supplier_id"
                            class="form-select form-select-sm @error('form.supplier_id') is-invalid  @enderror">
                            <option value={{ -1 }} selected>--Choose Supplier--</option>
                            @foreach ($this->suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('form.supplier_id')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1 ">
                        <label class="me-1 form-label">Remarks:</label>
                        <textarea class="form-control @error('form.remarks') is-invalid  @enderror" wire:model="form.remarks"></textarea>
                        @error('form.remarks')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1 w-25">
                        <label for="date-from" class="form-label text-nowrap">Transaction Date:</label>
                        <input type="date" name="datetime" wire:model="form.transact_date"
                            class="form-control 
                            @error('form.transact_date') is-invalid  @enderror">
                        @error('form.transact_date')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="resetInputs" class="btn btn-secondary">Reset</button>
                    <button type="button" wire:click="{{ $isEditing ? 'update' : 'store' }}" class="btn btn-success">
                        {{ $isEditing ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('stock-return-created', (event) => {
            const data = event
            swal.fire({
                icon: data[0]['icon'],
                title: data[0]['title'],
                text: data[0]['text'],
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('stock-return-deleted', () => {
            swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Stock Return record deleted successfully!',
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('stock-return-updated', () => {
            $('#stockReturnModal').modal('hide')
        })
    </script>
@endscript
