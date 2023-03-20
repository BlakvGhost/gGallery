<?php
session_start();

class AuthServiceProvider
{

    static function isLogin()
    {
        $to =  isset($_SESSION['user']) ? "/my-gallery" : "/user/login";
        return header('Location:' . $to);
    }

    static function isGuest()
    {
        return !isset($_SESSION['user'])? null: header("Location:/my-gallery");   
    }
    
    static function mustLogin()
    {
        return !isset($_SESSION['user'])? header("Location:/user/login"): null;   
    }

    public function checkUser($user, $email = false)
    {
        $db = $this->bDConnect();

        $query = $db->prepare('SELECT * FROM Gl_users WHERE email = ?');
        $query->execute(array($user['email']));
        $data = $query->fetch();
        if ($email) {
            return $data;
        }
        if ($data && !$email) {
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
        $to =  '/' . 'user/' . $to;

        $_SESSION['message'] = $message;

        return header('Location:' . $to);
    }

    static function printSessionMessage()
    {
        $message = '';
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        return $message;   
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
