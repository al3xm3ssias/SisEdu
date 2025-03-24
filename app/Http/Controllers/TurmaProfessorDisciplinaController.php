<?php

// app/Http/Controllers/TurmaProfessorDisciplinaController.php

namespace App\Http\Controllers;

use App\Models\TurmaProfessorDisciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;





class TurmaProfessorDisciplinaController extends Controller
{
    public function store(Request $request)
{

    //dd($request->all());

 //   dd($request->all());
 $validatedData = $request->validate([
    'professor_id' => 'required|exists:professores,id',
    'turma_id' => 'required|exists:turmas,id',
    'disciplinas_id' => 'required|array',
    'disciplinas_id.*' => 'exists:disciplinas,id'
]);

//dd($validatedData);
    // Percorre cada disciplina e cria uma entrada separada para cada uma
    foreach ($validatedData['disciplinas_id'] as $disciplinaId) {
        TurmaProfessorDisciplinas::create([
            'professor_id' => $validatedData['professor_id'],
            'turma_id' => $validatedData['turma_id'],
            'disciplina_id' => $disciplinaId
        ]);
    }

    return redirect()->route('professores.index')->with('success', 'Professor cadastrado com sucesso!');
}




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

