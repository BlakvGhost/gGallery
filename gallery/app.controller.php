<?php
include '../Providers/AppServiceProvider.php';

$ds = DIRECTORY_SEPARATOR;

$storeFolder = 'assets';

if (!empty($_FILES)) {
  $tmpFile = $_FILES['file']['tmp_name'];
  $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;
  $targetFile = $targetPath . $_FILES['file']['name'];
  $type = $_FILES['file']['type'];
  if (strstr($type, 'image')) {
    $jsType = 'img';
  } elseif (strstr($type, 'video')) {
    $jsType = 'video';
  } elseif (strstr($type, 'audio')) {
    $jsType = 'audio';
  } else {
    $jsType = 'link';
  }
  $size = ($_FILES['file']['size'] / 1024) / 1024;
  $caption = 'image ajouter le ' . date('H:i:s Y-m-d');
  if (move_uploaded_file($tmpFile, $targetFile)) {
    add_image(
      $_SESSION['id'],
      pathinfo($targetFile)['filename'],
      'assets/' . $_FILES['file']['name'],
      $_FILES['file']['type'],
      pathinfo($targetFile)['extension'],
      $jsType,
      $caption,
      $size
    );
  } else {
    header('Location:?error');
  }
}
