<div>
    <h4 class="card-title">List of System Users</h4>
    {{-- action buttons --}}
    <div class="mt-4">
        <a href="{{ route('register') }}" role="button" class="btn btn-success">
            <i class="fa fa-add"></i>
            <span class="ms-1">Add a New User</span>
        </a>
    </div>
    {{-- table filter --}}
    @include('system-user.search')
    {{-- content table --}}
    <div class="table-scroll-x table-responsive overflow-scroll mt-3" style="height: 500px;">
        <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</h>
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'name',
                        'colDisplay' => 'Name',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'email',
                        'colDisplay' => 'Email',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'role',
                        'colDisplay' => 'Role',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'branch',
                        'colDisplay' => 'Branch',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'created_at',
                        'colDisplay' => 'Created',
                    ])
                    @include('shared-layout.table-sortable-th', [
                        'colName' => 'updated_at',
                        'colDisplay' => 'Updated',
                    ])
                    <th scope="col" data-sortable="true">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->users as $user)
                    <tr wire:key="{{ $user->id }}">
                        <th scope="row">
                            {{ ($this->users->currentpage() - 1) * $this->users->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="text-nowrap">{{ $user->userName }}</td>
                        <td class="text-nowrap">{{ $user->email }}</td>
                        <td class="text-nowrap">{{ $user->roleName }}</td>
                        <td class="text-nowrap">{{ $user->branchName }}</td>
                        <td class="text-nowrap">{{ $user->created_at }}</td>
                        <td class="text-nowrap text-right">{{ $user->updated_at }}</td>
                        <td class="text-nowrap">
                            <a  href="{{ route('users.edit', $user->id) }}"
                                class="btn btn-sm btn-primary" ><i
                                    class="fa fa-pen-to-square me-1"></i>Edit</a>
                            <button type="button"
                                wire:click="$dispatch('delete-prompt', {user:{{ $user }}})"
                                class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $this->users->links() }}
</div>
@script
    <script>
        $wire.on('delete-prompt', (event) => {
            swal.fire({
                title: 'Are you sure?',
                html: "You're about to delete <strong>" + event.user.first_name.concat(" ", event.user.last_name) +
                    "</strong>. This action is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C82333',
                cancelButtonColor: '#5A6268',
                confirmButtonText: 'Delete record'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('user-delete', {
                        id: event.user.id
                    })
                }
            })
        })

        var modal = document.getElementById('userModal')
        modal.addEventListener('hidden.bs.modal', (event) => {
            $wire.dispatch('reset-modal')
        })
    </script>
@endscript
