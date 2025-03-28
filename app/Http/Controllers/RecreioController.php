<?php

namespace App\Http\Controllers;

use App\Models\Recreio;
use App\Models\Turma;
use Illuminate\Http\Request;

class RecreioController extends Controller
{
    public function index()
    {
        $recreios = Recreio::with('turmas')->get();
        return view('recreios.index', compact('recreios'));
    }

    public function create()
    {
        $turmas = Turma::orderby('nome')->get();
        return view('recreios.create', compact('turmas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'inicio' => 'required|date_format:H:i',
            'fim' => 'required|date_format:H:i|after:inicio',
            'turmas' => 'array',
        ]);

        $recreio = Recreio::create($request->only(['nome', 'inicio', 'fim']));
        $recreio->turmas()->sync($request->turmas);

        return redirect()->route('recreios.index')->with('success', 'Recreio cadastrado!');
    }

    public function edit(Recreio $recreio)
    {
        $turmas = Turma::all();
        return view('recreios.edit', compact('recreio', 'turmas'));
    }

    public function update(Request $request, Recreio $recreio)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'inicio' => 'required|date_format:H:i',
            'fim' => 'required|date_format:H:i|after:inicio',
            'turmas' => 'array',
        ]);

        $recreio->update($request->only(['nome', 'inicio', 'fim']));
        $recreio->turmas()->sync($request->turmas);

        return redirect()->route('recreios.index')->with('success', 'Recreio atualizado!');
    }

    public function destroy(Recreio $recreio)
    {
        $recreio->delete();
        return redirect()->route('recreios.index')->with('success', 'Recreio excluído!');
    }
}


