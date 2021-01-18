<?php


class Controller
{
    protected $view;

    public function __construct(){
        session_start();
        $_SESSION['q'] = 'sdfadf';
        $this->view = new View();
    }

    final public function view($view_name, $params = []){
        foreach($params as $key=>$value){
            $this->view->assign($key, $value);
        }
        $this->view->display($view_name);
    }

    public function __destruct()
   {
      exit();
   }
}