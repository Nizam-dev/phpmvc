<?php
define('root',$_SERVER['DOCUMENT_ROOT'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/');
define('view', root . 'view/');
define('models', root . 'app/model');
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/router.php';
require_once __DIR__ . '/ti.php';

function view($view,$dt = false)
{
    if($dt){
        $data = $dt;
    }
    require_once view . $view . '.php';
}