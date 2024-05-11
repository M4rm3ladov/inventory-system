<div>
    <h4 class="card-title">Stock Return Products</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#stockReturnModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add Item to Return</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    @include('product-stock.stock-in.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'supplier',
                            'colDisplay' => 'Supplier',
                        ])
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
                @foreach ($this->stockReturns as $stockReturn)
                    <tr wire:key="{{ $stockReturn->id }}">
                        <th scope="row">
                            {{ ($this->stockReturns->currentpage() - 1) * $this->stockReturns->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $stockReturn->supplierName }}</td>
                        <td class="text-center">{{ $stockReturn->quantity }}</td>
                        <td class="text-nowrap">{{ $stockReturn->code }}</td>
                        <td class="text-nowrap">{{ $stockReturn->itemName }}</td>
                        <td class="text-nowrap">{{ $stockReturn->description }}</td>
                        <td class="text-nowrap">{{ $stockReturn->brandName }}</td>
                        <td class="text-nowrap">{{ $stockReturn->categoryName }}</td>
                        <td class="text-nowrap">{{ $stockReturn->unitName }}</td>
                        <td class="text-nowrap text-right">{{ \Carbon\Carbon::parse($stockReturn->transact_date)->format('Y-m-d')}}</td>
                        <td class="text-nowrap text-right">{{ $stockReturn->createdAt }}</td>
                        <td class="text-nowrap text-right">{{ $stockReturn->updatedAt }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('stock-return-edit', {id:{{ $stockReturn->id }}, details:{{ $stockReturn }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockReturnModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {stockReturn:{{ $stockReturn }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->stockReturns->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.stockReturn.code +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('stock-return-delete', {
                        id: event.stockReturn.id,
                        quantity: event.stockReturn.quantity,
                        inventory_id: event.stockReturn.inventory_id
                    })
                }
            })
        })

        var modal = document.getElementById('stockReturnModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
            $wire.dispatch('reset-item-search');
        })
    </script>
@endscript


