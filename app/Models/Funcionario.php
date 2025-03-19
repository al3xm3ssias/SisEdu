<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'matricula', 'cargo_id', 'tipo_funcionario',
    ];


    protected static function boot()
    {
        parent::boot();

    
    }

    // Lista de cargos como propriedade estática para facilitar o acesso em views e controllers
    public static $cargos = [
        'assistente_educacao' => 'Assistente de Educação',
        'auxiliar_cozinha'    => 'Auxiliar de Cozinha',
        'diretor'             => 'Diretor',
        'escriturario'        => 'Escriturário',
        'estagiario'          => 'Estagiário',
        'merendeira'          => 'Merendeira',
        'pedagoga'            => 'Pedagoga',
        'professor_20h'       => 'Professor 20h',
        'professor_40h'       => 'Professor 40h',
        'servente_escolar'    => 'Servente Escolar'
    ];

    /**
     * Atributo acessor para retornar o rótulo (label) do cargo.
     */
    public function getCargoLabelAttribute()
    {
        return self::$cargos[$this->cargo] ?? 'Desconhecido';
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id'); // 'cargo_id' é a chave estrangeira na tabela funcionarios
    }

    


     // Relacionamento muitos para muitos com turmas
    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'professor_turma');
    }

    
  
}
