<div wire:ignore.self class="modal fade" id="serviceCategoryModal" tabindex="-1" aria-labelledby="serviceCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="serviceCategoryModalLabel">{{ $isEditing ? 'Edit Service Category' : 'Add Service Category' }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-1">
                        <label class="me-1 form-label">Name:</label>
                        <input type="text" class="form-control @error('form.name') is-invalid  @enderror"
                            wire:model="form.name">
                        @error('form.name')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">Cancel</button>
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
        $wire.on('service-category-created', (event) => {
            const data = event
            swal.fire({
                icon: data[0]['icon'],
                title: data[0]['title'],
                text: data[0]['text'],
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('service-category-deleted', () => {
            swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Service category deleted successfully!',
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('service-category-updated', () => {
            $('#serviceCategoryModal').modal('hide')
        })
    </script>
@endscript
