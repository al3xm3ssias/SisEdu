@extends('adminlte::page')

@section('title', 'Remover as Disciplinas')

@section('content_header')
    <h1>Remover as Disciplinas do Professor</h1>
@stop

@section('content')
<div class="container">
   

    <!-- Listar Turmas e Disciplinas Vinculadas -->
    <h3>Turmas e Disciplinas Vinculadas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Turma</th>
                <th>Disciplinas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relacoes->groupBy('turma.id') as $turmaId => $dados)
                <tr>
                    <td>{{ $dados->first()->turma->nome }}</td>
                    <td>
                        @foreach($dados as $relacao)
                            {{ $relacao->disciplina->nome }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        <!-- Formulário para remover a relação -->
                        <form action="{{ route('turma_professor_disciplinas.destroy', ['professor_id' => $professor->id, 'turma_id' => $dados->first()->turma->id]) }}" 
                            method="POST" 
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
@stop

@section('js')
<script>
    // Função para editar turma e disciplinas, caso necessário
    function editarTurmaDisciplina(turmaId) {
        document.getElementById('turma').value = turmaId;
    }
</script>
@stop


@section('footer')
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
@stop

