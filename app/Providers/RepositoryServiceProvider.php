<?php

namespace App\Providers;

use App\Interfaces\MailerRepositoryInterface;
use App\Repositories\MailerRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind(MailerRepositoryInterface::class, MailerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
