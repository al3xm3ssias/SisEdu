<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisciplinaHorarioController extends Controller
{
    //

    public function exibirFormulario($id)
{
    $turma = Turma::find($id);
    if (!$turma) {
        return redirect()->back()->with('error', 'Turma não encontrada');
    }

    // Carrega as disciplinas associadas à turma
    $disciplinas = $turma->disciplinas()->orderBy('nome')->get();

    // Retorna a view com os dados necessários
    return view('grade_aulas.horarios_form', compact('turma', 'disciplinas'));
}


public function salvarHorarios(Request $request, $turma_id)
{
    // Validação dos dados
    $request->validate([
        'disciplina_id' => 'required|exists:disciplinas,id',
        'dia' => 'required|string|in:segunda,terca,quarta,quinta,sexta', 
        'inicio' => 'required|date_format:H:i',
        'fim' => 'required|date_format:H:i|after:inicio',
    ]);

    // Salvando o horário
    $horario = new DisciplinaHorario();
    $horario->disciplina_id = $request->disciplina_id;
    $horario->dia = $request->dia;
    $horario->inicio = $request->inicio;
    $horario->fim = $request->fim;
    $horario->save();

    // Redireciona para a página de detalhes da turma com uma mensagem de sucesso
    return redirect()->route('turma.detalhes', $turma_id)->with('success', 'Horário salvo com sucesso!');
}

   

}
