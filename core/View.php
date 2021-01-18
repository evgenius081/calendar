<?php


class View
{
    private $var;
    private $path;

   public function __construct(){
        $this->path = __DIR__.DIRECTORY_SEPARATOR."views". DIRECTORY_SEPARATOR;
   }

   public function path($dirname){
       $dirname = __DIR__.DIRECTORY_SEPARATOR.$dirname;
       if(substr($dirname, -1) !== DIRECTORY_SEPARATOR){
           $dirname.=DIRECTORY_SEPARATOR;
       }
       if(!is_dir($dirname)){
           mkdir($dirname);
       }
       $this->path = $dirname;
   }

   public function display($view_name, $params = []){
       include $this->path.$view_name.'.php';
   }

   public function assign($key, $value):void{
        $this->var[$key] = $value;
   }

}