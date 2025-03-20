<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Turma;
use App\Models\Professor;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index() {
        $aulas = Aula::with(['turma', 'professor', 'disciplina'])->get();
        return view('aulas.index', compact('aulas'));
    }

    public function create() {
        $turmas = Turma::all();
        $professores = Professor::all();
        $disciplinas = Disciplina::all();
        return view('aulas.create', compact('turmas', 'professores', 'disciplinas'));
    }

    public function store(Request $request) {
        Aula::create($request->all());
        return redirect()->route('aulas.index');
    }

    public function edit($id) {
        $aula = Aula::findOrFail($id);
        $turmas = Turma::all();
        $professores = Professor::all();
        $disciplinas = Disciplina::all();
        return view('aulas.edit', compact('aula', 'turmas', 'professores', 'disciplinas'));
    }

    public function update(Request $request, $id) {
        $aula = Aula::findOrFail($id);
        $aula->update($request->all());
        return redirect()->route('aulas.index');
    }

    public function destroy($id) {
        $aula = Aula::findOrFail($id);
        $aula->delete();
        return redirect()->route('aulas.index');
    }
}

