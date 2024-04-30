<div>
    <h4 class="card-title">List of Service Categories</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#serviceCategoryModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Service Category</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    @include('shared-layout.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0">
                <tr>
                    <th scope="col" data-sortable="true">#</th>
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'name',
                        'colDisplay' => 'Name',
                    ])
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->serviceCategories as $serviceCategory)
                    <tr wire:key="{{ $serviceCategory->id }}">
                        <th scope="row">{{ ($this->serviceCategories ->currentpage() - 1) * $this->serviceCategories->perpage() + $loop->index + 1 }}</th>
                        <td class="text-nowrap">{{ $serviceCategory->name }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('service-category-edit', {id:{{ $serviceCategory->id }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#serviceCategoryModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button" wire:click="$dispatch('delete-prompt', {serviceCategory:{{ $serviceCategory }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->serviceCategories->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.serviceCategory.name +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('service-category-delete', {
                        id: event.serviceCategory.id
                    })
                }
            })
        })

        var modal = document.getElementById('serviceCategoryModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
        })
    </script>
@endscript
