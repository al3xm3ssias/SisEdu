<?php

namespace App\Providers;
use App\Models\Funcionario;
use App\Observers\FuncionarioObserver;

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
    }
}
