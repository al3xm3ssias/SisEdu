<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

use App\Models\Cargo;
use App\Models\Turno;

class FuncionarioController extends Controller
{
    // Exibir todos os funcionários
    public function index()
    {
        // Carregar funcionários com cargo e turno relacionados
        $funcionarios = Funcionario::with(['cargo', 'turno'])->orderBy('nome', 'asc')->get();
        return view('funcionarios.index', compact('funcionarios'));
    }

    // Exibir o formulário para criar um novo funcionário
    public function create()
    {
        // Carregar todos os cargos e turnos disponíveis
        $cargos = Cargo::all();
        $turnos = Turno::all();

        return view('funcionarios.create', compact('cargos', 'turnos'));
    }

    // Armazenar um novo funcionário
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'nome' => 'required|string',
            'matricula' => 'required|string|unique:funcionarios',
            'cargo_id' => 'required|exists:cargos,id',
            'turno_id' => 'required|exists:turnos,id',
            'tipo_funcionario' => 'required|in:0,1', // Concursado ou Terceirizado
        ]);

        // Criar um novo funcionário
        $funcionario = new Funcionario();
        $funcionario->nome = $request->nome;
        $funcionario->matricula = $request->matricula;
        $funcionario->cargo_id = $request->cargo_id;
        $funcionario->turno_id = $request->turno_id;
        $funcionario->tipo_funcionario = $request->tipo_funcionario;
        $funcionario->save();

        // Redireciona para a lista de funcionários com mensagem de sucesso
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário criado com sucesso!');
    }

    // Exibir o formulário para editar um funcionário
    public function edit($id)
    {
        // Encontrar o funcionário e carregar cargos e turnos
        $funcionario = Funcionario::findOrFail($id);
        $cargos = Cargo::all();
        $turnos = Turno::all();

        return view('funcionarios.edit', compact('funcionario', 'cargos', 'turnos'));
    }

    // Atualizar as informações de um funcionário
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|string|max:255|unique:funcionarios,matricula,' . $id,
            'cargo_id' => 'required|exists:cargos,id',
            'turno_id' => 'required|exists:turnos,id',
            'tipo_funcionario' => 'required|in:0,1', // Concursado ou Terceirizado
        ]);

        // Encontrar o funcionário
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
        }

        // Atualizar os dados do funcionário
        $funcionario->nome = $request->nome;
        $funcionario->matricula = $request->matricula;
        $funcionario->cargo_id = $request->cargo_id;
        $funcionario->turno_id = $request->turno_id;
        $funcionario->tipo_funcionario = $request->tipo_funcionario;

        // Salvar as alterações
        $funcionario->save();

        // Redirecionar para a lista de funcionários com mensagem de sucesso
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    // Excluir um funcionário
    public function destroy($id)
    {
        // Encontrar e excluir o funcionário
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        // Redirecionar para a lista de funcionários com mensagem de sucesso
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso.');
    }

    // Mostrar um funcionário específico
    public function show($id)
    {
        // Encontrar o funcionário com seus dados de cargo e turno
        $funcionario = Funcionario::with(['cargo', 'turno'])->findOrFail($id);

        // Retornar a view com os detalhes do funcionário
        return view('funcionarios.show', compact('funcionario'));
    }
}


