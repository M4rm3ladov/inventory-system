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
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'code',
                        'colDisplay' => 'Code',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'name',
                        'colDisplay' => 'Name',
                    ])
                    <th scope="col">Image</th>
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'category',
                        'colDisplay' => 'Category',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'price_A',
                        'colDisplay' => 'Price A',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'price_B',
                        'colDisplay' => 'Price B',
                    ])
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->services as $service)
                    <tr wire:key="{{ $service->id }}">
                        <th scope="row">
                            {{ ($this->services->currentpage() - 1) * $this->services->perpage() + $loop->index + 1 }}</th>
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
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {service:{{ $service }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->services->links() }}
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
