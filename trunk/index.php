<?php
/* Main file. OMGWTFBBQ */
require 'includes/global.php';

$params = explode('/', $_SERVER['REQUEST_URI']);

/*$key = array_search(ROOT, $params);
for($i = 0; $i < count($params); $i++)
{
    if($i != $key)
    {
        $newParams[$i+1] = $params[$i+1];
    }
}
unset($params);*/
$args = array('controller' => $params[1+$pathOffset], 'action' => $params[2+$pathOffset], 'id' => $params[3+$pathOffset]);
unset($params); // Non-needed array reduces memory footprint
loadPlugin($args);

function loadPlugin($args)
{
    //print 'loading '.$args['controller'].' with action '.$args['action'].' and id '.$args['id'];
    $path = 'plugins/'.$args['controller'].'/index.php';
    if(file_exists($path))
    {
        include $path;
        if(!$pluginData['nonOOP'])
        {
            $obj = new $pluginData['className'];
            $obj->init($args); // On second thought, can't we just handle the class and it take over at the constructor part? Sure. No ashanks, you're wrong. We've got to pass the args array to init.
        }
        else
        {
            call_user_func('init', $args);
        }
    }
}
?>
