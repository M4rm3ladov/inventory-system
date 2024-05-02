<div wire:ignore.self class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="itemModalLabel">{{ $isEditing ? 'Edit Product' : 'Add Product' }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-1 ">
                        <label class="me-1 form-label">Code:</label>
                        <input type="text" class="form-control @error('form.code') is-invalid  @enderror"
                            wire:model="form.code">
                        @error('form.code')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1 ">
                        <label class="me-1 form-label">Name:</label>
                        <input type="text" class="form-control @error('form.name') is-invalid  @enderror"
                            wire:model="form.name">
                        @error('form.name')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-1 ">
                        <label class="me-1 form-label">Description:</label>
                        <input type="text" class="form-control @error('form.description') is-invalid  @enderror"
                            wire:model="form.description">
                        @error('form.description')
                            <span class="fs-6 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="mb-1 col pe-0">
                            <label class="me-1 form-label">Brand:</label>
                            <select wire:model="form.brand_id"
                                class="form-select form-select-sm @error('form.brand_id') is-invalid  @enderror">
                                <option value={{ -1 }} selected>--Choose Brand--</option>
                                @foreach ($this->brands as $brand)
                                    <option value="{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('form.brand_id')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col">
                            <label class="me-1 form-label">Unit:</label>
                            <select wire:model="form.unit_id"
                                class="form-select form-select-sm @error('form.unit_id') is-invalid  @enderror">
                                <option value={{ -1 }} selected>--Choose Unit--</option>
                                @foreach ($this->units as $unit)
                                    <option value="{{ $unit->id }}">
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('form.unit_id')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col ps-0">
                            <label class="me-1 form-label">Category:</label>
                            <select wire:model="form.item_category_id"
                                class="form-select form-select-sm @error('form.item_category_id') is-invalid  @enderror">
                                <option value={{ -1 }} selected>--Choose Category--</option>
                                @foreach ($this->itemCategories as $itemCategory)
                                    <option value="{{ $itemCategory->id }}">
                                        {{ $itemCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('form.item_category_id')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="me-1 form-label">Image:</label>
                        @if ($this->form->db_Image)
                            <a class="d-block mb-2" href="{{ url('storage/' . $this->form->db_Image) }}"
                                target="_blank">
                                <img style="width: 80px; height: 80px;" class="rounded" alt="item"
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
                    <div class="row">
                        <div class="mb-1 col pe-0">
                            <label class="me-1 form-label">Supplier Price:</label>
                            <input type="number" class="form-control @error('form.unit_price') is-invalid  @enderror"
                                wire:model="form.unit_price">
                            @error('form.unit_price')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col">
                            <label class="me-1 form-label">Price A:</label>
                            <input type="number" class="form-control @error('form.price_A') is-invalid  @enderror"
                                wire:model="form.price_A">
                            @error('form.price_A')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col ps-0">
                            <label class="me-1 form-label">Price B:</label>
                            <input type="number" class="form-control @error('form.price_B') is-invalid  @enderror"
                                wire:model="form.price_B">
                            @error('form.price_B')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
        $wire.on('item-created', (event) => {
            const data = event
            swal.fire({
                icon: data[0]['icon'],
                title: data[0]['title'],
                text: data[0]['text'],
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('item-deleted', () => {
            swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Product deleted successfully!',
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('item-updated', () => {
            $('#itemModal').modal('hide')
        })
    </script>
@endscript
