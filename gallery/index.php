<?php
include '../Providers/AppServiceProvider.php';

isset($_SESSION['online'])? null: header("Location:../auth/login.app.php");
include '../meta.php';
?>
<div class="user">
  <div class="user_info bxs">
    <div class="">
      <p><a href="../" class=""><i class="mdi mdi-home-circle-outline"></i>&nbsp;&nbsp; Home </a></p>
      <div class="flex justify-sb">
        <p><a href="?page=add_image" class=""><i class="mdi mdi-cloud-upload"></i> Upload</a></p>
        <p><a href="../auth/logout.app.php" class=""><i class="mdi mdi-logout"></i> Logout</a></p>
        <p><a href="javascript:void(0)"><i class="mdi mdi-cog"></i>Setting </a> </p>
      </div>
    </div>
    <ul class="user_info_ul">
      <?php $user = user($_SESSION['id']) ?>
      <li><u>Username</u> : <?php echo $user['username'] ?> </li>
      <li><u>Storage</u> : <?php echo sumSize($_SESSION['id']) ?> / 2 Go </li>
    </ul>
  </div>
  <div class="user_lg bxs">
    <p class="m10"><i class="mdi mdi-account"></i> </p>
  </div>
</div>
<?php
$get = $_GET;
 $media = view_medias($_SESSION['id']);
if (isset($get['page'])) {
  switch ($get['page']) {

    case 'add_image':
      include 'post.php';
      break;

    case 'view_image':
      include 'page.php';
      break;

    default:
      include 'page.php';
      break;
  }
} else {
  include 'page.php';
}
?>
</body>

</html>
