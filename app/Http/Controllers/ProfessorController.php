<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Turma;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        $professores = Professor::all(); // Pega todos os professores
        return view('professores.index', compact('professores'));
    }

    public function create()
    {
        $turmas = Turma::all(); // Pega todas as turmas
        $disciplinas = Disciplina::all(); // Pega todas as disciplinas
        return view('professores.create', compact('turmas', 'disciplinas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'turmas' => 'required|array',
            'disciplinas' => 'required|array',
        ]);

        $professor = Professor::create([
            'nome' => $request->nome,
        ]);

        // Associar professor com turmas e disciplinas
        $professor->turmas()->attach($request->turmas);
        $professor->disciplinas()->attach($request->disciplinas);

        return redirect()->route('professores.index')->with('success', 'Professor criado com sucesso!');
    }

    public function edit(Professor $professor)
    {
        $turmas = Turma::all();
        $disciplinas = Disciplina::all();
        return view('professores.edit', compact('professor', 'turmas', 'disciplinas'));
    }

    public function update(Request $request, Professor $professor)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'turmas' => 'required|array',
            'disciplinas' => 'required|array',
        ]);

        $professor->update([
            'nome' => $request->nome,
        ]);

        // Atualiza as associações com turmas e disciplinas
        $professor->turmas()->sync($request->turmas);
        $professor->disciplinas()->sync($request->disciplinas);

        return redirect()->route('professores.index')->with('success', 'Professor atualizado com sucesso!');
    }

    public function destroy(Professor $professor)
    {
        $professor->turmas()->detach();
        $professor->disciplinas()->detach();
        $professor->delete();

        return redirect()->route('professores.index')->with('success', 'Professor excluído com sucesso!');
    }
}

