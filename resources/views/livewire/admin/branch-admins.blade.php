
    <div class="main-content">
        <div class="header">
            <h1>Branch Admins Management</h1>
            <button class="btn btn-primary" wire:click="create()">Create New Branch Admin</button>
        </div>

        @if($isOpen)
            @include('livewire.admin.create-branch-admin')
        @endif

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            <button class="btn btn-secondary btn-small" wire:click="edit({{ $user->id }})">Edit</button>
                            <button class="btn btn-danger btn-small" wire:click="delete({{ $user->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
