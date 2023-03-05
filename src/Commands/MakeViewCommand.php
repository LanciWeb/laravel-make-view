<?php

namespace LanciWeb\LaravelMakeView\Commands;

use Illuminate\Console\Command;

class MakeViewCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:view 
  {path : The path for the view using the dot notation. If the CRUD option is used, then this is the name of the resource and will be used as the folder name.} 
  {--c|crud : If provided, generates the views for the resource.}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'creates a blade view or a set of views for CRUD operaions';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $views_path = resource_path('views');


    // If crud option is set
    if ($this->option('crud')) {
      $resource =  $this->argument('path');
      $resource_folder = "$views_path/$resource";

      if (!file_exists($resource_folder))  mkdir($resource_folder, 0777, true);

      foreach (['index', 'show', 'create', 'edit'] as $view) fopen("$resource_folder/$view.blade.php", 'w');

      $this->info("CRUD views for $resource successfully created!");
    } else {
      $arg =  $this->argument('path');
      $args = explode('.', $arg);
      $filename = array_pop($args);


      if (count($args)) foreach ($args as $folder) {
        if (!file_exists("$views_path/$folder"))  mkdir("$views_path/$folder", 0777, true);
        $views_path .= "/$folder";
      }

      fopen("$views_path/$filename.blade.php", "w");

      $this->info("View $arg successfully created!");
    }
    return Command::SUCCESS;
  }
}
