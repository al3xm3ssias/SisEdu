<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeAula;
use App\Models\TurmaProfessorDisciplinas;
use App\Models\Turma;
use App\Models\Professor;
use App\Models\Disciplina;



class GradeAulaController extends Controller
{
    public function index()
{
    // Obtenha as grades, talvez incluindo a turma associada
    $turmas = Turma::with('disciplinas')->get();
    $grades = GradeAula::with('turma')->get();

   // dd($grades);

    return view('grade_aulas.index', compact('turmas', 'grades'));
}

public function create($id)
{
    $turma = Turma::find($id); // Pegue a turma correta dinamicamente

    if (!$turma) {
        return redirect()->back()->with('error', 'Turma não encontrada');
    }
    
    // Obtenha as disciplinas associadas à turma utilizando a relação já definida no modelo
    $disciplinas = $turma->disciplinas()->orderBy('nome')->get(); // Agora traz apenas as disciplinas vinculadas à turma

    $horarios = [
        ['inicio' => '07:45', 'fim' => '09:45'],
        ['inicio' => '09:45', 'fim' => '11:45'],
        ['inicio' => '12:45', 'fim' => '14:45'],
        ['inicio' => '14:45', 'fim' => '16:45'],
    ]; // Lista de horários fixos (ou carregue do banco)

    return view('grade_aulas.create', compact('turma', 'disciplinas', 'horarios'));
}

public function store(Request $request)
{
    // Recebe as disciplinas do formulário
    $disciplinas = $request->input('disciplinas'); 

    if ($disciplinas) {
        // Loop para iterar sobre os horários e disciplinas
        foreach ($disciplinas as $horario => $dias) {
            foreach ($dias as $dia => $disciplina_id) {
                // Salvar a disciplina associada ao horário e ao dia
                // Por exemplo, criar um registro de GradeAulaTurma:

               // dd($request->input('turma_id'));
                GradeAula::create([
                    'turma_id' => $request->input('turma_id'),  // Assumindo que você tem uma turma_id no request
                    'horario' => $horario,
                    'dia_semana' => $dia,
                    'disciplina_id' => $disciplina_id,
                ]);
            }
        }
        return redirect()->route('grade_aulas.index')->with('success', 'Grade salva com sucesso!');
    } else {
        return back()->with('error', 'Por favor, selecione as disciplinas para todos os horários.');
    }
}
}
