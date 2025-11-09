<?php

namespace App\Providers;
use DB;
use Config;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
          // dynamic constact varable
        $settings = DB::table('settings')->get();
        foreach ($settings as $setting) {
            Config::set('constants.' . $setting->name, $setting->description);
            
        }
    }
}
