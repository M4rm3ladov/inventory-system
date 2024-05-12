
<div>
    <h4 class="card-title">Stock Transfer Products</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#stockTransferModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add Item to Stock Transfer</span>
        </button>
        @include('shared-layout.export-buttons')
    </div>
    @include('product-stock.stock-transfer.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
                        @include('shared-layout.table-sortable-th', [
                            'colName' => 'branchTo',
                            'colDisplay' => 'Branch Transferred',
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
                @foreach ($this->stockTransfers as $stockTransfer)
                    <tr wire:key="{{ $stockTransfer->id }}">
                        <th scope="row">
                            {{ ($this->stockTransfers->currentpage() - 1) * $this->stockTransfers->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $stockTransfer->branchTo }}</td>
                        <td class="text-center">{{ $stockTransfer->quantity }}</td>
                        <td class="text-nowrap">{{ $stockTransfer->code }}</td>
                        <td class="text-nowrap">{{ $stockTransfer->itemName }}</td>
                        <td class="text-nowrap">{{ $stockTransfer->description }}</td>
                        <td class="text-nowrap">{{ $stockTransfer->brandName }}</td>
                        <td class="text-nowrap">{{ $stockTransfer->categoryName }}</td>
                        <td class="text-nowrap">{{ $stockTransfer->unitName }}</td>
                        <td class="text-nowrap text-right">{{ \Carbon\Carbon::parse($stockTransfer->transact_date)->format('Y-m-d')}}</td>
                        <td class="text-nowrap text-right">{{ $stockTransfer->createdAt }}</td>
                        <td class="text-nowrap text-right">{{ $stockTransfer->updatedAt }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('stock-transfer-edit', {id:{{ $stockTransfer->id }}, details:{{ $stockTransfer }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockTransferModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {stockTransfer:{{ $stockTransfer }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->stockTransfers->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.stockTransfer.code +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('stock-transfer-delete', {
                        id: event.stockTransfer.id,
                        branch_id_to: event.stockTransfer.branch_id_to,
                        item_id: event.stockTransfer.item_id,
                        quantity: event.stockTransfer.quantity,
                        inventory_id: event.stockTransfer.inventory_id
                    })
                }
            })
        })

        var modal = document.getElementById('stockTransferModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
            $wire.dispatch('reset-item-search');
        })
    </script>
@endscript

