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

    $tamanhoMax = $request->input('tamanho_max', 5); 
    // Recupera as turmas que possuem pelo menos uma grade associada
    $turmasComGrade = Turma::whereHas('grades')->get();

    $turmas = Turma::with('disciplinas')->orderBy('nome', 'asc')->get();

    // Passando a variável para a view corretamente
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

    // Recupera todos os recreios disponíveis
    $recreios = \App\Models\Recreio::all();
    
    // Recupera os recreios específicos da turma
    $recreiosTurma = \DB::table('recreio_turma')
    ->join('recreios', 'recreio_turma.recreio_id', '=', 'recreios.id')
    ->select('recreios.nome', 'recreios.inicio', 'recreios.fim')
    ->where('recreio_turma.turma_id', $turma_id)
    ->get();

// Formata os recreios para exibição
$formatarHorarios = function ($recreios) {
    return $recreios->map(function ($rec) {
        return [
            'nome' => $rec->nome,
            'inicio' => (new \DateTime($rec->inicio))->format('H:i'),
            'fim' => (new \DateTime($rec->fim))->format('H:i')
        ];
    });
};

$recreiosTurma = $formatarHorarios($recreiosTurma);
    $recreios = $formatarHorarios($recreios);

    // Inicializa a grade vazia para edição manual
    $schedule = [];
    foreach ($diasSemana as $dia) {
        $schedule[$dia] = [
            'manha' => [],
            'tarde' => []
        ];
    }

    return view('grade_aulas.create', compact('schedule', 'turma_id', 'diasSemana', 'disciplinas', 'recreiosTurma', 'recreios' , 'tamanhoMax'));
}



public function store(Request $request)
{
    // Recebe os dados da grade de aula
    $dados = $request->input('schedule'); // Array de horários por dia
    
    // Iterar sobre os dados para salvar a grade de aula
    foreach ($dados as $dia => $horarios) {
        foreach ($horarios as $horario) {
            // Verifica se a chave 'disciplina' existe e é um número válido
            if (isset($horario['disciplina']) && is_numeric($horario['disciplina'])) {
                // Recupere o ID da disciplina
                $disciplinaId = $horario['disciplina'];

                // Verifique se a disciplina é 'Livre' (ID = 99)
                if ($disciplinaId == 99) {
                    // No caso de disciplina 'Livre', você pode deixar a disciplina como null ou associar com alguma lógica específica
                    $disciplina = null;  // Ou algum comportamento específico para "Livre"
                } else {
                    // Caso contrário, busque a disciplina pelo ID
                    $disciplina = Disciplina::find($disciplinaId);
                }

                // Calculando a duração da aula
                $horaInicio = Carbon::createFromFormat('H:i', $horario['inicio']);
                $horaFim = Carbon::createFromFormat('H:i', $horario['fim']);
                $duracao = $horaInicio->diffInMinutes($horaFim); // Calcula a diferença em minutos

                // Agora você tem a disciplina, a duração e pode salvar a grade
                GradeAula::create([
                    'turma_id' => $request->input('turma_id'), // Turma associada
                    'disciplina_id' => $disciplina ? $disciplina->id : null, // ID da disciplina ou null para 'Livre'
                    'dia_semana' => $dia, // Dia da semana
                    'hora_inicio' => $horario['inicio'], // Hora de início
                    'hora_fim' => $horario['fim'], // Hora de fim
                    'duracao' => $duracao, // Duração da aula em minutos
                ]);
            }
        }
    }

    // Redireciona ou retorna uma resposta de sucesso
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

public function edit($id)
{
    $grade = GradeAula::findOrFail($id);
    $turmas = Turma::all(); // Caso precise listar turmas na edição
    $disciplinas = Disciplina::all(); // Caso precise listar disciplinas na edição
    
    return view('grade_aulas.edit', compact('grade', 'turmas', 'disciplinas'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'turma_id' => 'required|exists:turmas,id',
        'disciplina_id' => 'nullable|exists:disciplinas,id',
        'dia_semana' => 'required|string',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fim' => 'required|date_format:H:i|after:hora_inicio',
        'duracao' => 'required|integer|min:1',
    ]);

    $grade = GradeAula::findOrFail($id);
    $grade->update($request->all());

    return redirect()->route('grade_aulas.index')->with('success', 'Grade de aula atualizada com sucesso!');
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
