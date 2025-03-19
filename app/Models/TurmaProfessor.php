<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaProfessor extends Model
{
    use HasFactory;


    protected $fillable = ['turma_id', 'professor_id'];

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }

    public function professor()
    {
        return $this->belongsTo(Funcionario::class, 'professor_id');
    }
}
