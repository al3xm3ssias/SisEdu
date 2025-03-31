<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnoLetivo;
use App\Models\GradeAula;

class AnoLetivoController extends Controller
{
    public function index()
    {
        $anosLetivos = AnoLetivo::orderBy('nome', 'asc')->get();
       // dd($anosLetivos->toArray());

        return view('anos-letivos.index', compact('anosLetivos'));
    }

    public function create()
    {
        return view('anos-letivos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:10',
            'inicio' => 'required|date',
            'fim' => 'required|date|after:inicio',
        ]);

        AnoLetivo::create($request->all());

        return redirect()->route('anos-letivos.index')->with('success', 'Ano Letivo criado com sucesso!');
    }

    public function edit(AnoLetivo $anos_letivo)
    {
        return view('anos-letivos.edit', compact('anos_letivo'));
    }

    public function update(Request $request, AnoLetivo $anos_letivo)
    {
        $request->validate([
            'nome' => 'required|string|max:10',
            'inicio' => 'required|date',
            'fim' => 'required|date|after:inicio',
        ]);

        $anos_letivo->update($request->all());

        return redirect()->route('anos-letivos.index')->with('success', 'Ano Letivo atualizado com sucesso!');
    }

    public function destroy(AnoLetivo $anos_letivo)
    {
        $anos_letivo->delete();
        return redirect()->route('anos-letivos.index')->with('success', 'Ano Letivo deletado!');
    }




    public function mudarAnoLetivo(Request $request)
    {
        $anoLetivo = AnoLetivo::findOrFail($request->ano_letivo_id);
        session(['ano_letivo_id' => $anoLetivo->id]);
        return redirect()->back()->with('success', 'Ano letivo alterado para ' . $anoLetivo->nome);
    }
}