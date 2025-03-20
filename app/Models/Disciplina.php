<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disciplina;

class Disciplina extends Model
{
    use HasFactory;

    protected $table = 'disciplinas'; // Especificando o nome da tabela
    protected $fillable = ['nome'];

    public function professores()
    {
        return $this->belongsToMany(Funcionario::class, 'disciplina_professor', 'disciplina_id', 'professor_id')
                    ->withPivot('carga_horaria')
                    ->withTimestamps();
    }



    public function professorTurmaDisciplinas()
    {
        return $this->hasMany(ProfessorTurmaDisciplina::class);
    }
}

