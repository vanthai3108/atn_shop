<?php

require 'core/session.php';
$session = new session();

if($session->has('Username') && $session->get('Username') != NULL){
    $session->remove('Username');
    header('location: index.php');
}


?>