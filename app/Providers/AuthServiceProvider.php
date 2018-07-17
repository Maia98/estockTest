<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use \App\Permission;
use \App\User;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        if (Schema::hasTable('permissions')) {
            
            $permissons = Permission::with('roles')->get();

            foreach($permissons as $permisson)
            {

                Gate::define($permisson->name, function(User $user) use ($permisson){
                    return $user->hasPermission($permisson);
                });
            }

            Gate::before(function(User $user){
                if( $user->hasAnyRole('admin') )
                {
                    return true;
                }
            });
        }

    }
}
