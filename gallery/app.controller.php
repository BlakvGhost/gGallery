<?php

include_once '../Providers/AppServiceProvider.php';

const DS = DIRECTORY_SEPARATOR;
const STORE_FOLDER = 'assets';

if (!empty($_FILES)) {
    $tmpFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname(__FILE__) . DS . STORE_FOLDER . DS;
    $targetFile = $targetPath . $_FILES['file']['name'];
    $type = $_FILES['file']['type'];
    
    switch (true) {
        case strstr($type, 'image'):
            $jsType = 'img';
            break;
        case strstr($type, 'video'):
            $jsType = 'video';
            break;
        case strstr($type, 'audio'):
            $jsType = 'audio';
            break;
        default:
            $jsType = 'link';
            break;
    }

    $size = round(($_FILES['file']['size'] / 1024) / 1024, 2);
    $caption = 'Image ajoutée le ' . date('H:i:s Y-m-d');

    if (move_uploaded_file($tmpFile, $targetFile)) {
        add_image(
            $_SESSION['id'],
            pathinfo($targetFile)['filename'],
            STORE_FOLDER . '/' . $_FILES['file']['name'],
            $type,
            pathinfo($targetFile)['extension'],
            $jsType,
            $caption,
            $size
        );
    } else {
        header('Location: ?error');
        exit;
    }
}
