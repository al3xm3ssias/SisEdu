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
        return $this->belongsTo(Professor::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
