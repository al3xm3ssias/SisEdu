<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Disciplina;

class ProfessorController extends Controller
{
    public function index()
    { /*
        $professores = Professor::with('turmas', 'disciplinas')->get();
        return view('professores.index', compact('professores')); */

        $professores = Professor::all();
        return view('professores.index', compact('professores'));
    }

    public function create()
    {
        $turmas = Turma::all();
        $professores = Professor::all();
        $disciplinas = collect();
        return view('professores.create', compact('turmas', 'professores', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $professor = Professor::create([
            'nome' => $request->nome,
        ]);

        if ($request->turma_id && $request->disciplinas) {
            $professor->turmas()->attach($request->turma_id);
            foreach ($request->disciplinas as $disciplina) {
                $professor->disciplinas()->attach($disciplina, ['turma_id' => $request->turma_id]);
            }
        }

        return redirect()->route('professores.index')->with('success', 'Professor cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $turmas = Turma::all();
        return view('professores.edit', compact('professor', 'turmas'));
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);
        $professor->update([
            'nome' => $request->nome,
        ]);

        $professor->turmas()->sync($request->turma_id);
        $professor->disciplinas()->detach();
        foreach ($request->disciplinas as $disciplina) {
            $professor->disciplinas()->attach($disciplina, ['turma_id' => $request->turma_id]);
        }

        return redirect()->route('professores.index')->with('success', 'Professor atualizado com sucesso!');
    }


    public function destroy(Professor $professor)
    {
        $professor->turmas()->detach();
        $professor->disciplinas()->detach();
        $professor->delete();

        return redirect()->route('professores.index')->with('success', 'Professor excluído com sucesso!');
    }

   // app/Http/Controllers/ProfessorController.php

public function getDisciplinasByProfessor($professorId)
{
    // Consulta as disciplinas relacionadas ao professor usando a tabela intermediária
    $disciplinas = DB::table('disciplinas')
                    ->join('turma_disciplinas', 'disciplinas.id', '=', 'turma_disciplinas.disciplina_id')
                    ->join('professor_disciplina', 'turma_disciplinas.id', '=', 'professor_disciplina.turma_disciplina_id')
                    ->where('professor_disciplina.professor_id', $professorId)
                    ->select('disciplinas.id', 'disciplinas.nome')
                    ->get();

    // Retorna as disciplinas em formato JSON
    return response()->json($disciplinas);
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

