<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\TurmaProfessorDisciplinas;

class ProfessorController extends Controller
{
  
    // Carregar os professores com suas turmas e disciplinas associadas
    public function index()
    {
        // Busca apenas professores que possuem disciplinas associadas
        $professores = Professor::whereHas('disciplinas')->get();
    
        return view('professores.index', compact('professores'));
    }


    public function create()
    {
        $turmas = Turma::orderBy('nome', 'asc')->get();
        $professores = Professor::orderBy('nome', 'asc')->get();
        $disciplinas = collect();
        return view('professores.create', compact('turmas', 'professores', 'disciplinas'));
    }

    /*public function store(Request $request)
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
    } */
    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $turmas = Turma::all();
        $disciplinas = Disciplina::all();
        // Buscar todas as turmas e disciplinas associadas ao professor
       $relacoes = TurmaProfessorDisciplinas::where('professor_id', $professor->id)
            ->with(['turma', 'disciplina']) // Certifique-se de ter esses relacionamentos no modelo
            ->get(); 
        
        //dd($relacoes);
        return view('professores.edit', compact('professor', 'relacoes', 'turmas', 'disciplinas'));
    }

    public function show($id)
{
    // Busca o professor pelo ID
    $professor = Professor::findOrFail($id);

    // Busca todas as relações específicas de professor, turma e disciplina
    $relacoes = TurmaProfessorDisciplinas::where('professor_id', $id)
        ->with(['turma', 'disciplina']) 
        ->get();

    return view('professores.show', compact('professor', 'relacoes'));
}
    

    




    


    



   /*public function update(Request $request, $id)
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
    } */


  /*  public function destroy(Professor $professor)
    {
        $professor->turmas()->detach();
        $professor->disciplinas()->detach();
        $professor->delete();

        return redirect()->route('professores.index')->with('success', 'Professor excluído com sucesso!');
    }
 */
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

    // Buscar as disciplinas associadas à turma, ordenadas por nome
    $disciplinas = $turma->disciplinas()->orderBy('nome', 'asc')->get(); // 'asc' para ordem alfabética crescente

    return response()->json($disciplinas);
}


 


}

