<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\FeatureRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UserRepository;
use App\Services\Auth\RegistrationService;
use App\Services\CompanyService;
use App\Services\Contracts\Auth\RegistrationServiceInterface;
use App\Services\Contracts\CompanyServiceInterface;
use App\Services\Contracts\FeatureServiceInterface;
use App\Services\Contracts\TenantCreationServiceInterface;
use App\Services\Contracts\TenantServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\FeatureService;
use App\Services\TenantCreationService;
use App\Services\TenantService;
use App\Services\UserService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the services
        $this->app->bind(FeatureServiceInterface::class, FeatureService::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(TenantServiceInterface::class, TenantService::class);
        $this->app->bind(TenantCreationServiceInterface::class, TenantCreationService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RegistrationServiceInterface::class, RegistrationService::class);

        // Register the repositories
        $this->app->bind(FeatureRepositoryInterface::class, FeatureRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(TenantRepositoryInterface::class, TenantRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);
    }
}
