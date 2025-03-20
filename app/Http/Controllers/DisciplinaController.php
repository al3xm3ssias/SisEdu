<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disciplina;

class DisciplinaController extends Controller
{
    public function index()
    {
        $disciplinas = Disciplina::all();
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
        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        // A validação do nome permite que o nome da disciplina seja repetido, mas garante que o ID da disciplina sendo atualizada seja ignorado
        $request->validate([
            'nome' => 'required|unique:disciplinas,nome,' . $disciplina->id,
        ]);

        $disciplina->update($request->all());

        return redirect()->route('disciplinas.index')->with('success', 'Disciplina atualizada!');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();
        return redirect()->route('disciplinas.index')->with('success', 'Disciplina removida!');
    }
}
