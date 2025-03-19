<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    // Mostrar todas as turmas
    public function index()
    {
        $turmas = Turma::all();  // Pega todas as turmas
        return view('turmas.index', compact('turmas'));
    }

    // Mostrar formulário para criação de nova turma
    public function create()
    {
        return view('turmas.create');  // Simplesmente a tela para adicionar uma turma
    }

    // Armazenar nova turma
    public function store(Request $request)
    {
        // Validar dados recebidos
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Criar a nova turma
        Turma::create([
            'nome' => $request->nome,  // Nome da turma
        ]);

        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }

    // Mostrar formulário para editar turma
    public function edit($id)
    {
        $turma = Turma::findOrFail($id);  // Encontra a turma pelo ID
        return view('turmas.edit', compact('turma'));  // Passa a turma para o formulário de edição
    }

    // Atualizar turma
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $turma = Turma::findOrFail($id);
        $turma->update([
            'nome' => $request->nome,  // Atualiza o nome da turma
        ]);

        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }
}



