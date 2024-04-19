@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <h4 class="card-title">List of Product Items</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button type="button" class="btn btn-success">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Product</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
        @include('shared-layout.entries')
        <div class="d-flex ms-auto">
            <div class="d-flex flex-row ms-auto">
                <label class="">Branch:</label>
                <select class="form-select form-select-sm mx-2" aria-label="Branch Filter">
                    <option value="">-- All --</option>
                    <option value="">Guiwan</option>
                    <option value="">Putik</option>
                </select>
            </div>
            <div class="d-flex flex-row">
                <label>Brand:</label>
                <select class="form-select form-select-sm mx-2" aria-label="Branch Filter">
                    <option value="" selected>-- All --</option>
                    <option value="">GoodYear</option>
                    <option value="">Firestone</option>
                </select>
            </div>
            <div class="d-flex flex-row">
                <label>Category:</label>
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
                    <th scope="col" data-sortable="true">Code</th>
                    <th scope="col" data-sortable="true">Name</th>
                    <th scope="col" data-sortable="true">Description</th>
                    <th scope="col" data-sortable="true">Brand</th>
                    <th scope="col">Image</th>
                    <th scope="col" data-sortable="true">Category</th>
                    <th scope="col" data-sortable="true">Unit</th>
                    <th class="text-nowrap" scope="col" data-sortable="true">Supplier Price</th>
                    <th class="text-nowrap" scope="col" data-sortable="true">Price A</th>
                    <th class="text-nowrap" scope="col" data-sortable="true">Price B</th>
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">2</th>
                    <td>1c1dad</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td><img src="" alt="no img"></td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td class="text-end">200.75</td>
                    <td class="text-end">500</td>
                    <td class="text-end">250</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>1c1dad</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td><img src="" alt="no img"></td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td class="text-end">200.75</td>
                    <td class="text-end">500</td>
                    <td class="text-end">250</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>1c1dad</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td><img src="" alt="no img"></td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td class="text-end">200.75</td>
                    <td class="text-end">500</td>
                    <td class="text-end">250</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>1c1dad</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td><img src="" alt="no img"></td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td>asfdsafasdfasdfsfdsafadsfasdfadsfdsa</td>
                    <td class="text-end">200.75</td>
                    <td class="text-end">500</td>
                    <td class="text-end">250</td>
                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection