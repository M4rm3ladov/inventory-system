<div>
    <h4 class="card-title">List of Product Categories</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#itemCategoryModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Product Category</span>
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
                    <th scope="col" data-sortable="true" wire:click="setSortBy('name')">
                        @if ($sortBy != 'name')
                            <i class="fa fa-sort mr-1"></i>
                        @elseif ($sortDirection == 'ASC')
                            <i class="fa fa-sort-up mr-1"></i>
                        @else
                            <i class="fa fa-sort-down mr-1"></i>
                        @endif
                        <span>Name<span>
                    </th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemCategories as $itemCategory)
                    <tr>
                        <th scope="row">{{ ($itemCategories ->currentpage() - 1) * $itemCategories->perpage() + $loop->index + 1 }}</th>
                        <td class="text-nowrap">{{ $itemCategory->name }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('item-category-edit', {id:{{ $itemCategory->id }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#itemCategoryModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button" wire:click="$dispatch('delete-prompt', {itemCategory:{{ $itemCategory }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $itemCategories->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.itemCategory.name +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('item-category-delete', {
                        id: event.itemCategory.id
                    })
                }
            })
        })

        var modal = document.getElementById('itemCategoryModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
        })
    </script>
@endscript
