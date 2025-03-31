<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Turma;

class HorarioController extends Controller
{
    public function index()
    {
        $turmas = Turma::all();
        return view('calendario', compact('turmas'));
    }

    public function getHorarios($turmaId)
    {
        $horarios = Horario::where('turma_id', $turmaId)->get();
        
        // Transformando os dados para o formato do FullCalendar
        $eventos = $horarios->map(function ($horario) {
            return [
                'title' => $horario->disciplina->nome,
                'start' => $horario->data . 'T' . $horario->hora_inicio,
                'end'   => $horario->data . 'T' . $horario->hora_fim,
            ];
        });

        return response()->json($eventos);
    }
}
