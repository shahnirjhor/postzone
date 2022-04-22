<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Role</th>
            <th>Register Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRoleNames()->first() }}</td>
            <td>{{ date($companyDateFormat, strtotime($user->created_at)) }}</td>
            @php ($user->status == '1') ? $status = "Active" : $status = "Inactive"; @endphp
            <td>{{ $status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
