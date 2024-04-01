<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return  void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return  void
     */
    public function register()
    {
            App::bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository'
        );
        App::bind(
            'App\Repositories\Challenge\ChallengeRepositoryInterface',
            'App\Repositories\Challenge\ChallengeRepository'
        );
        App::bind(
            'App\Repositories\Company\CompanyRepositoryInterface',
            'App\Repositories\Company\CompanyRepository'
        );
        App::bind(
            'App\Repositories\Program\ProgramRepositoryInterface',
            'App\Repositories\Program\ProgramRepository'
        );
        App::bind(
            'App\Repositories\ProgramParticipant\ProgramParticipantRepositoryInterface',
            'App\Repositories\ProgramParticipant\ProgramParticipantRepository'
        );
    }
}