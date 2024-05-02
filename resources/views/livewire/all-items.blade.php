<div>
    <h4 class="card-title">List of Product Items</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#itemModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New Product</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    {{-- table filter --}}
    @include('product.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
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
                    <th scope="col">Image</th>
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'category',
                        'colDisplay' => 'Category',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'unit',
                        'colDisplay' => 'Unit',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'unit_Price',
                        'colDisplay' => 'Supplier Price',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'price_A',
                        'colDisplay' => 'Price A',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'price_B',
                        'colDisplay' => 'Price B',
                    ])
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->items as $item)
                    <tr wire:key="{{ $item->id }}">
                        <th scope="row">
                            {{ ($this->items->currentpage() - 1) * $this->items->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $item->code }}</td>
                        <td class="text-nowrap">{{ $item->itemName }}</td>
                        <td class="text-nowrap">{{ $item->description }}</td>
                        <td class="text-nowrap">{{ $item->brandName }}</td>
                        <td class="text-nowrap text-center">
                            <a href="{{ $item->image ? url('storage/' . $item->image) : 'https://placehold.co/80' }}"
                                target="_blank">
                                <img style="width: 80px; height: 80px;" class="rounded" alt="item"
                                    src={{ $item->image ? url('storage/' . $item->image) : 'https://placehold.co/80' }}>
                            </a>
                        </td>
                        <td class="text-nowrap">{{ $item->categoryName }}</td>
                        <td class="text-nowrap">{{ $item->unitName }}</td>
                        <td class="text-nowrap text-right">{{ $item->unit_price }}</td>
                        <td class="text-nowrap text-right">{{ $item->price_A }}</td>
                        <td class="text-nowrap text-right">{{ $item->price_B }}</td>
                        <td class="text-nowrap">
                            <button
                                wire:click="$dispatch('item-edit', {id:{{ $item->id }}, categoryId:{{ $item->itemCategory->id }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {item:{{ $item }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->items->links() }}
</div>
