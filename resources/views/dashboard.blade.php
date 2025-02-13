@isset($totalClientes)
    <p>Total de Clientes: {{ $totalClientes }}</p>
@else
    <p>Nenhum cliente encontrado.</p>
@endisset
