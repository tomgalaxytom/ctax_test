<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    public function index(){     
      $this->view('web/index');
    }
    public function Screen_recorder(){     
      $this->view('web/screen_reader');
    }
    public function notfound()
    {
      $this->view('web/404');
    }
  }
   