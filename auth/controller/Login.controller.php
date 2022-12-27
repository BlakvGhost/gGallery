<?php
require_once '../../Providers/AuthServiceProvider.php';

$user = [
    "email" => htmlentities($_POST['email']),
    "mdp" => htmlentities($_POST['password']),
];

if (isset($_POST['submit'])) {
    if (!empty($user['email']) && !empty($user['mdp'])) {
        $auth = new AuthServiceProvider;
        if ($us = $auth->checkUser($user)) {
            $_SESSION['online'] = true;
            $_SESSION['id'] = $us['id'];
            return header('Location:../../gallery/');
        }
    }
}
return AuthServiceProvider::redirectTo('login', "Invalid Data");
