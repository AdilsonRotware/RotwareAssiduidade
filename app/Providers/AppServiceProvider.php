<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('view-alunos', function (User $user) {
            return $user->hasRole(['admin', 'normal', 'aluno']);
        });

        Gate::define('admin', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}

