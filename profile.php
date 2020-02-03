<?php
  require 'src/condb.php';


  if(!isset($_SESSION["username"]) && !isset($_SESSION["id"])){
    header('Location: login.php');
    return;
  }
  if(isset($_GET['member_id']) && $_GET['member_id'] != $_SESSION['id'])
    $member_id = $_GET['member_id'];
  else{
    $localProfile = true;
    $member_id = $_SESSION['id'];
  }

  $sql ="SELECT * FROM `member` WHERE id = '$member_id'";
  $result = $conn->query($sql);
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $username = $row['username'];
      $password = $row['password'];
      $name = $row['name'];
      $surname = $row['surname'];
      $member_genre = $row['member_genre'];
      $image_avatar = $row['image_avatar'];
      $image_cover_link = $row['image_cover_link'];

      $email = $row['email'];
      $facebook_link = $row['facebook_link'];
      $line_id = $row['line_id'];
      $phone = $row['phone'];
      $province = $row['province'];
    }

    if($member_genre == "band"){
        $sql ="SELECT * FROM `band` WHERE member_id = '$member_id'";
        $result = $conn->query($sql);
        if ($result) {
          if(isset($localProfile) && mysqli_num_rows($result)==0)
            header( "location: register_band.php");
          while ($row = $result->fetch_assoc()) {
            $band_name = $row['name'];
            $detail = $row['detail'];
            $price = $row['price'];
            $bank_name = $row['bank_name'];
            $bank_number = $row['bank_number'];
            $bank_branches = $row['bank_branches'];
            $like = $row['like'];
          }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    Profile
  </title>
  <?php require 'import-link.php'; ?>
</head>

<body class="profile-page sidebar-collapse">

<?php 
  require 'nav-bar.php'; 
?>

    <form style="display: none;" action="src/update_image_profile.php" method="post" enctype="multipart/form-data">
        <input id="UpdateCover" onchange="document.getElementById('UpdateCoverSub').click();" type="file" name="fileImageUp" id="fileToUpload">
        <input type="" name="nameimageOld" value="<?=$image_cover_link?>">
        <input id="UpdateCoverSub" type="submit" name="imagecover">
    </form>

    <form style="display: none;" action="src/update_image_profile.php" method="post" enctype="multipart/form-data">
        <input id="UpdateAvatar" onchange="document.getElementById('UpdateAvatarSub').click();" type="file" name="fileImageUp" id="fileToUpload">
        <input type="" name="nameimageOld" value="<?=$image_avatar?>">
        <input id="UpdateAvatarSub" type="submit" name="imageavatar">
    </form>

    <!-- header cover -->
  <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('images/cover/<?=$image_cover_link?>');" <?php if(isset($localProfile)){ ?>onclick="document.getElementById('UpdateCover').click();"<?php } ?>>
    <div class="filter"></div>
  </div>

  <div class="section profile-content">
    <div class="container">
      <div class="owner">
        <div class="avatar" <?php if(isset($localProfile)){ ?>onclick="document.getElementById('UpdateAvatar').click();"<?php } ?>>
          <img src="images/avatar/<?=$image_avatar?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">

        </div>
        <div class="name">
          <h4 class="title"><?php echo $name." ".$surname; ?>
          </h4>
          <?php if($member_genre == "band"){ ?>
            <a style="color: #fff;" onclick="OnClickLike('<?=$member_id?>','<?=$_SESSION['id']?>')" type="button" class="btn btn-info btn-round">
              <i class="fa fa-heart"></i>
              <span class="like<?=$member_id?>">
                <?php 
                  $result = $conn->query("SELECT band_id FROM band_like where band_id = '$member_id'");
                  echo mysqli_num_rows($result);
                 ?>
              </span>
            </a>
            <br><br>
          <!-- STYLE -->
          <label class="description">STYLE : </label>
          <?php 
          $result = $conn->query("SELECT name FROM `style_band` INNER JOIN `style` ON style_band.style_id = style.id WHERE style_band.band_id = '$member_id'");
          if ($result) {
            while ($row = $result->fetch_assoc()) { ?>
          <span class="label label-info"><?=$row['name']?></span> 
          <?php }} ?>
          <br>
          <!-- FESTIVAL -->
          <label class="description">FESTIVAL : </label>
          <?php 
          $result = $conn->query("SELECT name FROM `festival_genre_band` INNER JOIN `festival_genre` ON festival_genre_band.festival_genre_id = festival_genre.id WHERE festival_genre_band.band_id = '$member_id'");
          if ($result) {
            while ($row = $result->fetch_assoc()) { ?>
          <span class="label label-default"><?=$row['name']?></span> 
          <?php }}} ?>


        </div>
      </div>
      <div class="row">
        <div class="col-md-6 ml-auto mr-auto text-center">
          <p><?php if(isset($detail))echo $detail; ?></p>
          <br />

          <?php if(isset($localProfile)){ ?>
          <button type="button" class="btn btn-outline-default btn-round" data-toggle="modal" data-target="#model-setting"><i class="fa fa-cog"></i> ตั้งค่า </button>
          <?php }if($member_genre == "band" && !isset($localProfile)){ ?>
          <button type="button" class="btn btn-outline-danger btn-round" data-toggle="modal" data-target="#model-reserve"> จอง </button>
          <?php }if($member_genre == "band"){ ?>
          <button type="button" class="btn btn-outline-danger btn-round" data-toggle="modal" data-target="#model-schedule" onclick="ViewSchedule(<?=$member_id?>)"> ตารางงาน </button>
          <?php } ?>
            <br/>
            <br/>
             <?php if(isset($localProfile)){?>
            <form action="src/post.php" method="post" enctype="multipart/form-data">
                  <?php
                    if($_SESSION['member_genre'] == "member"){
                  ?>
                <div class="form-group">
                  <div class="input-group date" id="datetimepicker">
                    <input type="text" class="form-control datetimepicker" placeholder="เลือกวันเวลา" name="date_time" required="">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="number" class="form-control" placeholder="จำนวนชั่วโมง" name="hour" required="" min="1">
                </div>

                <div class="form-group">
                  <select class="form-control" name="festival_genre_id" required="">
                    <option value="">ประเภทงาน</option>
                  <?php
                    $sql = "SELECT * FROM `festival_genre`";
                    $result = $conn -> query($sql);
                    if ($result) {
                      while ($row = $result->fetch_assoc()) {
                  ?>
                    <option value="<?=$row['id']?>"><?=$row['name']?></option>
                  <?php }} ?>
                  </select>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="place" required="" placeholder="สถานที่"></textarea>
                </div>
                <input type="hidden" name="member_post" value="0">
                <?php } ?>

                  <div class="form-group">
                    <textarea class="form-control form-control-success" id="inputSuccess1" placeholder="เขียนโพสต์" name="content" required=""></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                  <div class="form-group">
                    <input type="file" name="fileImagePost" id="fileToUpload" required="">
                  </div>
                    </div>
                    <div class="col-md-6">
                  <div class="form-group" style="float: right;">
                    <button type="submit" class="btn btn-outline-danger btn-round"> โพสต์ </button>
                  </div>
                    </div>
                  </div>
            </form>
          <?php } ?>
        </div>
      </div>
      <br/>
      <!-- post -->
      <div class="row">
        <div class="card-columns">
        <?php
        $sql = "SELECT *,post.id FROM post
        INNER JOIN reserve ON post.reserve_id = reserve.id
         where post.member_id = '$member_id' ORDER BY post.id DESC";
        $result = $conn->query($sql);
        if($result){
          while ($row = $result->fetch_assoc()) {
        ?>

          <div class="card">
            <?php
            if(isset($localProfile)){
            ?>
            <a href="src/delete_post.php?post_id=<?=$row['id']?>" >
            <div style="position: absolute;right: 10px;top: 10px;color: #FFF;z-index: 20;font-size: 35px;width: 20px;height: 20px;border-radius: 10px;background: #f5593d;line-height: 0.55;"><span aria-hidden="true">×</span></div></a>
            <?php } ?>
            <img class="card-img-top" src="images/post/<?=$row['image_link']?>" alt="Card image cap">
            <div class="card-body">
              <!-- <h5 class="card-title">Card title that wraps to a new line</h5> -->
              <p id="post<?=$row['id']?>" class="card-text">
              <?php 
              $string = strip_tags($row['content']);
              if (strlen($string) > 150) {

                  // truncate string
                  $stringCut = substr($string, 0, 150);
                  $endPoint = strrpos($stringCut, ' ');

                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              }
              echo $string . "... ";
               ?>
               </p>
               <?php if($_SESSION['member_genre'] == "member"){
                ?>
               <button class="float-right btn btn-outline-danger btn-sm btn-modal-offer" value="<?=$row['reserve_id']?>" data-toggle="modal" data-target="#model-offer">ข้อความ</button>
               <?php } ?>
               <br>
            </div>
          </div>
        <?php 
          }
        }
        ?>
        </div>
      </div>
    </div>
  <?php require 'footer.php'; ?>
  </div>

  <!-- Modal จอง -->
  <div class="modal fade" id="model-reserve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h5 class="modal-title text-center" id="exampleModalLabel">จอง</h5>
        </div>
        <form method="post" action="src/reserve.php">
          <div class="modal-body">
              <div class="form-group">
                <div class="input-group date" id="datetimepicker">
                  <input type="text" class="form-control datetimepicker" placeholder="เลือกวันเวลา" name="date" required="">
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>จำนวนชั่วโมง</label>
                <input type="number" class="form-control" value="1" name="hour" required="">
              </div>

              <select class="form-control" name="festival_genre_id" required="">
                <option value="">ประเภทงาน</option>
              <?php
                $sql = "SELECT * FROM `festival_genre`";
                $result = $conn -> query($sql);
                if ($result) {
                  while ($row = $result->fetch_assoc()) {
              ?>
                <option value="<?=$row['id']?>"><?=$row['name']?></option>
              <?php }} ?>
              </select>
              <div class="form-group">
                <label>สถานที่</label>
                <textarea class="form-control" name="place" required=""></textarea>
              </div>
              <input type="hidden" name="member_band_id" value="<?=$member_id?>">
          </div>
          <div class="modal-footer">
            <div class="left-side">
              <button type="button" class="btn btn-default btn-link" data-dismiss="modal">ยกเลิก</button>
            </div>
            <div class="divider"></div>
            <div class="right-side">
              <button type="submit" name="send" value="member_reserve" class="btn btn-danger btn-link">ส่งข้อความจอง</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- edit model -->
  <div class="modal fade" id="model-setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 950px">
      <div class="modal-content">
          <div class="modal-body" style="padding: 10px;">


        <form method="post" action="src/member_edit.php">
          <div class="modal-body">
              <!-- edit member -->
              <div class="row">
                <div class="col-md-6">
                  <input type="hidden" value="<?=$_SESSION['id']?>" name="member_id" required="">
                  <div class="form-group">
                    <label>ชื่อ</label>
                    <input type="text" class="form-control" value="<?=$name?>" name="name" required="">
                  </div>
                  <div class="form-group">
                    <label>นามสกุล</label>
                    <input type="text" class="form-control" value="<?=$surname?>" name="surname" required="">
                  </div>
                  <div class="form-group">
                    <label>อีเมล</label>
                    <input type="email" class="form-control" value="<?=$email?>" name="email" required="">
                  </div>
                  <div class="form-group">
                    <label>Facebook ลิงค์</label>
                    <input type="text" class="form-control" value="<?=$facebook_link?>" name="facebook_link" required="">
                  </div>
                  <div class="form-group">
                    <label>Line ID</label>
                    <input type="text" class="form-control" value="<?=$line_id?>" name="line_id" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>เบอร์โทร</label>
                    <input type="text" class="form-control" value="<?=$phone?>" name="phone" required="">
                  </div>
                  <div class="form-group">
                    <label>จังหวัด</label>
                    <input type="text" class="form-control" value="<?=$province?>" name="province" required="">
                  </div>
                  <hr>
                  <div class="form-group">
                    <label>รหัสผ่าน</label>
                    <input type="password" class="form-control" value="<?=$password?>" name="password" required="">
                  </div>
                  <div class="form-group">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input type="password" class="form-control" value="<?=$password?>" name="passwordConfirm" required="">
                  </div>
                </div>
              </div>
              <?php if($member_genre == "band"){ ?>
              <hr>
                <!-- edit band -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>ชื่อวง</label>
                    <input type="text" class="form-control" value="<?=$band_name?>" name="band_name" required="">
                  </div>
                  <div class="form-group">
                    <label>ราคาค่าตัว</label>
                    <input type="number" class="form-control" value="<?=$price?>" name="price" required="">
                  </div>
                  <div class="form-group">
                    <label>ชื่อบัญชี</label>
                    <input type="text" class="form-control" value="<?=$bank_name?>" name="bank_name" required="">
                  </div>
                  <div class="form-group">
                    <label>เลขบัญชี</label>
                    <input type="text" class="form-control" value="<?=$bank_number?>" name="bank_number" required="">
                  </div>
                  <div class="form-group">
                    <label>สาขาธนาคาร</label>
                    <input type="text" class="form-control" value="<?=$bank_branches?>" name="bank_branches" required="">
                  </div>
                </div>

                <!-- tag -->
                <div class="col-md-6">
                      <div class="form-group">
                        <label>รายละเอียดวง</label>
                        <textarea class="form-control" name="detail" required=""><?=$detail?></textarea>
                      </div>
                  <div class="row">
                      
                  <div class="col-md-6">
                    <div class="title">
                      <h3>สไตล์</h3>
                    </div>
                    <?php
                    $style = array();
                    $result = $conn -> query("SELECT style_id FROM style_band where band_id = '$member_id'");
                    while ($row = $result -> fetch_assoc()) {
                      array_push($style,$row['style_id']);
                    }

                    $result = $conn -> query("SELECT * FROM style");
                    while ($row = $result -> fetch_assoc()) {
                    ?>
                    <div class="form-check">
                      <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" value="<?=$row['id']?>" name="style_id[]"
                      <?php 
                        if(in_array($row['id'],$style)){ echo "checked";} 
                      ?>
                      > <?=$row['name']?>
                      <span class="form-check-sign"></span>
                      </label>
                    </div>
                    <?php
                      }
                    ?>
                  </div>
                  <div class="col-md-6">
                    <div class="title">
                      <h3>ประเภทงาน</h3>
                    </div>
                    <?php

                    $festival_genre = array();
                    $result = $conn -> query("SELECT festival_genre_id FROM festival_genre_band where band_id = '$member_id'");
                    while ($row = $result -> fetch_assoc()) {
                      array_push($festival_genre , $row['festival_genre_id']);
                    }

                    $result = $conn -> query("SELECT * FROM festival_genre");
                    while ($row = $result -> fetch_assoc()) {
                      ?>
                    <div class="form-check">
                      <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" value="<?=$row['id']?>" name="festival_genre_id[]" 
                      <?php 
                        if(in_array($row['id'],$festival_genre)){ echo "checked";} 
                      ?>
                      > <?=$row['name']?>
                      <span class="form-check-sign"></span>
                      </label>
                    </div>
                    <?php
                      }
                    ?>
                  </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="modal-footer">
              <div class="left-side">
                <button type="button" class="btn btn-default btn-link" data-dismiss="modal">ยกเลิก</button>
              </div>
              <div class="divider"></div>
              <div class="right-side">
                <button type="submit" class="btn btn-danger btn-link">ยืนยัน</button>
              </div>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>

  <!-- ราคาเสนอจาก band -->
  <div class="modal fade" id="model-offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 950px">
      <div class="modal-content">
          <div class="modal-body" style="padding: 10px;">
            <div id="list-offer" class="list-group" style="overflow-x: auto;max-height: 330px;">
              
            </div>
          </div>
      </div>
    </div>
  </div>

</body>


   
</html>

<?php 
  }
  require 'import-script.php';

?>

<script type="text/javascript">
  $(document).ready(function() {

  $('.btn-modal-offer').click(function(){
      var v = $(this).val();
      var ajaxurl = 'src/getoffer.php',
      data =  {'id': v};
      $.post(ajaxurl, data, function (response) {
        $('#list-offer').html(response);
      });
  });
});
</script>