<?php 
  require 'src/condb.php'; 
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <title>
    ลงทะเบียนวงดนตรี
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
            <h4 class="title mx-auto">ลงทะเบียนวงดนตรี</h4>
            <form class="register-form" method="post" action="src/band_register.php">
              <div class="col-lg-6" style="float: left;">
                
                <label>ชื่อวง</label>
                <input type="text" class="form-control" placeholder="ชื่อวง" name="name" required>
                <label>รายละเอียด</label>
                <textarea type="text" class="form-control" placeholder="รายละเอียด" name="detail"required></textarea>
                <label>ราคาค่าตัว</label>
                <input type="number" class="form-control" placeholder="ราคาค่าตัว" name="price" required>
                <label>ชื่อบัญชี</label>
                <input type="text" class="form-control" placeholder="ชื่อบัญชี" name="bank_name" required>
                <label>เลขบัญชี</label>
                <input type="text" class="form-control" placeholder="เลขบัญชี" name="bank_number" required>
                <label>สาขาธนาคาร</label>
                <input type="text" class="form-control" placeholder="สาขาธนาคาร" name="bank_branches" required>

                
                <input type="hidden" name="member_id" value="<?=$_SESSION['id']?>">
              </div>

              <div class="col-lg-6" style="float: left;">
                <div class="row">
                  <div class="col-md-6">
                      <div class="title">
                        <h5>สไตล์</h5>
                      </div>
                      <?php
                      $result = $conn -> query("SELECT * FROM style");
                      while ($row = $result -> fetch_assoc()) {
                        ?>
                      <div class="form-check">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="<?=$row['id']?>" name="style_id[]"> <?=$row['name']?>
                        <span class="form-check-sign"></span>
                        </label>
                      </div>
                      <?php
                        }
                      ?>
                    </div>
                    <div class="col-md-6">
                      <div class="title">
                        <h5>ประเภทงาน</h5>
                      </div>
                      <?php
                      $result = $conn -> query("SELECT * FROM festival_genre");
                      while ($row = $result -> fetch_assoc()) {
                        ?>
                      <div class="form-check">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="<?=$row['id']?>" name="festival_genre_id[]"> <?=$row['name']?>
                        <span class="form-check-sign"></span>
                        </label>
                      </div>
                      <?php
                        }
                      ?>
                    </div>
                </div>
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