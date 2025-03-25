<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TurmaProfessorDisciplinas;

class GradeAula extends Model
{
    use HasFactory;

    protected $fillable = ['turma_id', 'hora_inicio', 'duracao', 'disciplina_id',];
/*
    public function turmaProfessorDisciplina()
    {
        return $this->belongsTo(TurmaProfessorDisciplinas::class);
    } */

    public function horarios()
{
    return $this->hasMany(DisciplinaHorario::class); // Assumindo que você criou um modelo DisciplinaHorario
}

    
}
