<?php
  require_once '../../Providers/AuthServiceProvider.php';

  $db = AuthServiceProvider::bDConnect();
  if ($db) {
    $query = $db->prepare("UPDATE Gl_users SET status = 'offline' WHERE email=?");
    $query->execute(array($_SESSION['email']));
    session_destroy();
  }
  
  AuthServiceProvider::isLogin();

