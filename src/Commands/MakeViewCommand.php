<?php

namespace LanciWeb\LaravelMakeView\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeViewCommand extends Command
{
  /**
   * The views folder path
   * @var string
   */
  protected string $views_path;

  /**
   * The path provided by the user as an argument
   * 
   * @var string
   */
  protected string $arg;

  /**
   * An array formed from the string argument provided by the user
   * 
   * @var array
   */
  protected array $arg_elements;

  /**
   * The last element of the exploded array, used as the name of the view to create.
   * If the --crud option is provided, this will be the name of the folder for the views.
   * 
   * @var string
   */
  protected string $last_element;


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
    // Setup of all initial values
    $this->views_path = resource_path('views');
    $this->arg =  $this->argument('path');
    $this->arg_elements = explode('.', $this->arg);
    $this->last_element = array_pop($this->arg_elements);

    // Create folders according to the path argument
    if (count($this->arg_elements)) $this->createFolders();

    // If CRUD Option is provided, generate the folder(s) and the canonical views
    if ($this->option('crud')) $this->generateCrudViews();

    // If CRUD Option is not provided generate a single view.
    else $this->generateView();

    return Command::SUCCESS;
  }

  /**
   * Creates the folders based on user provided path argument
   * @return void
   */
  protected function createFolders()
  {
    foreach ($this->arg_elements as $folder) {
      if (!File::exists("$this->views_path/$folder"))  File::makeDirectory("$this->views_path/$folder", 0777, true);
      $this->views_path .= "/$folder";
    }
  }

  /**
   * Creates the folders and the views based on user provided path argument when CRUD option is enabled
   * @return void
   */
  protected function generateCrudViews()
  {
    $resource_folder = "$this->views_path/$this->last_element";
    if (!File::exists($resource_folder)) File::makeDirectory($resource_folder, 0777, true);

    foreach (['index', 'show', 'create', 'edit'] as $view) {
      $file_path = "$resource_folder/$view.blade.php";
      $file_name = "$this->arg.$view.blade.php";
      $this->fileCheck($file_path, $file_name);
    }
  }

  /**
   * Creates the view based on user provided path argument 
   * @return void
   */
  protected function generateView()
  {
    $file_path = "$this->views_path/$this->last_element.blade.php";
    $file_name = $this->arg;
    $this->fileCheck($file_path, $file_name);
  }


  /**
   * Checks wether the file exists and creates it.
   * If file exists prompt for confirmation.
   * 
   * @param string $file_path - the path where to create the file
   * @param string $file_name - the name of the file in the console messages
   * @return void
   */
  public function fileCheck($file_path, $file_name)
  {
    if (File::exists($file_path)) {
      $this->warn("View $file_name already exists.");
      if ($this->confirm('Do you want to overwrite it?')) $this->createFile($file_path, $file_name);
    } else {
      $this->createFile($file_path, $file_name);
    }
  }

  /**
   * Creates the file and shows the success message to the user
   * 
   * @param string $file_path - the path where to create the file
   * @param string $file_name - the name of the file in the console messages
   * @return void
   */
  function createFile($file_path, $file_name)
  {
    try {
      File::put($file_path, '');
      $this->info("View $file_name successfully created!");
    } catch (Exception $e) {
      $this->error("Could not create view $file_name.");
    }
  }
}
