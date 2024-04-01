<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\User\UserService;
use App\Services\Challenge\ChallengeService;
use App\Services\Company\CompanyService;
use App\Services\Program\ProgramService;
use App\Services\ProgramParticipant\ProgramParticipantService;
use App\Services\Gpt\GptService;
use App\Services\Generic\GenericService;

class GeneralServiceProvider extends ServiceProvider
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
        $this->app->bind('GenericService', function () {
            return new GenericService();
        });
        $this->app->bind('UserService', function () {
            return new UserService();
        });
        $this->app->bind('ChallengeService', function () {
            return new ChallengeService();
        });
        $this->app->bind('CompanyService', function () {
            return new CompanyService();
        });
        $this->app->bind('ProgramService', function () {
            return new ProgramService();
        });
        $this->app->bind('ProgramParticipantService', function () {
            return new ProgramParticipantService();
        });
        $this->app->bind('GptService', function () {
            return new GptService();
        });
    }
}
