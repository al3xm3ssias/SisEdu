@extends('adminlte::page')

@section('title', 'Professores')

@section('content_header')
    <h1 class="text-center"> Lista de Professores</h1>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-header text-black d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Professores</h3>
            <a href="{{ route('professores.create') }}" class="btn btn-outline-primary btn-sm ml-auto d-flex align-items-center">➕ Novo Professor</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        $('.alert').fadeOut('slow');
                    }, 2000);
                </script>
            @endif

            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>#</th>
                        <th>👩‍🏫 Nome</th>
                        <th>⚙️ Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($professores as $index => $professor)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $professor->nome }}</td>
                            <td>
                                <a href="{{ route('professores.show', $professor->id) }}" class="btn btn-info btn-sm"> Ver</a>
                                <a href="{{ route('professores.edit', $professor->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
