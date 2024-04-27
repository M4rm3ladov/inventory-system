<div>
    <h4 class="card-title">List of Branches</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#branchModal" type="button" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#branchModal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Branch</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    @include('shared-layout.search')
    {{-- table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</th>
                    <th scope="col" data-sortable="true">Name</th>
                    <th scope="col" data-sortable="true">Address</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td class="text-nowrap">{{ $branch->name }}</td>
                        <td>{{ $branch->address }}</td>
                        <td class="text-nowrap">{{ $branch->email }}</td>
                        <td class="text-nowrap">{{ $branch->phone }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('branch-edit', {id:{{ $branch->id }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#branchModal"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button" wire:click="$dispatch('delete-prompt', {branch:{{ $branch }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $branches->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.branch.name + "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('branch-delete', { id: event.branch.id })
                }
            })
        })

        var modal = document.getElementById('branchModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
        })
    </script>
@endscript
