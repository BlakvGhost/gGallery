<?php
require_once '../../Providers/AuthServiceProvider.php';

$user = [
    "email" => htmlentities($_POST['email']),
    "mdp" => password_hash(htmlentities($_POST['password1']), PASSWORD_DEFAULT),
    "username" => htmlentities($_POST['username'])
];

if (isset($_POST['submit'])) {
    if (!empty($user['email']) && !empty($user['username']) && !empty($user['mdp'])) {
        if (password_verify($_POST['password2'], $user['mdp'])) {
            $model = AuthServiceProvider::bDConnect();
            $pk = $model->prepare('INSERT INTO Gl_users(email, mdp, username) VALUES (:email, :mdp, :username)');
            if ($us = $pk->execute($user)) {
                $_SESSION['online'] = true;
                $_SESSION['id'] = $us['id'];
                return header('Location:../../gallery/');
            }
            return AuthServiceProvider::redirectTo('register', "Invalid data");
        }
        return AuthServiceProvider::redirectTo('register', "Vos deux mots de passe ne sont pas identiques");
    }
    return AuthServiceProvider::redirectTo('register', "Veillez remplir tout les champs de saisie");
}
