<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professores'; // Certifique-se que está correto!

    protected $fillable = [
        'funcionario_id',
    ];
}

