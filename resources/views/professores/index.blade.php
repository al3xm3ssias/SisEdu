@extends('adminlte::page')

@section('title', 'Lista de Professores')

@section('content_header')
    <h1>Lista de Professores</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert" style="position: absolute; top: 10px; right: 10px; z-index: 9999;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').alert('close');
            }, 7000);
        </script>
    @endif

    <a href="{{ route('professores.create') }}" class="btn btn-primary mb-3">Adicionar Professor</a>

    <table id="professoresTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professores as $index => $professor)
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Contador automático -->
                    <td>{{ $professor->nome }}</td>
                    <td>
                        <a href="{{ route('professores.show', $professor->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('professores.edit', $professor->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pencil-alt"></i> Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $('#professoresTable').DataTable({
            "language": {
                "sProcessing": "Processando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Nenhum registro encontrado",
                "sEmptyTable": "Nenhum dado disponível na tabela",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totais)",
                "sSearch": "Pesquisar:",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                }
            },
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 2000);
        });
    </script>
@stop

@section('footer')
    <strong>Feito por Alex Messias <a href="https://adminlte.io">SisEdu</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
