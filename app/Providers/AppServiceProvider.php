<?php

namespace App\Providers;
use App\Models\Funcionario;
use App\Models\GradeAula;

use App\Observers\FuncionarioObserver;
use App\Observers\GradeAulaObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

       Funcionario::observe(FuncionarioObserver::class);

       GradeAula::observe(GradeAulaObserver::class);
/*
       view()->composer('*', function ($view) {
        if (!Session::has('ano_letivo_id')) {
            $anoAtivo = AnoLetivo::latest()->first();
            Session::put('ano_letivo_id', $anoAtivo->id ?? null);
        }
    });  */
    }
}
