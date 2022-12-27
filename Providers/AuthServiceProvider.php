<?php
session_start();

class AuthServiceProvider
{

    static function isLogin()
    {
        $to =  isset($_SESSION['online']) ? "/GalleryApp/gallery/" : "/GalleryApp/auth/login.app.php";
        return header('Location:' . $to);
    }

    static function isGuest()
    {
        return !isset($_SESSION['online'])? null: header("Location:/GalleryApp/gallery/");   
    }

    public function checkUser($user)
    {
        $db = $this->bDConnect();

        $query = $db->prepare('SELECT * FROM Gl_users WHERE email = ?');
        $query->execute(array($user['email']));
        if ($data = $query->fetch()) {
            if (password_verify($user['mdp'], $data['mdp'])) {
                $add = $db->prepare("UPDATE Gl_users SET status = 'online', last_UA = ?, last_date = ? WHERE id=?");
                $add->execute(array($_SERVER['HTTP_USER_AGENT'], date('Y-m-d H:i:s'), $data['id']));
                return $data;
            }
        }
        return false;
    }

    static function redirectTo($to, $message = '')
    {
        $to =  '/GalleryApp/' . 'auth/' . $to . '.app.php' . '?message=' . $message;

        return header('Location:' . $to);
    }

    static function bDConnect($dbname = 'gallery', $user = 'root', $pass = '')
    {
        try {
            $db = new PDO("mysql:host=localhost;dbname=$dbname", "$user", "$pass");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (\Exception $e) {
            echo "<div class='form_check fail'> Erreur de connexion à la Base de Données !</div> ";
            die();
        }
    }
}
