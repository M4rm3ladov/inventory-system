<div>
    {{-- action buttons --}}
    <div class="mt-4">
        <button @click="$dispatch('branch-create')" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Branch</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
        <div class="d-flex flex-row me-auto">
            <label class="my-auto">Show:</label>
            <select wire:model.live="pagination" class="form-select form-select-sm mx-2" aria-label="Result Count">
                @for ($i = 5; $i <= 30; $i+=5)
                    @if ($i == 5)
                        <option selected value="5">5</option>
                    @else
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                @endfor
            </select>
            <label class="my-auto">entries</label>
        </div>
        <div class="d-flex flex-row">
            <label class="my-auto me-2">Search:</label>
            <input wire:model.live="searchQuery" type="text" class="form-control">
        </div>
    </form>
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
                        <td>{{ $branch->email }}</td>
                        <td>{{ $branch->phone }}</td>
                        <td class="text-nowrap">
                            <button @click="$dispatch('branch-edit', {id:{{ $branch->id }}})" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#branchModal"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $branches->links() }}
</div>
