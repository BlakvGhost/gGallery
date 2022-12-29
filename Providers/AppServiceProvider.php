<?php
 
 require '../Providers/AuthServiceProvider.php';

function user($id)
{
    $db = AuthServiceProvider::bDConnect();
    $query = $db->prepare("SELECT * FROM Gl_users WHERE id = ?");
    $query->execute(array($id));
    return $query->fetch();
}
function add_image($id, $title, $path, $type, $extension, $Type, $caption, $size)
{
    $db = AuthServiceProvider::bDConnect();
    $query = $db->prepare("INSERT INTO Gl_medias (user_id,titre,_path,type,ext,jsType,caption,size) VALUES (?,?,?,?,?,?,?,?)");
    $added = $query->execute(array($id, $title, $path, $type, $extension, $Type, $caption, $size));
    if ($added) {
        return true;
    } else {
        return false;
    }
}
function view_medias($id_user)
{
    $db = AuthServiceProvider::bDConnect();
    $query = $db->prepare("SELECT * FROM Gl_medias WHERE user_id = :a ORDER BY id DESC ");
    $query->bindValue(':a', $id_user, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchAll();
}
function viewMedias($id_medias)
{
    $db = AuthServiceProvider::bDConnect();
    $query = $db->prepare("SELECT * FROM Gl_medias WHERE id = :a");
    $query->bindValue(':a', $id_medias, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch();
}

function manageMedias($idEl, $action, $titreEl, $captionEl)
{
    $db = AuthServiceProvider::bDConnect();
    if ($action == 1) {
        $query = $db->prepare('DELETE FROM Gl_medias WHERE id = :id');
        $query->bindValue(':id', htmlentities($idEl), PDO::PARAM_INT);
        $file = viewMedias($idEl);
        if (file_exists('../gallery/' . $file['_path'])) {
            unlink('../gallery/' . $file['_path']);
        }
    } elseif ($action == 2) {
        $query = $db->prepare("UPDATE Gl_medias SET titre = :titre , caption = :caption  WHERE id = :id ");
        $query->bindValue(':titre', htmlentities($titreEl), PDO::PARAM_STR);
        $query->bindValue(':caption', htmlentities($captionEl), PDO::PARAM_STR);
        $query->bindValue(':id', htmlentities($idEl), PDO::PARAM_INT);
    }
    $data = $query->execute();
    return $data;
}
function sumSize($id_user)
{
    $db = AuthServiceProvider::bDConnect();
    $query = $db->prepare("SELECT SUM(size) AS size FROM Gl_medias WHERE user_id =?");
    $query->execute(array($id_user));
    $size = $query->fetch();
    return round($size['size'] / 1024, 4);
}
