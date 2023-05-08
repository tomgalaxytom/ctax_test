<?php
  /*
  
   * Base Controller
   * Loads the models and views
   */
  class Controller {

    public function __construct()
    {
      
    }
    // Load model
    public function model($model){
      //echo $model;
      // Require model file
      require_once 'app/models/' . $model . '.php';

      // Instatiate model
      return new $model();
    }


    public function controller($controller){
      //echo $model;
      // Require model file
      require_once 'app/controllers/' . $controller . '.php';

      // Instatiate model
      return new $controller();
    }


    // Load view
    public function view($view, $data = []){
      //echo $view;
      // Check for view file
      if(file_exists('app/views/' . $view . '.php')){
        require_once 'app/views/' . $view . '.php';
      } else {
        // View does not exist
        die('View does not exist');
      }
    }
  }