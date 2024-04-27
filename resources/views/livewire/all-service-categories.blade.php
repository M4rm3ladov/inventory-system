<div>
    <h4 class="card-title">List of Service Categories</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button type="button" class="btn btn-success">
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
                    <th scope="col" data-sortable="true">ID</th>
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
                @foreach ($serviceCategories as $serviceCategory)
                    <tr>
                        <th scope="row">{{ ($serviceCategories ->currentpage() - 1) * $serviceCategories->perpage() + $loop->index + 1 }}</th>
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
    {{ $serviceCategories->links() }}
</div>
