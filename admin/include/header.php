<?php

require '../../core/database.php';
require '../../core/session.php';
require '../../core/file.php';
require '../../config/config.php';

$db = new database();
$session = new session();
$file = new file();

?>
<ul class='navbar-nav'>
    <?php
    if ($session->has('Username')&& $session->get('Username') != null){
        $Username = $session->get('Username');
        $user_permiss = $db->table('user')->check([
            'Username' => $Username,
            'Permission' => 1
        ]);
        if ($user_permiss > 0) {
            $avatar = $user_permiss['AvataImage'];
            echo "
            <li class='nav-item dropdown'>
                <a class='nav-link  dropdown-toggle' href='#'' id='navbardrop' data-toggle='dropdown'>
                    <img class='avatar' src='../../images/$avatar'>
                </a>
                <div class='dropdown-menu'>
                    <a class='dropdown-item' href='../../index.php'>User Page</a>
                    <a class='dropdown-item' href='../../logout.php'>Logout</a>
                </div>
            </li>
            ";
        }
        else {
            header("location: ../../index.php");
        }
    }
    else{
        header("location: ../../index.php");
    }
    ?> 
</ul>