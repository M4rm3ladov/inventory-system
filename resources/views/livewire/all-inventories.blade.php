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
                @foreach ($this->inventories as $inventory)
                    <tr wire:key="{{ $inventory->id }}">
                        <th scope="row">
                            {{ ($this->inventories->currentpage() - 1) * $this->inventories->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $inventory->code }}</td>
                        <td class="text-nowrap">{{ $inventory->branchName }}</td>
                        <td class="text-nowrap">{{ $inventory->itemName }}</td>
                        <td class="text-nowrap">{{ $inventory->description }}</td>
                        <td class="text-nowrap">{{ $inventory->brandName }}</td>
                        <td class="text-nowrap">{{ $inventory->categoryName }}</td>
                        <td class="text-nowrap">{{ $inventory->unitName }}</td>
                        <td class="text-nowrap">
                            <button
                                wire:click="$dispatch('item-edit', {id:{{ $inventory->item->id }}, categoryId:{{ $item->itemCategory->id }}, 
                                brandId:{{ $inventory->item->brand->id }}, unitId:{{ $inventory->item->unit->id }}})"
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
    {{ $this->inventories->links() }}
</div>
