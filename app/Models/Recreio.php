<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recreio extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'inicio', 'fim'];

    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'recreio_turma');
    }
}

