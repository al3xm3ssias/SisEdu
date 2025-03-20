<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateCrudViews extends Command
{
    protected $signature = 'make:crud-views {model}';
    protected $description = 'Criar as views index, create e edit para um model';

    public function handle()
    {
        $model = $this->argument('model');
        $viewsPath = resource_path('views/' . strtolower($model));

        // Cria o diretório das views
        if (!File::exists($viewsPath)) {
            File::makeDirectory($viewsPath, 0777, true);
        }

        // Criar a view index
        $this->createIndexView($viewsPath);

        // Criar a view create
        $this->createCreateView($viewsPath);

        // Criar a view edit
        $this->createEditView($viewsPath);

        $this->info('Views criadas com sucesso!');
    }

    protected function createIndexView($path)
    {
        $content = '<h1>Listagem de {{ ucfirst($model) }}</h1>';
        $content .= '<a href="{{ route(\'' . strtolower($model) . '.create\') }}">Criar Novo</a>';
        $content .= '<ul>@foreach($' . strtolower($model) . 's as $item) <li>{{ $item->nome }}</li>@endforeach</ul>';
        File::put($path . '/index.blade.php', $content);
    }

    protected function createCreateView($path)
    {
        $content = '<h1>Criar {{ ucfirst($model) }}</h1>';
        $content .= '<form action="{{ route(\'' . strtolower($model) . '.store\') }}" method="POST">';
        $content .= '@csrf <input type="text" name="nome" /> <button type="submit">Salvar</button></form>';
        File::put($path . '/create.blade.php', $content);
    }

    protected function createEditView($path)
{
    $content = '<h1>Editar {{ ucfirst($model) }}</h1>';
    $content .= '<form action="{{ route(\'' . strtolower($model) . '.update\', $' . strtolower($model) . ') }}" method="POST">';
    $content .= '@csrf';
    $content .= '@method("PUT")';  // Correção aqui: agora é a diretiva Blade correta
    $content .= '<input type="text" name="nome" value="{{ $' . strtolower($model) . '->nome }}" />';
    $content .= '<button type="submit">Salvar</button>';
    $content .= '</form>';
    File::put($path . '/edit.blade.php', $content);
}
}

