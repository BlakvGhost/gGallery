<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Providers/AppServiceProvider.php';

AuthServiceProvider::mustLogin();

include $_SERVER['DOCUMENT_ROOT'] . '/meta.php';
?>
<div class="user">
  <div class="user_info bxs">
    <div class="">
      <p><a href="/my-gallery" class=""><i class="mdi mdi-home-circle-outline"></i>&nbsp;&nbsp; Home </a></p>
      <div class="flex justify-sb">
        <p><a href="/my-gallery/upload" class=""><i class="mdi mdi-cloud-upload"></i> Upload</a></p>
        <p><a href="/user/logout" class=""><i class="mdi mdi-logout"></i> Logout</a></p>
        <p><a href="javascript:void(0)"><i class="mdi mdi-cog"></i>Setting </a> </p>
      </div>
    </div>
    <ul class="user_info_ul">
      <li><u>Username</u> : <?php echo $_SESSION['user']['username'] ?> </li>
      <li><u>Storage</u> : <?php echo sumSize($_SESSION['user']['email']) ?> / 2 Go </li>
    </ul>
  </div>
  <div class="user_lg bxs">
    <p class="m10"><i class="mdi mdi-account"></i> </p>
  </div>
</div>
<?php
 $get = $_GET;
 $media = view_medias($_SESSION['user']['email']);
if (isset($get['page'])) {
  switch ($get['page']) {

    case 'upload':
      include 'post.php';
      break;

    case 'home':
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
