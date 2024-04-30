<div>
    <h4 class="card-title">List of Service Items</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#serviceModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Service</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    @include('service.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
                    <th scope="col" data-sortable="true" wire:click="setSortBy('code')">
                        @if ($sortBy != 'code')
                            <i class="fa fa-sort mr-1"></i>
                        @elseif ($sortDirection == 'ASC')
                            <i class="fa fa-sort-up mr-1"></i>
                        @else
                            <i class="fa fa-sort-down mr-1"></i>
                        @endif
                        <span>Code<span>
                    </th>
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
                    <th scope="col">Image</th>
                    <th scope="col" data-sortable="true" wire:click="setSortBy('category')">
                        @if ($sortBy != 'category')
                            <i class="fa fa-sort mr-1"></i>
                        @elseif ($sortDirection == 'ASC')
                            <i class="fa fa-sort-up mr-1"></i>
                        @else
                            <i class="fa fa-sort-down mr-1"></i>
                        @endif
                        <span>Category<span>
                    </th>
                    <th scope="col" data-sortable="true" wire:click="setSortBy('price_A')">
                        @if ($sortBy != 'price_A')
                            <i class="fa fa-sort mr-1"></i>
                        @elseif ($sortDirection == 'ASC')
                            <i class="fa fa-sort-up mr-1"></i>
                        @else
                            <i class="fa fa-sort-down mr-1"></i>
                        @endif
                        <span>Price A<span>
                    </th>
                    <th scope="col" data-sortable="true" wire:click="setSortBy('price_B')">
                        @if ($sortBy != 'price_B')
                            <i class="fa fa-sort mr-1"></i>
                        @elseif ($sortDirection == 'ASC')
                            <i class="fa fa-sort-up mr-1"></i>
                        @else
                            <i class="fa fa-sort-down mr-1"></i>
                        @endif
                        <span>Price B<span>
                    </th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr wire:key="{{ $service->id }}">
                        <th scope="row">{{ ($services ->currentpage() - 1) * $services->perpage() + $loop->index + 1 }}</th>
                        <td class="text-nowrap">{{ $service->code }}</td>
                        <td class="text-nowrap">{{ $service->serviceName }}</td>
                        <td class="text-nowrap"><img style="width: 100px;" src="{{ $service->image }}"></td>
                        <td class="text-nowrap">{{ $service->serviceCategory->name }}</td>
                        <td class="text-nowrap">{{ $service->price_A }}</td>
                        <td class="text-nowrap">{{ $service->price_B }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('service-edit', {id:{{ $service->id }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button" wire:click="$dispatch('delete-prompt', {service:{{ $service }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $services->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.service.name +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('service-delete', {
                        id: event.service.id
                    })
                }
            })
        })

        var modal = document.getElementById('serviceModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
        })
    </script>
@endscript
