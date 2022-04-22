<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>Validity</th>
            <th>Role For</th>
            <th>Default</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->price }}</td>
            <td>{{ $role->validity }}</td>
            @php ($role->role_for == '0') ? $rFor = "System User" : $rFor = "General User"; @endphp
            <td>{{ $rFor }}</td>
            @php ($role->is_default == '1') ? $default = "Yes" : $default = "No"; @endphp
            <td>{{ $default }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
