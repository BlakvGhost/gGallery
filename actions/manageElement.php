<?php
session_start();
if (!$_SESSION['online']){
  header('Location:../?msg=Connectez-vous d\'abord');
}?>
<?php
include '../Providers/AppServiceProvider.php';
$allR = $_REQUEST;
$change = manageMedias($allR['id'],$allR['action'],$allR['t'],$allR['c']);
echo $change;
?>
