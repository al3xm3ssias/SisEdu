<?php

// app/Http/Controllers/TurmaProfessorDisciplinaController.php

namespace App\Http\Controllers;

use App\Models\TurmaProfessorDisciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Professor;





class TurmaProfessorDisciplinaController extends Controller
{
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'professor_id' => 'required|exists:professores,id',
        'turma_disciplinas' => 'required|array',
        'turma_disciplinas.*.turma_id' => 'required|exists:turmas,id',
        'turma_disciplinas.*.disciplina_id' => 'required|exists:disciplinas,id',
    ]);

    foreach ($validatedData['turma_disciplinas'] as $row) {
        TurmaProfessorDisciplinas::create([
            'professor_id' => $validatedData['professor_id'],
            'turma_id' => $row['turma_id'],
            'disciplina_id' => $row['disciplina_id'],
        ]);
    }

    return redirect()->route('professores.index')->with('success', 'Professor cadastrado com sucesso!');
}


public function update(Request $request, $id)
{

  // dd($request->all());
    // Encontra o registro de Turma e Disciplina
    $turmaDisciplina = TurmaProfessorDisciplinas::findOrFail($id);

    // Obtém o professor associado à turma e disciplina
    $professor = $turmaDisciplina->professor;

    // Conta o número de disciplinas vinculadas ao professor
    $disciplinasCount = $professor->turmasDisciplinas->count();


  //  dd($disciplinasCount);
    // Verifica se a turma e a disciplina estão sendo removidas
    if ($request->has('turma_id') && $request->has('disciplinas_id')) {
        // Atualiza a relação, desassociando as disciplinas e turmas
        $turmaDisciplina->turma_id = $request->input('turma_id');
        $turmaDisciplina->disciplinas_id = $request->input('disciplinas_id');
        $turmaDisciplina->save();
    } else {
        // Caso contrário, remove a associação de turma e disciplina
        $turmaDisciplina->delete();
    }

 //   dd($disciplinasCount);

    // Verifica se o número de disciplinas vinculadas ao professor era 1
    if ($disciplinasCount == 1) {
        // Se for a última disciplina, redireciona para a lista de professores
        return redirect()->route('professores.index')
                         ->with('success', 'Este era o único vínculo do professor com uma disciplina. Redirecionando para a lista de professores.');
    }

    // Caso contrário, verifica se o professor ainda tem outras turmas e disciplinas associadas
    $professor->load('turmasDisciplinas');  // Recarrega a relação após a exclusão

    // Verifica se o professor ainda tem outras turmas e disciplinas associadas
    if ($professor->turmasDisciplinas->isEmpty()) {
        // Se não houver mais turmas e disciplinas associadas, redireciona para a lista de professores
        return redirect()->route('professores.index')
                         ->with('success', 'Todas as turmas e disciplinas foram excluídas. Redirecionando para a lista de professores.');
    }

    // Caso contrário, redireciona de volta para a página de edição do professor
    return redirect()->route('professores.edit', ['professor' => $professor->id])
                     ->with('success', 'Turma e Disciplina excluídas com sucesso.');
}

public function destroy($id)
{
    // Encontra o registro de Turma e Disciplina
    $turmaDisciplina = TurmaProfessorDisciplinas::findOrFail($id);

    // Exclui a relação de Turma e Disciplina
    $turmaDisciplina->delete();

    // Redireciona para a página de edição do professor com uma mensagem de sucesso
    return redirect()->route('professores.edit', $turmaDisciplina->professor_id)
                     ->with('success', 'Relação de Turma e Disciplina excluída com sucesso.');
}


 /*

public function destroy($id)
{
    // Encontra o registro de Turma e Disciplina
    $turmaDisciplina = TurmaProfessorDisciplinas::findOrFail($id);

    // Obtém o professor associado à turma e disciplina
    $professor = $turmaDisciplina->professor;

    // Conta o número de disciplinas vinculadas ao professor
    $disciplinasCount = $professor->turmasDisciplinas->count();

    // Exclui o registro de Turma e Disciplina
    $turmaDisciplina->delete();

    // Verifica se o número de disciplinas vinculadas ao professor era 1
    if ($disciplinasCount == 1) {
        // Se for a última disciplina, redireciona para a lista de professores
        return redirect()->route('professores.index')
                         ->with('success', 'Este era o único vínculo do professor com uma disciplina. Redirecionando para a lista de professores.');
    }

    // Caso contrário, verifica se o professor ainda tem outras turmas e disciplinas associadas
    $professor->load('turmasDisciplinas');

    // Verifica se o professor tem outras turmas e disciplinas associadas
    if ($professor->turmasDisciplinas->isEmpty()) {
        // Se não houver mais turmas e disciplinas associadas, redireciona para a lista de professores
        return redirect()->route('professores.index')
                         ->with('success', 'Todas as turmas e disciplinas foram excluídas. Redirecionando para a lista de professores.');
    }

    // Caso contrário, redireciona de volta para a página de edição do professor
    return redirect()->route('professores.edit', ['professor' => $professor->id])
                     ->with('success', 'Turma e Disciplina excluídas com sucesso.');
}  */


/*
public function updateTurmaDisciplina($id, Request $request)
{
    // Encontra o registro de Turma e Disciplina
    $turmaDisciplina = TurmaProfessorDisciplinas::findOrFail($id);

    // Obtém o professor associado à turma e disciplina
    $professor = $turmaDisciplina->professor;

    // Conta o número de disciplinas vinculadas ao professor
    $disciplinasCount = $professor->turmasDisciplinas->count();

    // Verifica se a turma e a disciplina estão sendo removidas
    if ($request->has('turma_id') && $request->has('disciplinas_id')) {
        // Atualiza a relação, desassociando as disciplinas e turmas
        $turmaDisciplina->turma_id = $request->input('turma_id');
        $turmaDisciplina->disciplinas_id = $request->input('disciplinas_id');
        $turmaDisciplina->save();
    } else {
        // Caso contrário, remove a associação de turma e disciplina
        $turmaDisciplina->delete();
    }

    // Verifica se o número de disciplinas vinculadas ao professor era 1
    if ($disciplinasCount == 1) {
        // Se for a última disciplina, redireciona para a lista de professores
        return redirect()->route('professores.index')
                         ->with('success', 'Este era o único vínculo do professor com uma disciplina. Redirecionando para a lista de professores.');
    }

    // Caso contrário, verifica se o professor ainda tem outras turmas e disciplinas associadas
    $professor->load('turmasDisciplinas');  // Recarrega a relação após a exclusão

    // Verifica se o professor ainda tem outras turmas e disciplinas associadas
    if ($professor->turmasDisciplinas->isEmpty()) {
        // Se não houver mais turmas e disciplinas associadas, redireciona para a lista de professores
        return redirect()->route('professores.index')
                         ->with('success', 'Todas as turmas e disciplinas foram excluídas. Redirecionando para a lista de professores.');
    }

    // Caso contrário, redireciona de volta para a página de edição do professor
    return redirect()->route('professores.edit', ['professor' => $professor->id])
                     ->with('success', 'Turma e Disciplina excluídas com sucesso.');
}



*/

    public function getDisciplinasPorTurma($turma_id)
    {
        // Recuperar a turma pelo ID
        $turma = Turma::find($turma_id);

        if (!$turma) {
            return response()->json(['message' => 'Turma não encontrada'], 404);
        }

        // Supondo que você tem uma relação de disciplinas com a turma, vamos buscar as disciplinas
        // Ajuste a relação conforme seu modelo de dados
        $disciplinas = $turma->disciplinas; // Assume que existe uma relação 'disciplinas'

        return response()->json($disciplinas);
    }
}

