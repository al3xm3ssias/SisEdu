@extends('adminlte::page')

@section('title', 'Funcionários')

@section('content_header')
    <h1>Lista de Funcionários</h1>
@stop

@section('content')

    <table id="funcionariosTable" class="table table-striped table-bordered">

        @if(session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert" style="position: absolute; top: 10px; right: 10px; z-index: 9999;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').alert('close');
            }, 7000); // 7 segundos para desaparecer
        </script>
        @endif

        <a href="{{ route('funcionarios.create') }}" class="btn btn-primary mb-3">Adicionar Funcionário</a>

        <thead>
            <tr>
                <th>ID</th>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Turno</th>
                <th>Cargo</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($funcionarios as $funcionario)
                <tr>
                    <td>{{ $funcionario->id }}</td>
                    <td>{{ $funcionario->matricula }}</td>
                    <td>{{ $funcionario->nome }}</td>
                    <td>{{ $funcionario->turno->descricao ?? 'Não atribuído' }}</td>
                    <td>{{ $funcionario->cargo->nome ?? 'Não atribuído' }}</td>
                    <td>{{ $funcionario->tipo_funcionario == 0 ? 'Concursado' : 'Terceirizado' }}</td>
                    <td>
                        <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
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
        $('#funcionariosTable').DataTable({
            "language": {
                "sProcessing": "Processando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Nenhum registro encontrado",
                "sEmptyTable": "Nenhum dado disponível na tabela",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totais)",
                "sInfoPostFix": "",
                "sSearch": "Pesquisar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Carregando...",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": ativar para ordenar a coluna de forma ascendente",
                    "sSortDescending": ": ativar para ordenar a coluna de forma descendente"
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
            }, 2000);  // O alerta vai desaparecer após 2 segundos
        });
    </script>
@stop

@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop
