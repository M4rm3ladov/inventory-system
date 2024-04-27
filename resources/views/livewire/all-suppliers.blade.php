<div>
    <h4 class="card-title">List of Suppliers</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#supplierModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Supplier</span>
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
                    <th scope="col" data-sortable="true">Name</th>
                    <th scope="col" data-sortable="true">Address</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Cabato</td>
                    <td>test@mail.com</td>
                    <td>+63 13452111</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>PHIL</td>
                    <td>test@mail.com</td>
                    <td>+63 9123411324</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>PHIL</td>
                    <td>test@mail.com</td>
                    <td>+63 9123411324</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
