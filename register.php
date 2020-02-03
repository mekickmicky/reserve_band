<?php 
  require 'src/condb.php'; 
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <title>
    สมัครสมาชิก
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
        <div class="col-lg-8 ml-auto mr-auto">
          <div class="card card-register">
            <h3 class="title mx-auto">สมัครสมาชิก</h3>
            <form class="register-form" method="post" action="src/member_register.php">
              <div class="col-lg-6" style="float: left;">
                
                <label>ชื่อ</label>
                <input type="text" class="form-control" placeholder="ชื่อ" name="name" required>
                <label>นามสกุล</label>
                <input type="text" class="form-control" placeholder="นามสกุล" name="surname"required>
                <label>ลิงค์ Facebook</label>
                <input type="text" class="form-control" placeholder="ลิงค์ Facebook" name="facebook_link" required>
                <label>Line ID</label>
                <input type="text" class="form-control" placeholder="Line ID" name="line_id" required>
                <label>เบอร์ติดต่อ</label>
                <input type="text" class="form-control" placeholder="เบอร์ติดต่อ" name="phone" required>
                <label>จังหวัด</label>
                <input type="text" class="form-control" placeholder="จังหวัด" name="province" required>
                <label for="sel1">เลือกผู้ใช้งาน</label>
                <select class="form-control" id="sel1" name="member_genre">
                  <option value="member">ผู้ใช้งานทั่วไป</option>
                  <option value="band">วงดนตรี</option>
                </select>
              </div>

              <div class="col-lg-6" style="float: left;">
                
                <label>อีเมล</label>
                <input type="email" class="form-control" placeholder="อีเมล" name="email" required>
                <label>ชื่อผู้ใช้</label>
                <input type="text" class="form-control" placeholder="ชื่อผู้ใช้" name="username" required>
                <label>รหัสผ่าน</label>
                <input type="password" class="form-control" placeholder="รหัสผ่าน" name="password"required>
                <label>ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control" placeholder="ยืนยันรหัสผ่าน" name="passwordconfirm" required> 
                <button class="btn btn-danger btn-block btn-round" name="submit" value="submit">ยืนยัน</button>
              </div>
            </form>
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
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
  <script src="assets/js/plugins/moment.min.js"></script>
  <script src="assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
  <!-- Control Center for Paper Kit: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-kit.js?v=2.2.0" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
</body>

</html>
