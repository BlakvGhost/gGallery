<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Providers/AuthServiceProvider.php';

AuthServiceProvider::isGuest();
include $_SERVER['DOCUMENT_ROOT'] . '/meta.php';
?>
<div class="container-fluid bg-dark p-0" style="height:100vh">
  <div class="row justify-content-center h-100 w-100 p-0 m-0">
    <div class="col-md-6 col-sm-10 col-xs-12 m-auto fv-sm-w-100">
      <div class="card bg-secondary shadow">
        <div class="card-header">
          <div class="p-2 w-50 mx-auto">
            <div class="fw-bold m-0 border-0 text-center">
              <a href="javascript:void(0)" class="btn-load text-decoration-none text-white col-8 col" href="javascript:void(0)">GalleryApp</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h5 class="text-center card-title text-white opacity-50">Ouverture de votre compte</h5>
          <div class="my-2">
            <div class="my-3 text-center">
              <h4 class="text-danger animated shake"><?= AuthServiceProvider::printSessionMessage() ?></h4>
            </div>
            <form action="/user/app/register" method="post">
              <div class="my-2">
                <input type="email" required class="form-control bg-light" id="userEmail" name="email" placeholder="Your Email *">
              </div>
              <div class="my-2">
                <input type="text" required class="form-control bg-light" id="username" name="username" placeholder="Your Username *">
              </div>
              <div class="my-2 input-group">
                <input type="password" class="form-control bg-light" name="password1" placeholder="Your Password">
                <button type="button" class="btn btn-danger password-visible"><i class="mdi mdi-eye-outline"></i></button>
              </div>
              <div class="my-2 input-group">
                <input type="password" class="form-control bg-light" name="password2" placeholder="Confirm Password">
                <button type="button" class="btn btn-danger password-visible"><i class="mdi mdi-eye-outline"></i></button>
              </div>
              <div class="my-2 d-flex justify-content-between">
                <a href="/user/login" class="btn btn-link text-white">Already have account ?</a>
              </div>
              <div class="my-3 text-center">
                <button class="btn btn-dark w-50" name="submit">Create Your Account</button>
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