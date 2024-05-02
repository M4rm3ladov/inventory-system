<div wire:ignore.self class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="serviceModalLabel">{{ $isEditing ? 'Edit Service' : 'Add Service' }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-1">
                        <label class="me-1 form-label">Code:</label>
                        <input type="text" class="form-control @error('form.code') is-invalid  @enderror"
                            wire:model="form.code">
                        @error('form.code')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Name:</label>
                        <input type="text" class="form-control @error('form.name') is-invalid  @enderror"
                            wire:model="form.name">
                        @error('form.name')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Category:</label>
                        <select wire:model="form.service_category_id"
                            class="form-select form-select-sm @error('form.service_category_id') is-invalid  @enderror">
                            <option value={{ -1 }} selected>--Choose Category--</option>
                            @foreach ($this->serviceCategories as $serviceCategory)
                                <option value="{{ $serviceCategory->id }}">
                                    {{ $serviceCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('form.service_category_id')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Image:</label>
                        @if ($this->form->db_Image)
                            <a class="d-block mb-2" href="{{ url('storage/' . $this->form->db_Image) }}"
                                target="_blank">
                                <img style="width: 80px; height: 80px;" class="rounded" alt="service"
                                    src={{ url('storage/' . $this->form->db_Image) }}>
                            </a>
                        @endif
                        <div class="d-flex flex-row align-items-center">
                            <input type="file"
                                class="form-control form-control-sm @error('form.image') is-invalid  @enderror"
                                wire:model="form.image">
                            @if ($this->form->image)
                                <button type="button" wire:click="resetImage" class="btn">
                                    <i class="fa-regular fa-lg fa-circle-xmark" style="color:#C82333"></i>
                                </button>
                            @endif
                        </div>
                        @error('form.image')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Price A:</label>
                        <input type="number" class="form-control @error('form.price_A') is-invalid  @enderror"
                            wire:model="form.price_A">
                        @error('form.price_A')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Price B:</label>
                        <input type="number" class="form-control @error('form.price_B') is-invalid  @enderror"
                            wire:model="form.price_B">
                        @error('form.price_B')
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
        $wire.on('service-created', (event) => {
            const data = event
            swal.fire({
                icon: data[0]['icon'],
                title: data[0]['title'],
                text: data[0]['text'],
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('service-deleted', () => {
            swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Service deleted successfully!',
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('service-updated', () => {
            $('#serviceModal').modal('hide')
        })
    </script>
@endscript
