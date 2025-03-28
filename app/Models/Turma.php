<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'turma_disciplinas');
    }


    public function professores()
    {
        return $this->belongsToMany(Professor::class, 'turma_professor_disciplinas')
                    ->withPivot('disciplina_id')
                    ->withTimestamps();
    }

    public function recreios()
{
    return $this->belongsToMany(Recreio::class, 'recreio_turma', 'turma_id', 'recreio_id');
}

public function gradeAulas()
{
    return $this->hasMany(GradeAula::class, 'turma_id');
}

// Definir o relacionamento com a GradeAula
public function grades()
{
    return $this->hasMany(GradeAula::class);
}

    
}




