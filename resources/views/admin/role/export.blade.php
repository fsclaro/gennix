<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome do Papel</th>
            <th>Permissões</th>
            <th>Usuários</th>
            <th>Cadastrado em</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->title }}</td>
            <td>
                @foreach($role->permissions as $permission)
                    @if($loop->last)
                    {{ $permission->title }}
                    @else
                    {{ $permission->title }},
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($role->users as $user)
                    @if($loop->last)
                    {{ $user->name }}
                    @else
                    {{ $user->name }},
                    @endif
                @endforeach
            </td>
            <td>{{ $role->created_at->format("d/m/Y h:i:s") }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
