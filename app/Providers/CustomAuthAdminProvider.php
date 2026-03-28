<?php
namespace App\Providers;
use Illuminate\Support\Facades\Auth;

use App\Providers\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthAdminProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->app['auth']->extend('usercustom-admin',function()
    {
        return new CustomUserAdminProvider();
    });
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }
}
