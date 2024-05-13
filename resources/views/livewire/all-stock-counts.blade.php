<div>
    <h4 class="card-title">Stock Adjust Products</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#stockCountModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add Item to Stock Adjust</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    @include('product-stock.stock-count.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'quantity',
                            'colDisplay' => 'Qty',
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
                            'colName' => 'category',
                            'colDisplay' => 'Category',
                        ])
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'unit',
                            'colDisplay' => 'Unit',
                        ])
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'transaction_date',
                            'colDisplay' => 'Trasaction Date',
                        ])
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'period_from',
                            'colDisplay' => 'Period From',
                        ])
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'period_to',
                            'colDisplay' => 'Period To',
                        ])
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'created_at',
                            'colDisplay' => 'Created Date',
                        ])
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'updated_at',
                            'colDisplay' => 'Updated Date',
                        ])
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach ($this->stockCounts as $stockCount)
                    <tr wire:key="{{ $stockCount->id }}">
                        <th scope="row">
                            {{ ($this->stockCounts->currentpage() - 1) * $this->stockCounts->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-center">{{ $stockCount->quantity }}</td>
                        <td class="text-nowrap">{{ $stockCount->code }}</td>
                        <td class="text-nowrap">{{ $stockCount->itemName }}</td>
                        <td class="text-nowrap">{{ $stockCount->description }}</td>
                        <td class="text-nowrap">{{ $stockCount->brandName }}</td>
                        <td class="text-nowrap">{{ $stockCount->categoryName }}</td>
                        <td class="text-nowrap">{{ $stockCount->unitName }}</td>
                        <td class="text-nowrap text-right">{{ \Carbon\Carbon::parse($stockCount->transact_date)->format('Y-m-d')}}</td>
                        <td class="text-nowrap text-right">{{ \Carbon\Carbon::parse($stockCount->period_from)->format('Y-m-d')}}</td>
                        <td class="text-nowrap text-right">{{ \Carbon\Carbon::parse($stockCount->period_to)->format('Y-m-d')}}</td>
                        <td class="text-nowrap text-right">{{ $stockCount->createdAt }}</td>
                        <td class="text-nowrap text-right">{{ $stockCount->updatedAt }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('stock-count-edit', {id:{{ $stockCount->id }}, details:{{ $stockCount }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockCountModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {stockCount:{{ $stockCount }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->stockCounts->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.stockCount.code +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('stock-count-delete', {
                        id: event.stockCount.id,
                        quantity: event.stockCount.quantity,
                        inventory_id: event.stockCount.inventory_id
                    })
                }
            })
        })

        var modal = document.getElementById('stockCountModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
            $wire.dispatch('reset-item-search');
        })
    </script>
@endscript

