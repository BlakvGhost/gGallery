<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Providers/AuthServiceProvider.php';

$user = [
    "email" => htmlentities($_POST['email']),
    "mdp" => password_hash(htmlentities($_POST['password1']), PASSWORD_DEFAULT),
    "username" => htmlentities($_POST['username'])
];

if (isset($_POST['submit'])) {
    if (!empty($user['email']) && !empty($user['username']) && !empty($_POST['password1'])) {
        if (password_verify($_POST['password2'], $user['mdp'])) {
            $auth = new AuthServiceProvider;
            if ($auth->checkUser($user, true)) {
                return AuthServiceProvider::redirectTo('register', "User Already Exist");
            }
            $pk = AuthServiceProvider::bDConnect()
                ->prepare('INSERT INTO 
                Gl_users(email, mdp, username) 
                VALUES (:email, :mdp, :username)
                ');
            if ($pk->execute($user)) {
                $_SESSION['user'] = $user;
                return header('Location:/my-gallery');
            }
            return AuthServiceProvider::redirectTo('register', "Invalid data");
        }
        return AuthServiceProvider::redirectTo('register', "Vos deux mots de passe ne sont pas identiques");
    }
    return AuthServiceProvider::redirectTo('register', "Veillez remplir tout les champs de saisie");
}
