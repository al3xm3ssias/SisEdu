<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\CienciaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TurmaProfessorController;


use App\Http\Controllers\TurmaProfessorDisciplinaController;

use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\DisciplinaProfessorController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\GradeAulaController;
use App\Http\Controllers\DisciplinaHorarioController;
use App\Http\Controllers\RecreioController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AnoLetivoController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('painel');
}); 



// Rota para a tela inicial (home)
Route::get('/home', [HomeController::class, 'index'])->name('home'); 




// Rota para exibir o painel
Route::get('/painel', function () {
    return view('painel');  // Esse é o arquivo de view onde o botão de download está
})->name('painel');  // Definindo a rota 'painel'

// Rota para baixar o CSV
Route::get('/baixar-csv', [CsvController::class, 'baixarCsv'])->name('baixar-csv');


Route::middleware(['auth'])->group(function () {
                Route::resource('funcionarios', FuncionarioController::class);
              
                Route::post('/gerar-ciencia', [CienciaController::class, 'gerarCiencia'])->name('gerar.ciencia');
                Route::post('/gerar-ciencia-servidor', [CienciaController::class, 'gerarCienciaServidores'])->name('gerar-ciencia');

                Route::get('/gerar-ciencia', [CienciaController::class, 'form'])->name('gerar-ciencia.form');

                Route::get('/gerar-ciencia-servidor', [CienciaController::class, 'form'])->name('gerar-ciencia-servidor.form');

                Route::get('turmas/create', [TurmaController::class, 'create'])->name('turmas.create');

                Route::resource('turmas', TurmaController::class);

                Route::resource('disciplinas', DisciplinaController::class);
                Route::post('/turma-professor-disciplinas', [TurmaProfessorDisciplinaController::class, 'store'])->name('turma_professor_disciplinas.store');
    
                Route::get('/professores/create', [ProfessorController::class, 'create'])->name('professores.create');

                Route::resource('turma_professor_disciplinas', TurmaProfessorDisciplinaController::class);

                // Rota para atualizar turma e disciplina do professor
                Route::put('turma_professor_disciplinas/{id}', [TurmaProfessorDisciplinaController::class, 'updateTurmaDisciplina'])->name('turma_professor_disciplinas.update');

                // Rota para editar a página de um professor (página de edição do professor)
                Route::get('professores/{professor}/edit', [ProfessorController::class, 'edit'])->name('professores.edit');

                Route::delete('turma-professor/{professor_id}/turma/{turma_id}', 
                    [TurmaProfessorDisciplinaController::class, 'destroy']
                )->name('turma_professor_disciplinas.destroy');

                // Rota para listagem de professores
                Route::get('professores', [ProfessorController::class, 'index'])->name('professores.index');

                Route::get('/professores/{id}', [ProfessorController::class, 'show'])->name('professores.show');


                Route::resource('grade_aulas', GradeAulaController::class);
                Route::get('grade_aulas/{turma}', [GradeAulaController::class, 'show'])->name('grade_aulas.show');


                Route::resource('recreios', RecreioController::class);

                Route::resource('/anos-letivos', AnoLetivoController::class);
                Route::post('/anos-letivos/mudar', [AnoLetivoController::class, 'mudarAnoLetivo'])->name('anos-letivos.mudar');

                Route::get('/calendario', [HorarioController::class, 'index'])->name('calendario.index');
                Route::get('/calendario/horarios/{turma}', [HorarioController::class, 'getHorarios']);

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
