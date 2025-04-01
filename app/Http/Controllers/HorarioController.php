<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Turma;
use App\Models\GradeAula;

use App\Models\AnoLetivo;


use Carbon\Carbon;


use Illuminate\Support\Facades\Log;



class HorarioController extends Controller
{
    public function index()
{
    // Consultando a tabela grade_aulas e incluindo a turma e a disciplina
     // Consultando as turmas
     $turmas = Turma::orderBy('nome', 'asc')->get();  // Pode ser filtrado de acordo com suas necessidades
    
     // Consultando as aulas (apenas para a exibição inicial sem filtro)
     $gradeAulas = GradeAula::with('turma', 'disciplina')->orderBy('dia_semana')->get();
     
     // Passando as turmas e aulas para a view
     return view('calendario', compact('turmas', 'gradeAulas'));
}




public function getHorarios($turmaId)
{
    // Pegando o ID do ano letivo na sessão
    $anoLetivoId = session('ano_letivo_id');

    // Buscando o ano letivo no banco
    $anoLetivo = AnoLetivo::find($anoLetivoId);

    if (!$anoLetivo) {
        return response()->json(['error' => 'Ano letivo não encontrado'], 404);
    }

    // Datas do ano letivo
    $inicioAnoLetivo = Carbon::parse($anoLetivo->inicio);
    $fimAnoLetivo = Carbon::parse($anoLetivo->fim);

    // Consultando as aulas da turma na grade
    $gradeAulas = GradeAula::with('disciplina', 'recreio', 'turma')
        ->where('turma_id', $turmaId)
        ->where('ano_letivo_id', $anoLetivoId) // Filtrando pelo ano letivo
        ->get();

    $diasDaSemana = [
        'Segunda' => Carbon::MONDAY,
        'Terça' => Carbon::TUESDAY,
        'Quarta' => Carbon::WEDNESDAY,
        'Quinta' => Carbon::THURSDAY,
        'Sexta' => Carbon::FRIDAY,
    ];

    $eventos = $gradeAulas->flatMap(function ($aula) use ($inicioAnoLetivo, $fimAnoLetivo, $diasDaSemana) {
        $eventos = [];

        // Se o dia da semana for inválido, ignora essa entrada
        if (!isset($diasDaSemana[$aula->dia_semana])) {
            return [];
        }

        $diaSemanaNumero = $diasDaSemana[$aula->dia_semana];

        // Encontrando a primeira ocorrência do dia da semana dentro do ano letivo
        $dataInicio = $inicioAnoLetivo->copy();
        while ($dataInicio->dayOfWeek !== $diaSemanaNumero) {
            $dataInicio->addDay();
        }

        while ($dataInicio <= $fimAnoLetivo) {
            $eventos[] = [
                'title' => $aula->recreio ? $aula->recreio->nome : ($aula->disciplina ? $aula->disciplina->nome : 'Sem disciplina'),
                'start' => $dataInicio->format('Y-m-d') . 'T' . $aula->hora_inicio,
                'end'   => $dataInicio->format('Y-m-d') . 'T' . $aula->hora_fim,
                'description' => $aula->recreio ? 'Intervalo' : 'Turma: ' . $aula->turma->nome,
            ];

            $dataInicio->addWeek(); // Pula para a próxima semana
        }

        return $eventos;
    });

    return response()->json($eventos);
}




}