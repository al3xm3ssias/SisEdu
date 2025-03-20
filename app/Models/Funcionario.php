<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'matricula', 'cargo_id', 'tipo_funcionario', 'turno_id'];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }


     // Relacionamento com Cargo
     public function cargo()
{
    return $this->belongsTo(Cargo::class);
}

    // Outros relacionamentos, como o relacionamento com a tabela de ProfessorTurmaDisciplina
    public function professorTurmaDisciplinas()
    {
        return $this->hasMany(ProfessorTurmaDisciplina::class);
    }
}

