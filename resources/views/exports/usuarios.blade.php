<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Subred</th>
            <th>Estado Curso</th>
            <th>Progreso (%)</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Días para Finalizar</th>
            <th>Días en Curso</th>
            <th>Última Actividad</th>
            <th>Certificados</th>
            <th>Activo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->document_number ?? 'No registrado' }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->profile->name ?? 'Sin perfil' }}</td>
                <td>{{ $u->subred }}</td>
                <td>{{ $u->estado_curso }}</td>
                <td>{{ $u->progreso }}</td>

                <td>
                    {{ $u->inicio_curso
            ? \Carbon\Carbon::parse($u->inicio_curso)->format('d/m/Y H:i')
            : '—' }}
                </td>

                <td>
                    {{ $u->fin_curso
            ? \Carbon\Carbon::parse($u->fin_curso)->format('d/m/Y H:i')
            : '—' }}
                </td>

                <td>{{ $u->dias_finalizacion ?? '—' }}</td>
                <td>{{ $u->dias_en_curso ?? '—' }}</td>

                <td>
                    {{ $u->ultima_actividad
            ? \Carbon\Carbon::parse($u->ultima_actividad)->format('d/m/Y H:i')
            : '—' }}
                </td>

                <td>{{ $u->certificados }}</td>
                <td>{{ $u->is_active ? 'Sí' : 'No' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>