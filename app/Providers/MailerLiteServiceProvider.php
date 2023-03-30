<?php

namespace App\Providers;

use App\Models\Account;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;
use MailerLiteApi\MailerLite;

class MailerLiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MailerLite::class, function ($app) {
            try {
                if(Account::exists()) { 
                    $apiKey = Crypt::decryptString(Account::first()->api_key);
                    return new MailerLite($apiKey);
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    dd($e);
            }
        });  
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
