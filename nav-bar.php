 <?php 
    if(isset($_SESSION['member_genre'])){
      if($_SESSION['member_genre'] == "member"){
        $sql = "SELECT *,reserve.id FROM `reserve` 
          INNER JOIN member ON reserve.member_id = member.id
          WHERE reserve.status = 'waitmemberpurchase' and reserve.member_id = '".$_SESSION['id']."'";
        $result_waitmember = $conn -> query($sql);
      }
      if($_SESSION['member_genre'] == "band"){
        $sql = "SELECT
        *,reserve.id
        FROM `reserve` INNER JOIN member ON reserve.member_id = member.id
          WHERE reserve.status = 'waitbandsendprice'and reserve.member_band_id = '".$_SESSION['id']."'
           or reserve.status = 'waitbandconfirm' and reserve.member_band_id = '".$_SESSION['id']."'";
        $result_waitband = $conn -> query($sql);
      }
    } 
   ?>

  <nav class="navbar navbar-expand-lg fixed-top navbar-transparent " color-on-scroll="300">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="index.php" rel="tooltip" title="Coded by Creative Tim" data-placement="bottom">
          JONG
        </a>
        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">

          <li class="nav-item">
           
            <input class="form-control" aria-label="Search" type="text" id="myInput" onkeyup="FilterNameSearch()" placeholder="ค้นหาชื่อวงดนตรี" title="ชื่อวงดนตรี" style="margin-top: 15px;">

            <div id="search_box" style="position: absolute;background: #fff;display: none;z-index: 999;">

              <?php
                $result = $conn->query("SELECT * FROM member Where member_genre = 'band' ORDER BY id DESC LIMIT 3");
                if($result){
                  while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    ?>

                <div class="listsearch list-group" style="max-height: 60px;padding: 5px;width: 300px;border-bottom: 1px solid #999;">
                    <div class="pull-left image">
                        <a href="profile.php?member_id=<?=$id?>" style="color: #000;">
                          <img src="images/avatar/<?=$row['image_avatar']?>" class="img-circle avatar" alt="user profile image" style="width: 50px;height: 50px;">
                          <b class="h5 searchname"><?=$row['name']." ".$row['surname']?></b>
                        </a>
                      </div>
                    </div>
                  <?php }} ?>
            </div>
          </li>
          
          <!-- <li class="nav-item">
            <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="https://twitter.com/CreativeTim" target="_blank">
              <i class="fa fa-twitter"></i>
              <p class="d-lg-none">Twitter</p>
            </a>
          -->


        <?php 
            if(!isset($_SESSION["username"]) && !isset($_SESSION["id"])){
          ?>
          <li class="nav-item">
            <a href="login.php" class="btn btn-danger btn-round">เข้าสู่ระบบ</a>
          </li>
          <?php }else if(isset($_SESSION["member_genre"])){ 
            if($_SESSION["member_genre"] == "member"){
              ?>
              <li class="nav-item"><a href="#" class="nav-link">โพสต์</a></li>
              <li class="nav-item"><a href="#" class="nav-link" data-toggle="modal" data-target="#model-notificate-member">จอง 
                <?php $count=mysqli_num_rows($result_waitmember); if($count>0){ ?>
                <span class="label label-danger"><?php echo $count; } ?></span></a></li>
              <li class="nav-item"><a href="#" class="nav-link">วงดนตรี</a></li>
              <?php
            }elseif($_SESSION["member_genre"] == "band"){
              ?>
              <li class="nav-item"><a href="#" class="nav-link" data-toggle="modal" data-target="#model-schedule" >ตารางงาน</a></li>
              <!-- onclick="ViewSchedule(<?=$_SESSION['id']?>)" -->
              <li class="nav-item"><a href="#" class="nav-link" data-toggle="modal" data-target="#model-notificate-band">การจอง 
                <?php $count=mysqli_num_rows($result_waitband); if($count>0){ ?>
                <span class="label label-danger"><?php echo $count; } ?></span></a></li>
              <li class="nav-item"><a href="#" class="nav-link">โพสต์</a></li>
              <?php
            }elseif($_SESSION["member_genre"] == "admin") {
              ?>
              <li class="nav-item"><a href="typems.php">ประเภทแนวเพลง</a></li>
              <li class="nav-item"><a href="typeword.php">ประเภทงาน</a></li>
              <li class="nav-item"><a href="seeuser.php">ข้อมูลผู้ใช้งาน</a></li>
              <li class="nav-item"><a href="seeband.php">ข้อมูลวงดนตรี</a></li>
              <li class="nav-item"><a href="#">การจอง/ว่าจ้าง</a></li>

              <?php
            }
          ?> <!-- Login แล้ว -->

          <li class="nav-item">
            <a href="profile.php"  class="btn btn-danger btn-round"><i class="nc-icon nc-circle-10"></i> <?=$_SESSION['name']?></a>
          </li>

            <li class="nav-item"><a href="src/logout.php" class="nav-link">ออกจากระบบ</a></li>
          <?php } 
          ?>

        </ul>
      </div>
    </div>
  </nav>



    <!-- schedule -->
    <div class="modal fade" id="model-schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 950px">
        <div class="modal-content">
            <div id="body-schedule" class="modal-body" style="padding: 10px;">
              <iframe id="frame-schedule" src="schedule.php?id=<?=$_SESSION['id']?>" style="width: 100%;min-height: 615px;"></iframe>

            </div>
        </div>
      </div>
    </div>

  <!-- notificate reserve for member -->
  <?php if(isset($_SESSION['member_genre'])&& $_SESSION['member_genre'] == "member"){
   ?>
    <div class="modal fade" id="model-notificate-member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 950px">
        <div class="modal-content">
            <div class="modal-body" style="padding: 10px;">
              <div class="list-group" style="overflow-x: auto;max-height: 330px;">
                <?php 
                 if(mysqli_num_rows($result_waitmember)>0){ 
                  while ($row = $result_waitmember->fetch_assoc()) { 
                    if($row['status'] == "waitmemberpurchase"){
                ?>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">คุณ<?=$row['name']." ".$row['surname']?></h5>
                  <small class="text-muted"><?=date("jS F, Y", strtotime($row['timestamp']));?></small>
                </div>
                <form action="src/reserve.php" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-3">
                    วันที่ : <?php 
                      $datetime = new DateTime($row['date_time']);
                      $date = $datetime->format('Y-m-d');
                      echo date("jS F, Y", strtotime($date))."<br>";
                      echo $datetime->format('H:i')."น. <br>";
                      echo "จำนวน ".$row['hour']." ชม.";
                    ?>
                  </div>
                  <div class="col-md-3">
                    สถานที่ : <?=$row['place']?>
                  </div>
                  <div class="col-md-2">
                    <?php 
                      echo "ราคามัดจำ :<br> ".$row['pledge']." บาท<br>";
                      echo "ราคาเต็ม :<br>".$row['price']." บาท<br>";
                    ?>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>อัพโหลดสลิป : </label>
                      <input type="file" name="fileImageBill" id="fileToUpload" required="" style="width: 100px;height: 60px;">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input type="hidden" name="reserve_id" value="<?=$row['id']?>">
                    <input type="hidden" name="nameimageOld" value="<?=$row['image_slip']?>">
                    <button type="submit" value="member_slip" name="send" class="btn btn-info btn-round" style="margin-top: 30px;">ยืนยัน</button>
                  </div>
                </div>
                </form>
              </a>
               <?php } }}
               else{
                ?><a href="#" class="list-group-item list-group-item-action flex-column">ไม่มีรายการ</a><?php
               }
               ?>
              </div>
            </div>
        </div>
      </div>
    </div>
    <?php } ?>

    <!-- notificate reserve for band -->
  <?php if(isset($_SESSION['member_genre'])&& $_SESSION['member_genre'] == "band"){
   ?>
    <div class="modal fade" id="model-notificate-band" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 950px">
        <div class="modal-content">
            <div class="modal-body" style="padding: 10px;">
              <div class="list-group" style="overflow-x: auto;max-height: 330px;">
                <?php
                if(mysqli_num_rows($result_waitband)>0){ 
                 while ($row = $result_waitband->fetch_assoc()) {
                    if($row['status'] == "waitbandsendprice"){ ?>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">คุณ<?=$row['name']." ".$row['surname']?></h5>
                  <small class="text-muted"><?=date("jS F, Y", strtotime($row['timestamp']));?></small>
                </div>
                
                <form method="post" action="src/reserve.php">
                <div class="row">
                  <div class="col-md-3">
                    วันที่ : <?php 
                      $datetime = new DateTime($row['date_time']);
                      $date = $datetime->format('Y-m-d');
                      echo date("jS F, Y", strtotime($date))."<br>";
                      echo $datetime->format('H:i')."น. <br>";
                      echo "จำนวน ".$row['hour']." ชม.";
                    ?>
                  </div>
                  <div class="col-md-3">
                    สถานที่ : <?=$row['place']?>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>ราคา</label>
                      <input type="number" class="form-control" name="price" min="1" step="any" required="">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>มัดจำ</label>
                      <input type="number" class="form-control" name="pledge" min="1" step="any" required="">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input type="hidden" name="reserve_id" value="<?=$row['id']?>">
                    <button type="submit" value="band_sendprice" name="send" class="btn btn-info btn-round" style="margin-top: 30px;">ยืนยัน</button>
                  </div>
                </div>
                </form>
              </a>
               <?php } 
                if($row['status'] == "waitbandconfirm"){ ?>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">คุณ<?=$row['name']." ".$row['surname']?></h5>
                  <small class="text-muted"><?=date("jS F, Y", strtotime($row['timestamp']));?></small>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    วันที่ : <?php 
                      $datetime = new DateTime($row['date_time']);
                      $date = $datetime->format('Y-m-d');
                      echo date("jS F, Y", strtotime($date))."<br>";
                      echo $datetime->format('H:i')."น. <br>";
                      echo "จำนวน ".$row['hour']." ชม.";
                    ?>
                  </div>
                  <div class="col-md-3">
                    สถานที่ : <?=$row['place']?>
                  </div>
                  <div class="col-md-2">
                    <?php
                      echo "ค่ามัดจำ ".$row['pledge']." บาท <br>";
                      echo "ราคาเต็ม ".$row['price']." บาท ";
                    ?>
                  </div>
                  <div class="col-md-2">
                      <img onclick="ViewSlip()" id="pop-viewimage" src="images/slip/<?=$row['image_slip']?>" style="width: 100px; height: 100px;">
                  </div>
                  <div class="col-md-2">
                    <form method="post" action="src/reserve.php">
                        <input type="hidden" name="reserve_id" value="<?=$row['id']?>">
                        <button type="submit" value="band_confirm" name="send" class="btn btn-info btn-round" style="margin-top: 30px;">ยืนยัน</button>
                    </form>
                  </div>
                </div>
              </div>
               <?php } }}
               else{
                ?><a href="#" class="list-group-item list-group-item-action flex-column">ไม่มีรายการ</a><?php
               }
               ?>
              </div>
            </div>
        </div>
      </div>
    </div>
    <?php } ?>


    <!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <img src="" id="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>
<script>
  function ViewSlip() {
    $('#imagepreview').attr('src', $("#pop-viewimage").attr('src')); // here asign the image to the modal when the user click the enlarge link
    $('#imagemodal').modal('show');
  }
  function ViewSchedule(id) {
  $('#frame-schedule').remove();
  $('#body-schedule').append('<iframe id="frame-schedule" src="schedule.php?id='+id+'" style="width: 100%;min-height: 615px;"></iframe>'); 
}


function FilterNameSearch() {

  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  table = document.getElementById("search_box");
  if(input.value == ""){
    table.style.display = "none";
  }else{
    table.style.display = "block";
  }
  filter = input.value.toUpperCase();
  tr = table.getElementsByClassName("listsearch");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByClassName("searchname")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>