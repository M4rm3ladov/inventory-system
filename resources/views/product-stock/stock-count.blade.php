@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <div class="container-fluid py-3">
        <div class="card h-80 w-100">
            <div class="card-body">
                <h4 class="card-title">Stock Adjust Products</h4>
                {{-- action buttons --}}
                <div class="mt-4 d-flex flex-row">
                    <div>
                        <button type="button" class="btn btn-success">
                            <i class="fa fa-add"></i>
                            <span class="ms-1">Add Item to Stock In</span>
                        </button>
                        @include('shared-layout.export-buttons')
                    </div>
                    @include('shared-layout.stock-transaction-buttons')
                </div>
                {{-- table filter --}}
                <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
                    @include('shared-layout.entries')
                    <div class="d-flex">
                        <div class="d-flex flex-row ms-auto">
                            <label class="my-auto">Supplier:</label>
                            <select class="form-select form-select-sm mx-2" aria-label="Supplier Filter">
                                <option value="">-- All --</option>
                                <option value="">Guiwan</option>
                                <option value="">Putik</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row ms-auto">
                            <label class="my-auto">Brand:</label>
                            <select class="form-select form-select-sm mx-2" aria-label="Brand Filter">
                                <option value="" selected>-- All --</option>
                                <option value="">GoodYear</option>
                                <option value="">Firestone</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row ms-auto">
                            <label class="my-auto">Category:</label>
                            <select class="form-select form-select-sm mx-2" aria-label="Category Filter">
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
                        <thead class="sticky-top top-0 z-0">
                            <tr>
                                <th scope="col" data-sortable="true">ID</th>
                                <th scope="col" data-sortable="true">Supplier</th>
                                <th scope="col" data-sortable="true">Quantity</th>
                                <th scope="col" data-sortable="true">Code</th>
                                <th scope="col" data-sortable="true">Name</th>
                                <th scope="col" data-sortable="true">Description</th>
                                <th scope="col" data-sortable="true">Brand</th>
                                <th scope="col">Image</th>
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
                                <td><img src="" alt="no img"></td>
                                <td>Tire</td>
                                <td>pieces</td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-primary"><i
                                            class="fa fa-pen-to-square me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="history" class="container-fluid py-3">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <h4 class="card-title">Stock Adjust History</h4>
                {{-- action buttons --}}
                <div class="mt-4">
                    <a type="button" class="btn btn-success" href="stock-count">
                        <i class="fa fa-add"></i>
                        <span class="ms-1">Adjust Items</span>
                    </a>
                    @include('shared-layout.export-buttons')
                </div>
                {{-- table filter --}}
                <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
                    @include('shared-layout.entries')
                    <div class="d-flex flex-row ms-auto">
                        <label for="date-from" class="my-auto ms-auto form-label text-nowrap">Date From:</label>
                        <input id="date-from" name="datetime" type="date" class="form-control datetimepicker ms-2"
                            value="">
                        <label for="date-to" class="my-auto ms-2 me-2 form-label text-nowrap">Date To:</label>
                        <input id="date-to" name="datetime" type="date" class="form-control datetimepicker"
                            value="">
                    </div>
                </form>
                {{-- content table --}}
                <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 320px;">
                    <table class="table table-striped table-bordered table-hover" data-toggle="table" data-search="true"
                        data-show-columns="true">
                        <thead class="sticky-top top-0">
                            <tr>
                                <th scope="col" data-sortable="true">ID</th>
                                <th scope="col" data-sortable="true">Reference</th>
                                <th scope="col" data-sortable="true" class="text-nowrap">Transaction Date</th>
                                <th scope="col" data-sortable="true" class="text-nowrap">Period From</th>
                                <th scope="col" data-sortable="true" class="text-nowrap">Period To</th>
                                <th scope="col" data-sortable="true">Supplier</th>
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
                                <td scope="row">2</td>
                                <td>2024123241</td>
                                <td>11/12/12</td>
                                <td>11/12/12</td>
                                <td>11/12/12</td>
                                <td>Guiwan</td>
                                <td class="text-center">50</td>
                                <td>1c1dad</td>
                                <td>4KLm</td>
                                <td>205</td>
                                <td>GoodYear</td>
                                <td>Tire</td>
                                <td>pieces</td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-primary"><i
                                            class="fa fa-pen-to-square me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
