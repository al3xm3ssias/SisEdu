<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disciplina;

class Disciplina extends Model
{
    use HasFactory;

    protected $table = 'disciplinas'; // Especificando o nome da tabela
    protected $fillable = ['nome', 'carga_horaria_max'];

    public function professores() {
        return $this->belongsToMany(Professor::class);
    }

    public function turmas()
{
    return $this->belongsToMany(Turma::class, 'turma_disciplinas', 'disciplina_id', 'turma_id');
}

public function gradeAulas()
{
    return $this->hasMany(GradeAula::class);
}

public function turma()
{
    return $this->belongsTo(Turma::class, 'turma_id');
}


    
}

