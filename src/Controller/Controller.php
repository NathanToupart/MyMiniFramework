<?php

namespace App\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller
{
    protected $viewPath = './ressources/view/';
    private $loader;
    protected $twig;
    public function __construct()
    {
        $this->loader = new FilesystemLoader($this->viewPath);
        $this->twig = new Environment($this->loader);
    }

    public function render($view, $variables = [])
    {
        $this->twig->display(str_replace('.', '/', $view) . '.html.twig', $variables);
    }

    public function redirect($url, array $param = null){
        if($param != null){
            $array = [];
            foreach($param as $key => $v){
                $array[] = "$key=$v";
            }
            $url = $url. "?".implode('&', $array);
        }
        
        header('Location: '.$url);
    }

    public function error404()
    {
        $this->twig->display('404.html.twig');
    }
}
