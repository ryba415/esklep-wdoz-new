<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Auth::provider('custom_provider_driver', function ($app, array $config) {
            return new CustomUserProvider(new SimpleHasher(), $config['model']);
        });
        
        
        Auth::provider('custom_provider_driver_admin', function ($app, array $config) {
            return new CustomUserAdminProvider(new SimpleHasher(), $config['model']);
        });
        
    }
}
