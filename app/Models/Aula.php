<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $fillable = ['turma_id', 'professor_id', 'disciplina_id', 'horario'];

    public function turma() {
        return $this->belongsTo(Turma::class);
    }

    public function professor() {
        return $this->belongsTo(Professor::class);
    }

    public function disciplina() {
        return $this->belongsTo(Disciplina::class);
    }
}
