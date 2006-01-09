<?php

define('SESSION_EXPIRE', 86400);

$_SESS = array();

pruneSessions();

if(isset($_COOKIE['sess_key']))
{
    // Load the $_SESS array.
    readSession($_COOKIE['sess_key']);
}
else
{
    // Create a new session for them, with a unique key, and create a cookie to store that key.
    $key = hash(time() + (rand() % 9999));
    setcookie('sess_key', $key, (time() + SESSION_EXPIRE), '/');
    $db->query('INSERT INTO sessions (sess_key, sess_expires, sess_uid) VALUES (\''.$key.'\', \''.(time() + SESSION_EXPIRE).'\', 0)');
    $_SESS = array('sess_key' => $key, 'sess_expires' => (time() + SESSION_EXPIRE), 'sess_uid' => 0);
    $user = array(
            'id'    => 0,
            'guest' => TRUE,
            'username'  => 'Guest',
            'password'  => 'kAjafr00'
            );
}

updateSession();

function pruneSessions()
{
    global $db;
    $db->query('DELETE FROM sessions WHERE sess_expires < '.time());
}

function readSession($key)
{
    global $db, $_SESS, $user;
    $query = $db->query('SELECT * FROM sessions WHERE sess_key = \''.$key.'\'');
    $_SESS = $query->fetchRow(DB_FETCHMODE_ASSOC);
    
    if($_SESS['sess_uid'] > 0)
    {    
        $userQuery = $db->query('SELECT * FROM users WHERE id = \''.$_SESS['sess_uid'].'\'');
        $user = $userQuery->fetchRow(DB_FETCHMODE_ASSOC);
    }
}

function updateSession()
{
    global $db, $_SESS;
    
    $db->query('UPDATE sessions SET sess_expires = \''.(time() + SESSION_EXPIRE).'\', sess_uid = \''.$_SESS['sess_uid'].'\' WHERE sess_key = \''.$_SESS['sess_key'].'\'');
    readSession($_SESS['sess_key']);
}


?>