<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Funcionario; // Para pegar os professores da tabela 'funcionarios'
use App\Models\TurmaProfessor; // Supondo que você tenha uma tabela de relacionamento
use Illuminate\Http\Request;

class TurmaProfessorController extends Controller
{
    // Mostrar todos os relacionamentos
    public function index()
    {
        $turmasProfessores = TurmaProfessor::with(['turma', 'professor'])->get(); // Pega todas as turmas com seus respectivos professores
        return view('turma_professor.index', compact('turmasProfessores'));
    }

    // Mostrar formulário para criar um relacionamento
    public function create()
    {
        $turmas = Turma::all();  // Pega todas as turmas
        $professores = Funcionario::whereIn('cargo_id', [8, 9])->get();  // Pega os professores que têm id_cargo igual a 8 ou 9
        return view('turma_professor.create', compact('turmas', 'professores'));
    }

    // Armazenar novo relacionamento entre professor e turma
    public function store(Request $request)
    {
        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'professor_id' => 'required|exists:funcionarios,id',
        ]);

        TurmaProfessor::create([
            'turma_id' => $request->turma_id,
            'professor_id' => $request->professor_id,
        ]);

        return redirect()->route('turma_professor.index')->with('success', 'Relacionamento criado com sucesso!');
    }

    // Mostrar formulário para editar o relacionamento
    public function edit($id)
    {
        $turmaProfessor = TurmaProfessor::findOrFail($id);
        $turmas = Turma::all();
        $professores = Funcionario::whereIn('cargo_id', [8, 9])->get();
        return view('turma_professor.edit', compact('turmaProfessor', 'turmas', 'professores'));
    }

    // Atualizar relacionamento entre professor e turma
    public function update(Request $request, $id)
    {
        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'professor_id' => 'required|exists:funcionarios,id',
        ]);

        $turmaProfessor = TurmaProfessor::findOrFail($id);
        $turmaProfessor->update([
            'turma_id' => $request->turma_id,
            'professor_id' => $request->professor_id,
        ]);

        return redirect()->route('turma_professor.index')->with('success', 'Relacionamento atualizado com sucesso!');
    }
}