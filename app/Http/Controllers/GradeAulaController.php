<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeAula;
use App\Models\TurmaProfessorDisciplinas;
use App\Models\Turma;
use App\Models\Professor;
use App\Models\Disciplina;
use App\Models\Recreio;

use \DateTime;
use \DateInterval;
use Carbon\Carbon;



class GradeAulaController extends Controller
{
    public function index(Request $request)
{
    $anoLetivoId = session('ano_letivo_id'); // Pegando o ano letivo da sessão

    $tamanhoMax = $request->input('tamanho_max', 5); 

    // Recupera as turmas que possuem pelo menos uma grade associada ao ano letivo selecionado
    $turmasComGrade = Turma::whereHas('grades', function ($query) use ($anoLetivoId) {
        $query->where('ano_letivo_id', $anoLetivoId);
    })->get();

    // Filtra as turmas e suas disciplinas com base no ano letivo
    $turmas = Turma::with('disciplinas')->orderBy('nome', 'asc')->get();

    // Retorna a view passando os dados filtrados
    return view('grade_aulas.index', compact('turmasComGrade', 'turmas', 'tamanhoMax'));
}

public function create(Request $request)
{
    $turma_id = $request->query('turma_id');
    $turma = Turma::findOrFail($turma_id);
    $tamanhoMax = $request->input('tamanho_max', 5);
    $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
    
    // Recupera todas as disciplinas da turma
    $disciplinas = Disciplina::whereHas('turmas', function ($query) use ($turma_id) {
        $query->where('turmas.id', $turma_id);
    })->orderBy('nome', 'asc')->get();


    //$recreiosTurma = Recreio::findOrFail($turma_id);
    // Recupera todos os recreios disponíveis
    //$recreios = \App\Models\Recreio::all();

   //dd($recreios);
    
    /*$recreiosTurma = \DB::table('recreio_turma')
    ->join('recreios', 'recreio_turma.recreio_id', '=', 'recreios.id')
    ->select('recreio_turma.id as recreio_turma_id', 'recreios.nome', 'recreios.inicio', 'recreios.fim')
    ->where('recreio_turma.turma_id', $turma_id)
    ->get(); */


    $recreiosTurma = $turma->recreios;

   // dd($recreiosTurma);
 
// Formata os recreios para exibição, incluindo o recreio_turma_id
$formatarHorarios = function ($recreiosTurma) {
    return $recreiosTurma->map(function ($rec) {
        return [
            'recreio_turma_id' => $rec->id, // Certifique-se de incluir o ID do recreio_turma
            'nome' => $rec->nome,
            'inicio' => (new \DateTime($rec->inicio))->format('H:i'),
            'fim' => (new \DateTime($rec->fim))->format('H:i')
        ];
    });
};





    $recreiosTurma = $formatarHorarios($recreiosTurma);
    //$recreios = $formatarHorarios($recreios);

    //dd($recreiosTurma);

    // Inicializa a grade vazia para edição manual
    $schedule = [];
    foreach ($diasSemana as $dia) {
        $schedule[$dia] = [
            'manha' => [],
            'tarde' => []
        ];
    }
    
    //dd($recreiosTurma, $recreios);

    return view('grade_aulas.create', compact('schedule', 'turma_id', 'diasSemana', 'disciplinas', 'recreiosTurma', 'tamanhoMax'));
}
public function store(Request $request)
{
    $dados = $request->input('schedule'); // Array de horários por dia
    $turma_id = $request->input('turma_id');

    //dd($request); 

/*
    foreach ($dados as $dia => $horarios) {
        foreach ($horarios as $horario) {
            if (isset($horario['inicio'], $horario['fim'])) {
                $inicio = Carbon::createFromFormat('H:i:s', $horario['inicio']);
                $fim = Carbon::createFromFormat('H:i:s', $horario['fim']);
    
                if ($fim->lessThanOrEqualTo($inicio)) {
                    return redirect()->back()->with('error', "O horário de fim não pode ser menor ou igual ao início ($dia).");
                }
            }
        }
    }
 */





    foreach ($dados as $dia => $horarios) {
        foreach ($horarios as $i => $horario) {
            if (isset($horario['disciplina'])) {
                $disciplinaId = $horario['disciplina'];
                $isRecreio = isset($horario['is_recreio']) && $horario['is_recreio'] == 1;

                if ($isRecreio) {
                    // Lida com recreios
                    $recreioTurmaId = $disciplinaId; 

                    $recreioTurma = \DB::table('recreio_turma')
                        ->where('turma_id', $turma_id)
                        ->where('recreio_id', $recreioTurmaId)
                        ->first();


                    
                    //dd($turma_id); 


                    //$recreioTurma =  $recreioTurmaId;

                    if ($recreioTurma) {
                        GradeAula::create([
                            'turma_id' => $turma_id,
                            'disciplina_id' => null,
                            'recreio_turma_id' => $recreioTurma->id,
                            'dia_semana' => $dia,
                            'hora_inicio' => $horario['inicio'],
                            'hora_fim' => $horario['fim'],
                            'ano_letivo_id' => session('ano_letivo_id'), // Pegando da sessão
                            'duracao' => Carbon::createFromFormat('H:i', $horario['inicio'])
                                ->diffInMinutes(Carbon::createFromFormat('H:i', $horario['fim'])),
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'Recreio não encontrado para a turma selecionada!');
                    }
                } else {
                    // Lida com aulas
                    $disciplina = Disciplina::find($disciplinaId);

                    if ($disciplina) {
                        GradeAula::create([
                            'turma_id' => $turma_id,
                            'disciplina_id' => $disciplina->id,
                            'recreio_turma_id' => null,
                            'dia_semana' => $dia,
                            'hora_inicio' => $horario['inicio'],
                            'hora_fim' => $horario['fim'],
                            'ano_letivo_id' => session('ano_letivo_id'), // Pegando da sessão
                            'duracao' => Carbon::createFromFormat('H:i', $horario['inicio'])
                                ->diffInMinutes(Carbon::createFromFormat('H:i', $horario['fim'])),
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'Disciplina não encontrada!');
                    }
                }
            }
        }
    }

    return redirect()->route('grade_aulas.index')->with('success', 'Grade de aulas salva com sucesso!');
}







public function show(Request $request, $id)
{
    // Lógica para buscar os dados necessários
    $turma = Turma::findOrFail($id);
    $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
    
    // Aqui você organiza a grade por dia da semana
    $schedule = GradeAula::where('turma_id', $turma->id)
                         ->orderBy('hora_inicio')
                         ->get()
                         ->groupBy('dia_semana'); // Agrupa as aulas por dia da semana

    $disciplinas = Disciplina::all();
    $recreiosTurma = $turma->recreios;

    return view('grade_aulas.show', compact('turma', 'diasSemana', 'schedule', 'disciplinas', 'recreiosTurma'));
}


public function edit($turma_id)
{
    $turma = Turma::findOrFail($turma_id);
    $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];

    // Recupera todas as disciplinas da turma
    $disciplinas = Disciplina::whereHas('turmas', function ($query) use ($turma_id) {
        $query->where('turmas.id', $turma_id);
    })->orderBy('nome', 'asc')->get();

    // Recupera os recreios da turma
    $recreiosTurma = $turma->recreios->map(function ($rec) {
        return [
            'recreio_turma_id' => $rec->id,
            'nome' => $rec->nome,
            'inicio' => (new \DateTime($rec->inicio))->format('H:i'),
            'fim' => (new \DateTime($rec->fim))->format('H:i')
        ];
    });

    // Recupera a grade de aulas existente
    $gradeAulas = GradeAula::where('turma_id', $turma_id)
        ->where('ano_letivo_id', session('ano_letivo_id'))
        ->get();

    // Define o tamanho máximo como a quantidade de registros para o dia 'Segunda'
    $tamanhoMax = GradeAula::where('turma_id', $turma_id)
        ->where('ano_letivo_id', session('ano_letivo_id'))
        ->where('dia_semana', 'Segunda')
        ->count();

   
        $schedule = [];
    foreach ($gradeAulas as $aula) {
        $schedule[$aula->dia_semana][] = [
            'id' => $aula->id,
            'disciplina' => $aula->disciplina_id,
            'recreio_turma_id' => $aula->recreio_turma_id,
            'inicio' => $aula->hora_inicio,
            'fim' => $aula->hora_fim,
            'is_recreio' => $aula->recreio_turma_id ? true : false
        ];
    }


    //dd($gradeAulas);
    return view('grade_aulas.edit', compact('schedule', 'turma_id', 'diasSemana', 'disciplinas', 'recreiosTurma', 'tamanhoMax', 'turma'));
}

public function update(Request $request, $turma_id)
{
    $dados = $request->input('schedule');


    //dd($dados);

    // Remove todas as entradas da grade antes de atualizar
    GradeAula::where('turma_id', $turma_id)
        ->where('ano_letivo_id', session('ano_letivo_id'))
        ->delete();

    foreach ($dados as $dia => $horarios) {
        foreach ($horarios as $horario) {
            if (isset($horario['disciplina'])) {
                $isRecreio = isset($horario['is_recreio']) && $horario['is_recreio'] == 1;

                if ($isRecreio) {
                    $recreioTurmaId = $horario['disciplina'];
                    $recreioTurma = \DB::table('recreio_turma')
                        ->where('turma_id', $turma_id)
                        ->where('recreio_id', $recreioTurmaId)
                        ->first();

                    if ($recreioTurma) {
                        GradeAula::create([
                            'turma_id' => $turma_id,
                            'disciplina_id' => null,
                            'recreio_turma_id' => $recreioTurma->id,
                            'dia_semana' => $dia,
                            'hora_inicio' => $horario['inicio'],
                            'hora_fim' => $horario['fim'],
                            'ano_letivo_id' => session('ano_letivo_id'),
                            'duracao' => Carbon::createFromFormat('H:i:s', $horario['inicio'])  
                                ->diffInMinutes(Carbon::createFromFormat('H:i:s', $horario['fim'])),
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'Recreio não encontrado para a turma!');
                    }
                } else {
                    $disciplina = Disciplina::find($horario['disciplina']);
                    if ($disciplina) {
                        GradeAula::create([
                            'turma_id' => $turma_id,
                            'disciplina_id' => $disciplina->id,
                            'recreio_turma_id' => null,
                            'dia_semana' => $dia,
                            'hora_inicio' => $horario['inicio'],
                            'hora_fim' => $horario['fim'],
                            'ano_letivo_id' => session('ano_letivo_id'),
                            'duracao' => Carbon::createFromFormat('H:i:s', $horario['inicio'])  
                            ->diffInMinutes(Carbon::createFromFormat('H:i:s', $horario['fim'])),
                        ]);
                    } else {
                        return redirect()->back()->with('error', 'Disciplina não encontrada!');
                    }
                }
            }
        }
    }

    return redirect()->route('grade_aulas.index')->with('success', 'Grade de aulas atualizada com sucesso!');
}









public function destroy($turma_id)
{
    // Buscar todas as grades da turma
    $grades = GradeAula::where('turma_id', $turma_id)->get();

    // Verificar se existem registros antes de excluir
    if ($grades->isEmpty()) {
        return redirect()->route('grade_aulas.index')->with('warning', 'Nenhuma grade encontrada para essa turma.');
    }

    // Excluir todas as grades vinculadas à turma
    GradeAula::where('turma_id', $turma_id)->delete();

    return redirect()->route('grade_aulas.index')->with('success', 'Todas as grades da turma foram excluídas com sucesso!');
}




}
