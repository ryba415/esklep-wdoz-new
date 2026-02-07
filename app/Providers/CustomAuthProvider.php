<?php
namespace App\Providers;
use Illuminate\Support\Facades\Auth;

use App\Providers\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->app['auth']->extend('usercustom',function()
    {
        
        return new CustomUserProvider();
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
