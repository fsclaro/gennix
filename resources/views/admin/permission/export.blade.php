<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome da Permissão</th>
            <th>Slug</th>
            <th>Papéis</th>
            <th>Cadastrado em</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->title }}</td>
            <td>{{ $permission->slug }}</td>
            <td>
                @foreach($permission->roles as $role)
                    @if($loop->last)
                    {{ $role->title }}
                    @else
                    {{ $role->title }},
                    @endif
                @endforeach
            </td>
            <td>{{ $permission->created_at->format("d/m/Y h:i:s") }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
