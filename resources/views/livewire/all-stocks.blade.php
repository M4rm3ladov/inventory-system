<div>
    <h4 class="card-title">List of Stock on Hand</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    @include('product-stock.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'branch',
                        'colDisplay' => 'Branch',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'code',
                        'colDisplay' => 'Code',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'name',
                        'colDisplay' => 'Name',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'description',
                        'colDisplay' => 'Description',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'brand',
                        'colDisplay' => 'Brand',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'quantity',
                        'colDisplay' => 'Quantity',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'category',
                        'colDisplay' => 'Category',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'unit',
                        'colDisplay' => 'Unit',
                    ])
                </tr>
            </thead>
            <tbody>
                @foreach ($this->stocks as $stock)
                    <tr wire:key="{{ $stock->id }}">
                        <th scope="row">
                            {{ ($this->stocks->currentpage() - 1) * $this->stocks->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $stock->code }}</td>
                        <td class="text-nowrap">{{ $stock->branch->branchName }}</td>
                        <td class="text-nowrap">{{ $stock->item->itemName }}</td>
                        <td class="text-nowrap">{{ $stock->item->description }}</td>
                        <td class="text-nowrap">{{ $stock->item->brandName }}</td>
                        <td class="text-nowrap">{{ $stock->item->categoryName }}</td>
                        <td class="text-nowrap">{{ $stock->item->unitName }}</td>
                        <td class="text-nowrap">
                            <button
                                wire:click="$dispatch('item-edit', {id:{{ $stock->item->id }}, categoryId:{{ $item->itemCategory->id }}, 
                                brandId:{{ $stock->item->brand->id }}, unitId:{{ $stock->item->unit->id }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button"33333
                                wire:click="$dispatch('delete-prompt', {item:{{ $item }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->stocks->links() }}
</div>
