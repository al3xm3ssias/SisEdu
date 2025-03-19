<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Funcionario;


class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];


  
    // Defina o relacionamento com o professor
    public function professores()
    {
        return $this->belongsToMany(Funcionario::class, 'professor_turma');
    }
}



