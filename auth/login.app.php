<?php
session_start();
include_once '../Providers/AuthServiceProvider.php';

AuthServiceProvider::isGuest();
include '../meta.php';
?>
<div class="container-fluid bg-dark p-0" style="height:100vh">
  <div class="row justify-content-center h-100 w-100 p-0 m-0">
    <div class="col-6 m-auto fv-sm-w-100">
      <div class="card bg-secondary shadow">
        <div class="card-header">
          <div class="p-2 w-50 mx-auto">
            <div class="fw-bold m-0 border-0 text-center">
              <a href="javascript:void(0)" class="btn-load text-decoration-none text-white col-8 col" href="javascript:void(0)">GalleryApp</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h5 class="text-center card-title text-white opacity-50">Connexion à votre compte</h5>
          <div class="my-2">
            <form action="controller/Login.controller.php" method="post">
            <div class="my-3 text-center">
              <h4 class="text-danger animated shake"><?php if (isset($_GET['message'])) echo $_GET['message']; ?></h4>
            </div>
              <div class="my-2">
                <input type="email" required class="form-control bg-light" id="userEmail" name="email" placeholder="Your Email *">
              </div>
              <div class="my-2 input-group">
                <input type="password" required class="form-control bg-light" name="password" placeholder="Your Password *">
                <button type="button" class="btn btn-danger password-visible"><i class="mdi mdi-eye-outline"></i></button>
              </div>
              <div class="my-2 d-flex justify-content-between">
                <a href="javascript:void(0)" class="btn btn-link text-white">Forgot your Password ?</a>
                <a href="register.app.php" class="btn btn-link text-white">Create Account</a>
              </div>
              <div class="my-3 text-center">
                <button class="btn btn-dark w-50" name="submit">LOGIN</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>