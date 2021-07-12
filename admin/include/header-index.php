<?php

require '../core/database.php';
require '../core/session.php';
require '../config/config.php';

$db = new database();
$session = new session();

?>
<div class="container header">
    <nav class="navbar navbar-expand-md bg-info navbar-dark">
        <a class="navbar-brand" href="index.php"><img class='logo' src="../images/013.svg"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user/user.php">Manage users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product/pro.php">Manage product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category/cat.php">Manage category</a>
                </li>  
            </ul>
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
                            <img class='avatar' src='../images/$avatar'>
                        </a>
                        <div class='dropdown-menu'>
                            <a class='dropdown-item' href='../index.php'>User Page</a>
                            <a class='dropdown-item' href='../logout.php'>Logout</a>
                        </div>
                    </li>
                    ";
                }
                else {
                    header("location:../index.php");
                }
            }
            else{
                header("location: ../index.php");
            }
            ?> 
            </ul>
        </div> 
    </nav>
</div>