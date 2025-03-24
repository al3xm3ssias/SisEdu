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

Route::resource('funcionarios', FuncionarioController::class);
/*
Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');

//Route::get('funcionarios/{id}', [FuncionarioController::class, 'show'])->name('funcionarios.show');


Route::put('/funcionarios/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');


Route::post('/funcionarios', [FuncionarioController::class, 'store'])->name('funcionarios.store');

*/


Route::post('/gerar-ciencia', [CienciaController::class, 'gerarCiencia'])->name('gerar.ciencia');
Route::post('/gerar-ciencia-servidor', [CienciaController::class, 'gerarCienciaServidores'])->name('gerar-ciencia');

Route::get('/gerar-ciencia', [CienciaController::class, 'form'])->name('gerar-ciencia.form');

Route::get('/gerar-ciencia-servidor', [CienciaController::class, 'form'])->name('gerar-ciencia-servidor.form');

Route::get('turmas/create', [TurmaController::class, 'create'])->name('turmas.create');

Route::resource('turmas', TurmaController::class);




Route::resource('disciplinas', DisciplinaController::class);


Route::post('/turma-professor-disciplinas', [TurmaProfessorDisciplinaController::class, 'store'])->name('turma_professor_disciplinas.store');


Route::get('/professores/create', [ProfessorController::class, 'create'])->name('professores.create');
Route::get('/professores/edit', [ProfessorController::class, 'edit'])->name('professores.edit');
Route::get('/professores/destroy', [ProfessorController::class, 'destroy'])->name('professores.destroy');
Route::get('/professores', [ProfessorController::class, 'index'])->name('professores.index');











/*
Route::resource('turmas', TurmaProfessoraController::class);

 /*
Route::get('/gerar-ciencia', [CienciaController::class, 'form'])->name('gerar-ciencia.form');
Route::get('/gerar-ciencia/pdf', [CienciaController::class, 'gerarPdf'])->name('gerar-ciencia.pdf');;
*/