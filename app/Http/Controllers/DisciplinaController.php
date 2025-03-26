<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disciplina;

class DisciplinaController extends Controller
{
    public function index()
    {
        $disciplinas = Disciplina::orderBy('nome', 'asc')->get();
        return view('disciplinas.index', compact('disciplinas'));
    }

    public function create()
    {
        return view('disciplinas.create');
    }

    public function store(Request $request)
    {
        // O campo 'nome' não é único, então a validação foi alterada
        $request->validate([
            'nome' => 'required', // Removido a restrição de unicidade
        ]);

        Disciplina::create($request->all());

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina cadastrada com sucesso!');
    }

    public function edit(Disciplina $disciplina)
{
    $disciplinas = Disciplina::all(); // Busca todas as disciplinas para o select
    return view('disciplinas.edit', compact('disciplina', 'disciplinas'));
}

public function update(Request $request, Disciplina $disciplina)
{
    // Validação dos campos
    $request->merge([
        'carga_horaria_horas' => (int) $request->carga_horaria_horas,
        'carga_horaria_minutos' => (int) $request->carga_horaria_minutos,
    ]);
    
    $request->validate([
        'nome' => 'required|unique:disciplinas,nome,' . $disciplina->id,
        'carga_horaria_horas' => 'required|integer|min:0',
        'carga_horaria_minutos' => 'required|integer|min:0|max:59',
    ]);

    // Convertendo horas e minutos para minutos totais
    $carga_horaria_total = ($request->carga_horaria_horas * 60) + $request->carga_horaria_minutos;

    // Atualizando os dados
    $disciplina->update([
        'nome' => $request->nome,
        'carga_horaria_max' => $carga_horaria_total,
    ]);

    // Redireciona para a lista de disciplinas com mensagem de sucesso
    return redirect()->route('disciplinas.index')->with('success', 'Disciplina atualizada com sucesso!');
}


    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();
        return redirect()->route('disciplinas.index')->with('success', 'Disciplina removida!');
    }
}
