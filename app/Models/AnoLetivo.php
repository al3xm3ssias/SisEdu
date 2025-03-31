<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnoLetivo extends Model
{
    use HasFactory;
    
    protected  $table = 'anos_letivos';

    protected $fillable = ['nome', 'inicio', 'fim']; // Ajuste conforme sua tabela

   
    public function gradeAulas()
    {
        return $this->hasMany(GradeAula::class); // Modifique se necessário
    }

}
