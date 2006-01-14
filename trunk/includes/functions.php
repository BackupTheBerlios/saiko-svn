<?php
/* Collection of useful functions */

function skLog($message)
{
    $fp = fopen('console.log', 'a');
    fwrite($fp, $message."\n");
    fclose($fp);
}

function displayTemplate($title, $template, $vars)
{
    $t = new Template($title);
    $t->display('header');
    if(is_array($vars))
    {
        foreach ($vars as $var => $val)
        {
            $t->assignVar($var, $val);
        }
    }
    $t->display($template);
    $t->display('footer');
}

function linkTo($title, $controller, $action, $id)
{
    return '<a href="'.PATH.'/'.$controller.'/'.$action.'/'.$id.'">'.$title.'</a>';
}

function error($errorMessage, $line, $file)
{
    if(defined('DEBUG'))
    {
        $errorMessage .= '(Line: '.$line.')<br />';
        $errorMessage .= '(File: '.$file.')';
    }
    displayTemplate('An Error Occured', 'error', array('message' => $errorMessage));
    skLog($errorMessage);
    exit();
}

function redirect($location, $message)
{
    if(!$location)
    {
        $href = PATH.'/';
    }
    else
    {
        $href = PATH.$location;
    }
?>
<meta http-equiv="refresh" content="3;URL=<?php echo $href; ?>">
<title>Redirecting...</title>
<?php
    if(isset($message))
    {
        echo "<div id=\"redirect-message\">\n".$message."\n</div>";
    }
}

function hash($string)
{
    return md5($string);
}

function prepareValue($value)
{
    $value = htmlspecialchars($value);
    $value = str_replace("$", "&#36;", $value);
    if (get_magic_quotes_gpc() == 0)
    {
        $value = addslashes($value);
    }
    return $value;
}

function httpPostVar($var, $defVal)
{
    return (isset($_POST[$var]) ? $_POST[$var] : $defVal);
}

function httpGetVar($var, $defVal)
{
    return (isset($_GET[$var]) ? $_GET[$var] : $defVal);
}
?>