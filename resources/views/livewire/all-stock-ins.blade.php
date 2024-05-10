<div>
    <h4 class="card-title">Stock In Products</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <button data-bs-target="#stockInModal" type="button" class="btn btn-success" data-bs-toggle="modal">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add Item to Stock In</span>
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
                            'colDisplay' => 'Quantity',
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
                @foreach ($this->stockIns as $stockIn)
                    <tr wire:key="{{ $stockIn->id }}">
                        <th scope="row">
                            {{ ($this->stockIns->currentpage() - 1) * $this->stockIns->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $stockIn->supplierName }}</td>
                        <td class="text-nowrap">{{ $stockIn->quantity }}</td>
                        <td class="text-nowrap">{{ $stockIn->code }}</td>
                        <td class="text-nowrap">{{ $stockIn->itemName }}</td>
                        <td class="text-nowrap">{{ $stockIn->description }}</td>
                        <td class="text-nowrap">{{ $stockIn->brandName }}</td>
                        <td class="text-nowrap">{{ $stockIn->categoryName }}</td>
                        <td class="text-nowrap">{{ $stockIn->unitName }}</td>
                        <td class="text-nowrap text-right">{{ \Carbon\Carbon::parse($stockIn->transact_date)->format('Y-m-d')}}</td>
                        <td class="text-nowrap text-right">{{ $stockIn->createdAt }}</td>
                        <td class="text-nowrap text-right">{{ $stockIn->updatedAt }}</td>
                        <td class="text-nowrap">
                            <button wire:click="$dispatch('stock-in-edit', {id:{{ $stockIn->id }}, details:{{ $stockIn }}})"
                                class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockInModal"><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</button>
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {stockIn:{{ $stockIn }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->stockIns->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.stockIn.code +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('stock-in-delete', {
                        id: event.stockIn.id,
                        quantity: event.stockIn.quantity,
                        inventory_id: event.stockIn.inventory_id
                    })
                }
            })
        })

        var modal = document.getElementById('stockInModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
            $wire.dispatch('reset-item-search');
        })
    </script>
@endscript

