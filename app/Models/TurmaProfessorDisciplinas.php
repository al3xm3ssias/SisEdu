<?php

// app/Models/TurmaProfessorDisciplina.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaProfessorDisciplinas extends Model
{
    use HasFactory;
    protected $table = 'turma_professor_disciplinas'; 
    protected $fillable = ['professor_id', 'turma_id', 'disciplina_id'];

  

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'professor_id');
    }

    public function turma()
{
    return $this->belongsTo(Turma::class, 'turma_id');
}

public function disciplina()
{
    return $this->belongsTo(Disciplina::class, 'disciplina_id');
}

    

    public function disciplinas()
{
    return $this->belongsToMany(
        Disciplina::class,            // Modelo de disciplina
        'turma_professor_disciplinas', // Nome da tabela intermediária
        'professor_id',               // Chave estrangeira para o professor
        'disciplina_id'               // Chave estrangeira para a disciplina
    );
}

}
