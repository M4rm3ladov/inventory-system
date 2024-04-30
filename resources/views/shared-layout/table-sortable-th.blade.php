<th scope="col" data-sortable="true" wire:click="setSortBy('{{ $colName }}')">
    @if ($sortBy !==  $colName)
        <i class="fa fa-sort mr-1"></i>
    @elseif ($sortDirection == 'ASC')
        <i class="fa fa-sort-up mr-1"></i>
    @else
        <i class="fa fa-sort-down mr-1"></i>
    @endif
    <span>{{ $colDisplay }}<span>
</th>
