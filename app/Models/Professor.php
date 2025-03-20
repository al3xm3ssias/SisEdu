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


    public function disciplinas() {
        return $this->belongsToMany(Disciplina::class);
    }

    public function turmas() {
        return $this->belongsToMany(Turma::class);
    }
}

