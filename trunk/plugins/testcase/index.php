<?php
$pluginData['nonOOP'] = TRUE;

function init($args)
{
    global $_SESS, $user;
    die(print(httpGetVar('foobar', "Wow you're so cool!")));
    displayTemplate('Hello, World', 'user_login_form', array('foo' => 'bar'));
    $_SESS['sess_uid'] = 1;
    updateSession();
    print_r($_SESS);
    print_r($user);
    /*
    while($i < 50)
    {
        print $i.'...<br />';
        $i++;
    }
    print_r($args);*/
}
?>