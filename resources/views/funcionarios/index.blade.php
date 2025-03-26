@extends('adminlte::page')

@section('title', 'Funcionários')


@section('content')

    <!-- Card para tabela -->
    <div class="card shadow-lg">
        <div class="card-header text-black d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Funcionários Cadastrados</h4>
            <a href="{{ route('funcionarios.create') }}"  class="btn btn-outline-primary btn-sm ml-auto d-flex align-items-center">➕ Adicionar Funcionário</a>
        </div>

        <div class="card-body">
            <table id="funcionariosTable" class="table table-striped table-bordered">
                <thead class="thead-dark">
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
                    @foreach($funcionarios as $index => $funcionario)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Contador de 1 até N -->
                            <td>{{ $funcionario->matricula }}</td>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ $funcionario->turno->descricao ?? 'Não atribuído' }}</td>
                            <td>{{ $funcionario->cargo->nome ?? 'Não atribuído' }}</td>
                            <td>{{ $funcionario->tipo_funcionario == 0 ? 'Concursado' : 'Terceirizado' }}</td>
                            <td>
                                <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação e Barra de Pesquisa -->
        

    </div>

@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#funcionariosTable').DataTable({
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
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "initComplete": function() {
        // Personalizando o alinhamento da barra de pesquisa
        $('.dataTables_filter').css({'display': 'inline-block', 'text-align': 'right'});
    }
});

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
