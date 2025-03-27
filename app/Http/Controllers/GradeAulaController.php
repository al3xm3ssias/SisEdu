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



class GradeAulaController extends Controller
{
    public function index()
{
    // Obtenha as grades, talvez incluindo a turma associada
    $turmas = Turma::with('disciplinas')->get();
    $grades = GradeAula::with('turma')->get();

    //dd($turmas);

    return view('grade_aulas.index', compact('turmas', 'grades'));
}


public function create(Request $request)
{
    $turma_id = $request->query('turma_id');
    $turma = Turma::findOrFail($turma_id);
    
    $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
    
    $blocos = [
        'manha' => [],
        'tarde' => []
    ];
    
    // Recupera os recreios padrão
    $recreios = \App\Models\Recreio::all();
    
    // Usando Query Builder para consultar a tabela recreio_turma
    $recreiosTurma = \DB::table('recreio_turma')
    ->join('recreios', 'recreio_turma.recreio_id', '=', 'recreios.id')
    ->select('recreios.nome', 'recreios.inicio', 'recreios.fim')
    ->where('recreio_turma.turma_id', $turma_id)
    ->get();


    //dd($recreiosTurma);


    
    // Função auxiliar para criar os slots
    $criarSlots = function($blocosTurno, $recreios, $recreiosTurma) {
        $slots = [];
        foreach ($blocosTurno as $bloco) {
            $inicio = $bloco['inicio'];
            $duracao = $bloco['duracao'];
            $fim = (new \DateTime($inicio))
                ->add(new \DateInterval('PT' . $duracao . 'M'))
                ->format('H:i');
            $slots[] = [
                'tipo' => 'aula',
                'inicio' => $inicio,
                'fim' => $fim,
                'conteudo' => 'Livre'
            ];
            // Procura recreio que comece exatamente quando o bloco termina, dando prioridade ao recreio_turma
            $recreioEncontrado = null;
            foreach ($recreiosTurma as $recTurma) {
                if ($recTurma->inicio === $fim) {
                    $recreioEncontrado = $recTurma;
                    break;
                }
            }
            if (!$recreioEncontrado) {
                foreach ($recreios as $rec) {
                    if ($rec->inicio === $fim) {
                        $recreioEncontrado = $rec;
                        break;
                    }
                }
            }
            if ($recreioEncontrado) {
                $slots[] = [
                    'tipo' => 'intervalo',
                    'inicio' => $recreioEncontrado->inicio,
                    'fim' => $recreioEncontrado->fim,
                    'conteudo' => $recreioEncontrado->nome
                ];
            }
        }
        return $slots;
    };

    $slotsManha = $criarSlots($blocos['manha'], $recreios, $recreiosTurma);
    $slotsTarde = $criarSlots($blocos['tarde'], $recreios, $recreiosTurma);

    $schedule = [];
    foreach ($diasSemana as $dia) {
        $schedule[$dia] = [
            'manha' => $slotsManha,
            'tarde' => $slotsTarde
        ];
    }

    // Recupera as disciplinas vinculadas à turma
    $disciplinas = Disciplina::whereHas('turmas', function($query) use ($turma_id) {
        $query->where('turmas.id', $turma_id);
    })->orderBy('carga_horaria_max', 'desc')->get();

    // Agora, aloca as disciplinas nos slots de aula (não nos intervalos)
    foreach ($disciplinas as $disciplina) {
        $cargaHoraria = $disciplina->carga_horaria_max * 60; // carga horária em minutos
        $ehArte = ($disciplina->nome === 'Arte');
        // Se for Arte, o bloco é de 60 minutos; caso contrário, 90.
        $tamanhoBloco = $ehArte ? 60 : 90;
        
        if ($ehArte) {
            $alocado = false;
            foreach ($diasSemana as $dia) {
                // Tenta alocar na manhã
                foreach ($schedule[$dia]['manha'] as &$slot) {
                    if ($slot['tipo'] === 'aula' && $slot['conteudo'] === 'Livre') {
                        $slot['conteudo'] = $disciplina->nome . " ({$slot['inicio']} - {$slot['fim']})";
                        $alocado = true;
                        break 2;
                    }
                }
                // Se não alocar na manhã, tenta na tarde
                foreach ($schedule[$dia]['tarde'] as &$slot) {
                    if ($slot['tipo'] === 'aula' && $slot['conteudo'] === 'Livre') {
                        $slot['conteudo'] = $disciplina->nome . " ({$slot['inicio']} - {$slot['fim']})";
                        $alocado = true;
                        break 2;
                    }
                }
            }
            if (!$alocado) continue;
        } else {
            // Para outras disciplinas, aloca blocos até que a carga horária seja consumida.
            foreach ($diasSemana as $dia) {
                foreach (['manha','tarde'] as $turno) {
                    foreach ($schedule[$dia][$turno] as &$slot) {
                        if ($slot['tipo'] === 'aula' && $slot['conteudo'] === 'Livre' && $cargaHoraria > 0) {
                            $slot['conteudo'] = $disciplina->nome . " ({$slot['inicio']} - {$slot['fim']})";
                            $cargaHoraria -= $tamanhoBloco;
                        }
                    }
                    if ($cargaHoraria <= 0) break 2;
                }
            }
        }
    }

    

    return view('grade_aulas.create', compact('schedule', 'turma_id', 'diasSemana', 'disciplinas', 'recreiosTurma'));
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
