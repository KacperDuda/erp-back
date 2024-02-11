<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\User;
use App\Policies\EntryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // grant all access for admin users
        Gate::before(function(User $user, string $ability) {
           if($user->is_admin) {
               return true;
           }
        });

        // i will call MANUALLY gate guards depending on type of resource!
        $entryPolicies = ['viewAny', 'view', 'modify'];
        foreach ($entryPolicies as $entryPolicy) {
            Gate::define('entry:'.$entryPolicy, [EntryPolicy::class, $entryPolicy]);
        }
    }
}
