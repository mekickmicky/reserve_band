<?php 
  require 'src/condb.php'; 
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <title>
    เข้าสู่ระบบ
  </title>
  <?php require 'import-link.php'; ?>
</head>
<style type="text/css">
  .card-register{
    max-width: initial;
  }
</style>
<body class="register-page sidebar-collapse">
  <?php 
  require 'nav-bar.php'; 
  ?>

  <div class="page-header" style="background-image: url('assets/img/login-image.jpg');">
    <div class="filter"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 ml-auto mr-auto" style="width: 100%">
          <div class="card card-register">
            <h3 class="title mx-auto">เข้าสู่ระบบ</h3>
            <form class="register-form" method="post" action="src/member_login.php">
              <label>ชื่อผู้ใช้</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="ชื่อผู้ใช้" name="username">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fa fa-group" aria-hidden="true"></i></span>
                </div>
              </div>
              <label>รหัสผ่าน</label>
              <input type="password" class="form-control" placeholder="รหัสผ่าน" name="password">
              <a href="register.php">สมัครสมาชิก</a>
              <button class="btn btn-danger btn-block btn-round">เข้าสู่ระบบ</button>
            </form>
            <!-- <div class="forgot">
              <a href="#" class="btn btn-link btn-danger">Forgot password?</a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="footer register-footer text-center">
      <h6>©
        <script>
          document.write(new Date().getFullYear())
        </script>, made with <i class="fa fa-heart heart"></i> by Creative Tim</h6>
    </div>
  </div>

</body>

</html>

<?php

  require 'import-script.php';

?>