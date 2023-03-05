<?php

namespace LanciWeb\LaravelMakeView;

use Illuminate\Support\ServiceProvider;
use LanciWeb\LaravelMakeView\Commands\MakeViewCommand;

class LaravelMakeViewServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([MakeViewCommand::class]);
    }
  }
}
