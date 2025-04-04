<?php

namespace App\Http\Controllers;

use App\Models\Recreio;
use App\Models\Turma;
use Illuminate\Http\Request;

class RecreioController extends Controller
{
    public function index()
{
    $recreios = Recreio::whereHas('turmas') // Filtra apenas recreios que têm turmas
        ->with(['turmas' => function ($query) {
            $query->orderBy('nome'); // Ordena as turmas pelo nome
        }])
        ->orderBy('inicio') // Ordena os recreios pelo horário de início (do menor para o maior)
        ->get();

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
        $turmas = Turma::orderby('nome')->get();
        return view('recreios.edit', compact('recreio', 'turmas'));
    }
    public function update(Request $request, Recreio $recreio)
{

    dd([
        'tem_turmas' => $request->has('turmas'),
        'tipo_de_turmas' => gettype($request->turmas),
        'conteudo' => $request->turmas
    ]);
    
    $request->validate([
        'nome' => 'required|string|max:255',
        'inicio' => 'required|date_format:H:i',
        'fim' => 'required|date_format:H:i|after:inicio',
        'turmas' => 'sometimes|array',
    ]);

    $recreio->update($request->only(['nome', 'inicio', 'fim']));
    dd($recreio);
    $turmasNovas = $request->turmas ?? [];

    // Pega as turmas atuais no banco (IDs)
    $turmasAtuais = $recreio->turmas()->pluck('turma_id')->toArray();

    // Ordena ambas pra comparar direitinho
    sort($turmasNovas);
    sort($turmasAtuais);

    dd([
        'turmas_do_form' => $turmasNovas,
        'turmas_do_banco' => $turmasAtuais,
    ]);

    // Se forem diferentes, sincroniza
    if ($turmasNovas !== $turmasAtuais) {
        $recreio->turmas()->sync($turmasNovas);
    }

    return redirect()->route('recreios.index')->with('success', 'Recreio atualizado com sucesso!');
}


    public function destroy(Recreio $recreio)
    {
        $recreio->delete();
        return redirect()->route('recreios.index')->with('success', 'Recreio excluído!');
    }


    protected function verificarMudancaDeTurmas(Recreio $recreio, array $novasTurmas)
{
    $turmasAtuais = $recreio->turmas->pluck('id')->toArray();

    dd($turmasAtuais);

    $turmasParaAdicionar = array_diff($novasTurmas, $turmasAtuais);
    $turmasParaRemover = array_diff($turmasAtuais, $novasTurmas);

    return [
        'adicionar' => $turmasParaAdicionar,
        'remover' => $turmasParaRemover,
    ];
}
}


