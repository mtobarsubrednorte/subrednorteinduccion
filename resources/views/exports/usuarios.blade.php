<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Subred</th>
            <th>Progreso (%)</th>
            <th>Certificados Emitidos</th>
            <th>Activo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->profile->name ?? 'Sin perfil' }}</td>
            <td>{{ $u->subred }}</td>
            <td>{{ $u->progreso }}</td>
            <td>{{ $u->certificados }}</td>
            <td>{{ $u->is_active ? 'Sí' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
