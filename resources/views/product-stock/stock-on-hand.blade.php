@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <h4 class="card-title">List of Stock on Hand</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
        @include('shared-layout.entries')
        <div class="d-flex">
            <div class="d-flex flex-row ms-auto">
                <label class="my-auto">Branch:</label>
                <select class="form-select form-select-sm mx-2" aria-label="Branch Filter">
                    <option value="">-- All --</option>
                    <option value="">Guiwan</option>
                    <option value="">Putik</option>
                </select>
            </div>
            <div class="d-flex flex-row ms-auto">
                <label class="my-auto">Brand:</label>
                <select class="form-select form-select-sm mx-2" aria-label="Branch Filter">
                    <option value="" selected>-- All --</option>
                    <option value="">GoodYear</option>
                    <option value="">Firestone</option>
                </select>
            </div>
            <div class="d-flex flex-row ms-auto">
                <label class="my-auto">Category:</label>
                <select class="form-select form-select-sm mx-2" aria-label="Branch Filter">
                    <option value="" selected>-- All --</option>
                    <option value="">Tire</option>
                    <option value="">Oil</option>
                </select>
            </div>
        </div>
        @include('shared-layout.search')
    </form>
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 320px;">
        <table class="table table-striped table-bordered table-hover" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0">
                <tr>
                    <th scope="col" data-sortable="true">ID</th>
                    <th scope="col" data-sortable="true">Branch</th>
                    <th scope="col" data-sortable="true">Quantity</th>
                    <th scope="col" data-sortable="true">Code</th>
                    <th scope="col" data-sortable="true">Name</th>
                    <th scope="col" data-sortable="true">Description</th>
                    <th scope="col" data-sortable="true">Brand</th>
                    <th scope="col" data-sortable="true">Category</th>
                    <th scope="col" data-sortable="true">Unit</th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">2</th>
                    <td>Guiwan</td>
                    <td class="text-center">50</td>
                    <td>1c1dad</td>
                    <td>4KLm</td>
                    <td>205</td>
                    <td>GoodYear</td>
                    <td>Tire</td>
                    <td>pieces</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
