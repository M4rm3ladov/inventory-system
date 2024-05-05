<div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userModalLabel">{{ $isEditing ? 'Edit User' : 'Add User' }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-4">
                            <label class="me-1 form-label">Given Name:</label>
                            <input type="text" class="form-control @error('form.first_name') is-invalid  @enderror"
                                wire:model="form.first_name">
                            @error('form.first_name')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col col-4 px-0">
                            <label class="me-1 form-label">Surname:</label>
                            <input type="text" class="form-control @error('form.last_name') is-invalid  @enderror"
                                wire:model="form.last_name">
                            @error('form.last_name')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col col-2">
                            <label class="me-1 form-label">MI:</label>
                            <input type="text" class="form-control @error('form.mi') is-invalid  @enderror"
                                wire:model="form.mi">
                            @error('form.mi')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col col-2 ps-0">
                            <label class="me-1 form-label">Suffix:</label>
                            <input type="text" class="form-control @error('form.suffix') is-invalid  @enderror"
                                wire:model="form.suffix">
                            @error('form.suffix')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col col-7">
                            <label class="me-1 form-label">Email:</label>
                            <input type="email" class="form-control @error('form.email') is-invalid  @enderror"
                                wire:model="form.email">
                            @error('form.email')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col col-5 ps-0">
                            <label class="me-1 form-label">Password:</label>
                            <div class="input-group">
                                <input type={{ $isPassVisible ? 'text' : 'password'}} class="form-control @error('form.password') is-invalid  @enderror"
                                    wire:model="form.password">
                                <button wire:click="togglePassword" class="btn btn-outline-secondary" type="button">
                                    <i class="fa {{ $isPassVisible ? 'fa-eye-slash' : 'fa-eye'}}"></i>
                                </button>
                            </div>
                            @error('form.password')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col col-9">
                            <label class="me-1 form-label">Branch:</label>
                            <select wire:model="form.branch_id"
                                class="form-select form-select-sm @error('form.branch_id') is-invalid  @enderror">
                                <option value={{ -1 }} selected>--Choose Branch--</option>
                                @foreach ($this->branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('form.branch_id')
                                <span class="fs-6 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col col-3">
                            <label class="me-1 form-label">Role:</label>
                            <select wire:model="form.role_id"
                                class="form-select form-select-sm @error('form.role_id') is-invalid  @enderror">
                                <option value={{ -1 }} selected>--Choose Role--</option>
                                @foreach ($this->roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('form.role_id')
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
        $wire.on('user-created', (event) => {
            const data = event
            swal.fire({
                icon: data[0]['icon'],
                title: data[0]['title'],
                text: data[0]['text'],
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('user-deleted', () => {
            swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'User deleted successfully!',
                timer: 1500,
                showConfirmButton: false,
            })
        })

        $wire.on('user-updated', () => {
            $('#userModal').modal('hide')
        })
    </script>
@endscript
