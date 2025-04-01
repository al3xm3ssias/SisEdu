<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professores'; 

    protected $fillable = [
        'funcionario_id','nome', 'matricula',
    ];

/*
    public function disciplinas() {
        return $this->belongsToMany(Disciplina::class);
    } */

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'turma_professor_disciplinas', 'professor_id', 'disciplina_id');
    }

    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'turma_professor_disciplinas', 'professor_id', 'turma_id');
    }


    public function turmaProfessorDisciplinas()
{
    return $this->hasMany(TurmaProfessorDisciplinas::class, 'professor_id');
}

public function turmasDisciplinas()
{
    return $this->hasMany(TurmaProfessorDisciplinas::class);
}

public function turma()
{
    return $this->belongsTo(Turma::class, 'turma_id');
}



}

