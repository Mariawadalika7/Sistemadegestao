@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <h1>Lista de Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">Adicionar Cliente</a>
@endsection
@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <h1>Lista de Clientes</h1>
@endsection

@push('scripts')
    <script>
        console.log("Página de clientes carregada");
    </script>
@endpush
