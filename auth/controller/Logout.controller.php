<?php
  require_once '../../Providers/AuthServiceProvider.php';

  $db = AuthServiceProvider::bDConnect();
  if ($db) {
    $query = $db->prepare("UPDATE Gl_users SET status = 'offline' WHERE id=?");
    $query->execute(array($_SESSION['id']));
    session_destroy();
  }
  
  AuthServiceProvider::isLogin();

