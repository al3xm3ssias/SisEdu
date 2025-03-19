<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Funcionario;

class CienciaController extends Controller
{
    public function form()
    {
        return view('gerar_ciencia_form');
    }


    public function gerarCiencia(Request $request)
    {
        // Pegando o título do informativo
        $referente = $request->input('referente');
        
        // Pegando o tipo de funcionário
        $tipoFuncionario = $request->input('tipo_funcionario');
        
        // Construindo a consulta baseada no tipo de funcionário
        $funcionariosQuery = Funcionario::query();
        
        if ($tipoFuncionario == 'concursados') {
            $funcionariosQuery->where('tipo_funcionario', 0); // Concursados

        } elseif ($tipoFuncionario == 'professoras') {
            // Filtro para professoras de 20h ou 40h
            $funcionariosQuery->whereIn('cargo', ['professor_20h', 'professor_40h']);
        }

        // Se for "todos", não aplica nenhum filtro
        $funcionarios = $funcionariosQuery->orderBy('nome', 'asc')->get();

        // Gerando o PDF com a view
        $pdf = PDF::loadView('gerar_ciencia', compact('funcionarios', 'referente'));

        // Retorna o PDF para download
        return $pdf->download("ciência_referente_{$referente}.pdf");
    }

}




    


