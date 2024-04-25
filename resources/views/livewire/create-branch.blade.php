<div>
    @if ($isOpen)
        <div wire:ignore.self class="modal show" id="branchModal" tabindex="-1" aria-labelledby="branchModalLabel"
            aria-hidden="true" style="display: block">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="branchModalLabel">{{ $formTitle }}</h1>
                        <button wire:click="close" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    @include('shared-layout.success-message')
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
                            <div class="mb-1">
                                <label class="me-1 form-label">Address:</label>
                                <input type="text" class="form-control @error('form.address') is-invalid  @enderror"
                                    wire:model="form.address">
                                @error('form.address')
                                    <span class="fs-6 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label class="me-1 form-label">Email:</label>
                                <input type="text" class="form-control @error('form.email') is-invalid  @enderror"
                                    wire:model="form.email">
                                @error('form.email')
                                    <span class="fs-6 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label class="me-1 form-label">Phone:</label>
                                <input type="text" class="form-control @error('form.phone') is-invalid  @enderror"
                                    wire:model="form.phone">
                                @error('form.phone')
                                    <span class="fs-6 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button wire:click="close" type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">Cancel</button>
                            <button wire:click.prevent wire:click="{{ $isEditing ? 'update' : 'save' }}" class="btn btn-success">
                                {{ $isEditing ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
