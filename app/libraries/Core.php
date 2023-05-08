<?php
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */
  class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
      $isfound = true;
      $url = $this->getUrl();
      //print_r($url);
      //echo  ucwords($url[0]);
      // Look in controllers for first value
      if(isset($url[0]) )
      if( file_exists('app/controllers/' . ucwords($url[0]). '.php')){
        // If exists, set as controller
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
      }else{
        $isfound = false;
      }
     //echo $this->currentController;
      // Require the controller
      require_once 'app/controllers/'. $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;
      
      // Check for second part of url
      if(isset($url[1]) and $isfound){
        // Check to see if method exists in controller
        if(method_exists($this->currentController, $url[1])){
          $this->currentMethod = $url[1];
         
          //echo $this->currentMethod;
          // Unset 1 index
          unset($url[1]);
        }else{
          $isfound = false;
          $this->currentController = new Notfound;
        }
      }
      if(!$isfound){
        $this->currentMethod = "notfound";
      }
      // Get params
      $this->params = $url ? array_values($url) : [];
     
     //echo $this->currentController;
      // Call a callback with array of params
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
      if(isset($_GET['url'])){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  } 
  
  