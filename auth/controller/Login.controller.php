<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Providers/AuthServiceProvider.php';

$user = [
    "email" => htmlentities($_POST['email']),
    "mdp" => htmlentities($_POST['password']),
];

if (isset($_POST['submit'])) {
    if (!empty($user['email']) && !empty($user['mdp'])) {
        $auth = new AuthServiceProvider;
        if ($user = $auth->checkUser($user)) {
            $_SESSION['user'] = $user;
            return header('Location:/my-gallery');
        }
        return AuthServiceProvider::redirectTo('login', "Invalid User Credentials");
    }
}
return AuthServiceProvider::redirectTo('login', "Invalid Data");
