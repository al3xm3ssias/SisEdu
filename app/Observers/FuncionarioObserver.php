<?php

namespace App\Observers;
use Illuminate\Support\Facades\Log;

use App\Models\Funcionario;
use App\Models\Professor;

class FuncionarioObserver
{
    public function created(Funcionario $funcionario)
{
    $funcionario->load('cargo');

    if (in_array($funcionario->cargo_id, [8, 9])) {
        $professor = new Professor();
        $professor->funcionario_id = $funcionario->id;
        $professor->nome = $funcionario->nome;
        $professor->matricula = $funcionario->matricula;
        

        if (!$professor->save()) {
            dd('Erro ao salvar', $professor);
        }
    }
}



public function updated(Funcionario $funcionario)
{
    Log::info('Observer acionado para atualização!', ['funcionario' => $funcionario]);

    $funcionario->load('cargo'); // Garante que o cargo está carregado corretamente
    $nomeCargo = trim(strtolower($funcionario->cargo->nome)); // Normaliza o nome do cargo

    if ($nomeCargo === 'professor 20h' || $nomeCargo === 'professor 40h') {
        Log::info('Funcionario é professor, atualizando a tabela professores.', ['id' => $funcionario->id]);

        Professor::updateOrCreate(
            ['funcionario_id' => $funcionario->id],
            [
                'nome' => (string) $funcionario->nome,
                'matricula' => (string) $funcionario->matricula,
            ]
        );
    } else {
        Log::info('Funcionario NÃO é professor, removendo da tabela professores.', ['id' => $funcionario->id]);
        Professor::where('funcionario_id', $funcionario->id)->delete();
    }
}


}
