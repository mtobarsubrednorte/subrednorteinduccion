<table class="table-auto w-full">
  <thead>
    <tr><th>Usuario</th><th>Completados</th><th>Total</th></tr>
  </thead>
  <tbody>
    @foreach($report as $r)
      <tr>
        <td>{{ $r->user->name }}</td>
        <td>{{ $r->modulos_completos }}</td>
        <td>{{ $r->total_modulos }}</td>
      </tr>
    @endforeach
  </tbody>
</table>