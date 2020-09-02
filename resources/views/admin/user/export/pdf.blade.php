<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Relação de Usuários</title>

    <style>
        h2 {
            background-color: blue;
            color: white;
            height: 40px;
            border-radius: 5px;
            text-align: center;
            font-size: 26px;
        }

        table {
            width: 100%;
            border-spacing: 0px;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body>
    <h2 class="title">Relação de Usuários</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 200px;">Nome do Usuário</th>
                <th>E-mail</th>
                <th>Ativo?</th>
                <th>SuperAdmin?</th>
                <th>Sexo</th>
                <th>Posição/Função</th>
                <th>Telefone</th>
                <th>Papel</th>
                <th>Cadastrado em</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="text-center">{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-center">@if( $user->active ) Sim @else Não @endif</td>
                <td class="text-center">@if( $user->is_superadmin ) Sim @else Não @endif</td>
                <td class="text-center">{{ $user->gender }}</td>
                <td>{{ $user->position }}</td>
                <td>{{ $user->phone }}</td>
                <td>@if($user->is_superadmin) SuperAdmin @else {{ $user->roles[0]->title }}@endif</td>
                <td class="text-center">{{ $user->created_at->format("d/m/Y h:i:s") }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
