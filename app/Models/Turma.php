<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model {
    use HasFactory;

    protected $fillable = ['nome'];

    public function professores() {
        return $this->belongsToMany(Professor::class);
    }

    public function disciplinas() {
        return $this->belongsToMany(Disciplina::class);
    }
}




