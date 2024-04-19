@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <h4 class="card-title">List of Brands</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button type="button" class="btn btn-success">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Brand</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
        @include('shared-layout.entries')
        @include('shared-layout.search')
    </form>
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 320px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0">
                <tr>
                    <th scope="col" data-sortable="true">ID</th>
                    <th scope="col" data-sortable="true">Name</th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>

                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
