<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Providers/AppServiceProvider.php';

if (!isset($_SESSION['user']) || !$_SESSION['user']) {
  AuthServiceProvider::redirectTo('login', "Connectez-Vous d'abord");
  exit();
}

if (isset($_POST['id'], $_POST['action'], $_POST['title'], $_POST['caption'])) {
  $id = $_POST['id'];
  $action = $_POST['action'];
  $t = $_POST['title'];
  $c = $_POST['caption'];

  $change = manageMedias($id, $action, $t, $c);
  http_response_code(200);
  header('Content-Type: application/json');
  echo json_encode(['message' => $change]);
} else {
  http_response_code(400);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Paramètres manquants']);
}
