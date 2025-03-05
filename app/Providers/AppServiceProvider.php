<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Policies\ProfilePolicy;
use Illuminate\Support\Facades\Gate;


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
        /*Gate::define('profileUpdate', function(User $user){
            return $user->type == 'C' || $user->type == 'A';
        });*/

        Gate::define('admin', function (User $user) {
            // Only "administrator" users can "admin"
            return ($user->type == 'A') ;
            });
        

        Gate::define('accessControl', function (User $user) {
            // apenas os empregados podem aceder ou os admins por que sao admin
            return ($user->type == 'A') || ($user->type == 'E');
            });

        Gate::policy(User::class, ProfilePolicy::class);
    }
    
}
