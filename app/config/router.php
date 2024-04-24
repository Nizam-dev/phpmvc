<?php

class Route{
    private $handled = false;

    public function get($route, $callback)
    {
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            return false;
        }
       
        if($this->url() == $route){
           return $this->tocontroller($callback);
        }else if($this->withparam($route)){
            $this->handled = true;
            $param = $this->url();
            $param = explode('/',$param);
            return $this->tocontroller($callback, end($param));
        }
    }

    public function post($route, $callback)
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return false;
        }
       
        if($this->url() == $route){
            return $this->tocontroller($callback);
        }
    }

    public function tocontroller($callback , $param = false)
    {
        $this->handled = true;
        $call =explode("->", $callback);
        require_once root . 'app/controller/'.$call[0].'.php';
        $class = new $call[0]();
        $method = $call[1];
       if($param){
        return $class->$method($param);
       }else{
        return $class->$method();
       }
    }

    public function withparam($route)
    {
        if(preg_match("/{*}/i", $route)){
            $data_url = $this->url();
            $data_url = explode("/",$data_url);
            array_pop($data_url);
            $data_route = explode("/",$route);
            array_pop($data_route);
            if($data_route == $data_url){
                return true;
            }

        }
        return false;
    }

    public function url()
    {
        $getrl = array_key_exists("url",$_GET) ? $_GET['url'] : '';
        $url = rtrim($getrl,'/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if($url == ''){
            $url = '/';
        }
        return $url;
    }

    function __destruct()
    {
        if(!$this->handled){
            echo $this->url();
            echo "404";
            return 404;
        }
    }
}