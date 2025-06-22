<div class="overflow-x-auto">
    <table class="table table-zebra">
        <!-- head -->
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>
                        <div class="avatar">
                            <div class="w-12 rounded">
                                <img
                                    src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&bold=true" />
                            </div>
                        </div>
                    </th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button class="btn btn-secondary">Edit</button>
                        <button class="btn btn-error">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
