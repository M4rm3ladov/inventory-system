<div wire:ignore.self class="modal fade" id="stockOutModal" tabindex="-1" aria-labelledby="stockOutLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="stockOutModalLabel">{{ $isEditing ? 'Edit Stock Out Record' : 'Add Stock Out Record' }}</h1>
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
        $wire.on('stock-out-created', (event) => {
            const data = event
            swal.fire({
                icon: data[0]['icon'],
                title: data[0]['title'],
                text: data[0]['text'],
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('stock-out-deleted', () => {
            swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Stock in record deleted successfully!',
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('stock-out-updated', () => {
            $('#stockOutModal').modal('hide')
        })
    </script>
@endscript
