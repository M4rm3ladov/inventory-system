@extends('shared-layout.layout')
{{-- item unit of measurement --}}
@section('content')
    <div class="container-fluid pt-3">
        <div class="card" style="width: 100%">
            <div class="card-body">
                <h4 class="card-title">List of Brands</h4>
                {{-- action buttons --}}
                <div class="mt-4">
                    <button type="button" class="btn btn-success">
                        <i class="fa fa-add"></i>
                        <span class="ms-1">Add a New Brand</span>
                    </button>
                    <button type="button" class="btn btn-danger">
                        <i class="fa fa-file-pdf"></i>
                        <span class="ms-1">Export PDF</span>
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-file-excel"></i>
                        <span class="ms-1">Export Excel</span>
                    </button>
                </div>
                {{-- table filter --}}
                <form action="" method="" class="d-flex flex-row justify-content-between mt-3">
                    <div class="d-flex flex-row me-auto">
                        <label class="my-auto">Show:</label>
                        <select class="form-select form-select-sm mx-2" aria-label="Small select example">
                            @for ($i = 1; $i <= 10; $i++)
                                @if ($i == 10)
                                    <option selected value="10">10</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                        <label class="my-auto">entries</label>
                    </div>
                    <div class="ms-auto">
                        <label>Search:</label>
                        <input type="text" class="">
                    </div>
                </form>
                {{-- content table --}}
                <table class="table table-striped table-bordered mt-3" data-toggle="table" data-search="true"
                    data-show-columns="true">
                    <thead>
                        <tr>
                            <th scope="col" data-sortable="true">ID</th>
                            <th scope="col" data-sortable="true">Name</th>
                            <th scope="col" data-sortable="true">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td style="width: 60%">Jacob</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td style="width: 60%">Jacob</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td style="width: 60%">Jacob</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td style="width: 60%">Jacob</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td style="width: 30%">
                                <button class="btn btn-sm btn-primary"><i class="fa fa-pen-to-square me-1"></i>Edit</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
