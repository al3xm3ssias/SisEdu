<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

use App\Models\Cargo;



class FuncionarioController extends Controller
{
    // Exibir todos os funcionários
    public function index()
    {
        $funcionarios = Funcionario::with('cargo')->get(); // Carregar todos os funcionários e os cargos relacionados
        return view('funcionarios.index', compact('funcionarios'));
    }

    // Exibir o formulário para criar um novo funcionário
    public function create()
    {
         $cargos = Cargo::all();

    // Passa os cargos para a view
    return view('funcionarios.create', compact('cargos'));
    }

    public function store(Request $request)
    {
        // Valida os dados do formulário
        $validated = $request->validate([
            'nome' => 'required|string',
            'matricula' => 'required|string|unique:funcionarios',
            'cargo_id' => 'required|exists:cargos,id',
            'tipo_funcionario' => 'required|in:0,1',
        ]);
    
        // Cria um novo funcionário
        $funcionario = new Funcionario();
        $funcionario->nome = $request->nome;
        $funcionario->matricula = $request->matricula;
        $funcionario->cargo_id = $request->cargo_id;  // Usa o cargo_id
        $funcionario->tipo_funcionario = $request->tipo_funcionario;
        $funcionario->save();
    
        // Redireciona ou envia uma resposta
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário criado com sucesso!');
    }
    


    // Exibir o formulário para editar um funcionário
    public function edit($id)
{
    $funcionario = Funcionario::findOrFail($id);
    $cargos = Cargo::all(); // Pega todos os cargos da tabela cargos
    return view('funcionarios.edit', compact('funcionario', 'cargos')); // Passa os cargos para a view
}


public function update(Request $request, $id)
{
    //dd($id);
    // Validação
    $request->validate([
        'nome' => 'required|string|max:255',
        'matricula' => 'required|string|max:255|unique:funcionarios,matricula,' . $id, // Ignorar o próprio id
        'cargo_id' => 'required|exists:cargos,id', // Verifica se o cargo existe
        'tipo_funcionario' => 'required|in:0,1', // Concursado ou Terceirizado
    ]);

    // Encontrar o funcionário para editar
    $funcionario = Funcionario::find($id);

    if (!$funcionario) {
        return redirect()->route('funcionarios.index')->with('error', 'Funcionário não encontrado.');
    }

    // Atualiza os dados do funcionário
    $funcionario->nome = $request->nome;
    $funcionario->matricula = $request->matricula;
    $funcionario->cargo_id = $request->cargo_id;
    $funcionario->tipo_funcionario = $request->tipo_funcionario;

    // Salvar as alterações
    $funcionario->save();

    // Redireciona para a lista com sucesso
    return redirect()->route('funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');

    dd($request->all());
}

    
    

    // Excluir um funcionário
    public function destroy($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->delete();

        return redirect()->route('funcionarios.index')->with('success', 'Funcionário excluído com sucesso.');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class); // Aqui é a relação de muitos para um
    }

    public function show($id)
{
    // Encontrar o funcionário pelo ID
    $funcionario = Funcionario::findOrFail($id);

    // Retornar a view com o funcionário
    return view('funcionarios.show', compact('funcionario'));
}


  
}

