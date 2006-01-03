<?php
$pluginData = array('className' => 'Users', 'author' => 'ashanks', 'version' => 1.0);

class Users
{
    function init($params)
    {
        switch($params['action'])
        {
            case 'login':
                // works
                $this->login();
                break;
            case 'logout':
                // works
                $this->logout();
                break;
            case 'register':
                $this->register();
                break;
            case 'edit-profile':
                $this->editProfile();
                break;
            case 'viewprofile':
                $this->viewProfile($params['id']);
            default:
                $this->userList();
                break;
        }
    }
    
    function login()
    {
        global $user, $db, $_SESS;
        if(httpPostVar('login', NULL)) {
            // Log them in.
            $sql = $db->query('SELECT * FROM users WHERE username = \''.httpPostVar('username', 'Guest').'\' AND password = \''.hash(httpPostVar('password', NULL)).'\'');
            $user = $sql->fetchRow(DB_FETCHMODE_ASSOC);
            if(!$user)
            {
                error('You have entered the wrong username or password.', __LINE__, __FILE__);
            }
            $_SESS['sess_uid'] = $user['id'];
            updateSession();
        } else {
            // display Login Form.
            displayTemplate('Login', 'user_login_form', NULL);
        }
    }
    
    function logout()
    {
        // Log 'em out.
        global $_SESS;
        $_SESS['sess_uid'] = 0; // Set them guest.
        updateSession(); // Refresh the session.
    }
    
    function register()
    {
        // Sign 'er up!
        global $db;
        
        if(httpPostVar('register', NULL)) {
            // create an account.
            $username = httpPostVar('username', NULL);
            $password = httpPostVar('password', NULL);
            $email = httpPostVar('email', NULL);
            if(!$username || !$password || !$email)
            {
                error('Please fill out all fields.', __LINE__, __FILE__);
            }
            $sql = $db->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)');
            $db->execute($sql, array($username, hash($password), $email));
        } else {
            // show register form.
            redirect('/users/login', 'Login');
            //displayTemplate('Ÿber simple registration!', 'user_form', array('action' => array('location' => '/users/register', 'name' => 'register', 'title' => 'Register!')));
        }
    }
    
    function editProfile()
    {
        // edit profile.
    }
    
    function viewProfile($id)
    {
        // view profile.
        global $db;
        $query = $db->query('SELECT * FROM users WHERE id = \''.(int)$id.'\'');
        $res = $query->fetchRow(DB_FETCHMODE_ASSOC);
        $res['password'] = ''; // uhm, because I don't trust templates.
        displayTemplate('Profile For '.$res['username'], 'user_viewprofile', array('data' => $res));
    }
    
    function userList()
    {
        // view user list.
    }
}
?>