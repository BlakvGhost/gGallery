<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Providers/AuthServiceProvider.php';

$db = AuthServiceProvider::bDConnect();
if ($db) {
  $query = $db->prepare("UPDATE Gl_users SET status = 'offline' WHERE email=?");
  $query->execute(array($_SESSION['user']['email']));
  session_destroy();
}

AuthServiceProvider::isLogin();
