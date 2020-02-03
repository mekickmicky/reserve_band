<?php require 'src/condb.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    Band Reserve
  </title>
  <?php require 'import-link.php'; ?>
</head>

<body class="index-page sidebar-collapse">

  <?php 
  require 'nav-bar.php'; 
  require 'header.php'; 
  ?>

  <!-- new band -->
  <div class="section section-dark text-center">
    <div class="container">
      <h2 class="title">New Musician</h2>
      <div class="row">
      <?php
      $result = $conn->query("SELECT * FROM member 
        INNER JOIN band ON member.id = band.member_id
        Where member_genre = 'band' ORDER BY id DESC LIMIT 4");
      if($result){
        while ($row = $result->fetch_assoc()) {
          $id = $row['id'];
          ?>
          <div class="col-md-3">
            <div class="card card-profile card-plain" style="color: #fff">
              <div class="card-avatar" style="background: #fff;">
                <a href="profile.php?member_id=<?=$row['id']?>">
                  <img src="images/avatar/<?=$row['image_avatar']?>">
                </a>
              </div>
              <div class="card-body">
                <a href="profile.php?member_id=<?=$row['id']?>">
                  <div class="author">
                    <h4 class="card-title"><?=$row['name']." ".$row['name']?></h4>
                    <h6 class="card-category">Musician</h6>
                  </div>
                </a>
              </div>
              <div class="card-footer text-center">
                <a style="color: #fff;" onclick="OnClickLike('<?=$id?>','<?=$_SESSION['id']?>')" type="button" class="btn btn-info btn-round btn-checklog"><span class="like<?=$row['id']?>"><?=$row['like']?></span> <i class="fa fa-heart"></i></a>

                <a href="profile.php?member_id=<?=$id?>" class="btn btn-outline-info btn-round">Profile</a>
              </div>
            </div>
          </div>
        <?php }} ?>
      </div>
    </div>
  </div>
  <!-- band popular -->
  <div class="section text-center">
    <div class="container">
      <h2 class="title">Pop</h2>
      <div class="row">
      <?php
      $result = $conn->query("SELECT * FROM member
        INNER JOIN band ON member.id = band.member_id
        Where member.member_genre = 'band' ORDER BY band.like DESC LIMIT 4");
      if($result){
        while ($row = $result->fetch_assoc()) {
          $id = $row['id'];
          ?>
          <div class="col-md-3">
            <div class="card card-profile card-plain" style="color: #fff">
              <div class="card-avatar" style="background: #fff;">
                <a href="profile.php?member_id=<?=$row['id']?>">
                  <img src="images/avatar/<?=$row['image_avatar']?>">
                </a>
              </div>
              <div class="card-body">
                <a href="profile.php?member_id=<?=$row['id']?>">
                  <div class="author">
                    <h4 class="card-title"><?=$row['name']." ".$row['name']?></h4>
                  </div>
                </a>
              </div>
              <div class="card-footer text-center">
                <a style="color: #fff;" onclick="OnClickLike('<?=$id?>','<?=$_SESSION['id']?>')" type="button" class="btn btn-info btn-round btn-checklog"><span class="like<?=$row['id']?>"><?=$row['like']?></span> <i class="fa fa-heart"></i></a>

                <!-- <a onclick="OnClickLike('<?=$id?>','<?=$_SESSION['id']?>')" type="button" class="btn btn-info btn-just-icon"><span class="like<?=$row['id']?>"><?=$row['like']?></span> <i class="fa fa-heart"></i></a> -->
                <a href="profile.php?member_id=<?=$id?>" class="btn btn-outline-info btn-round">Profile</a>
              </div>
            </div>
          </div>
        <?php }} ?>
      </div>
    </div>
  </div>

  <!-- post -->
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="card-columns">
          <?php
          $sql = "SELECT *,member.id FROM post 
          INNER JOIN member ON post.member_id = member.id 
          INNER JOIN reserve ON post.reserve_id = reserve.id
          ORDER BY post.id DESC LIMIT 10";
          $result = $conn->query($sql);
          if($result){
            while ($row = $result->fetch_assoc()) {
              $id = $row['id'];
              ?>
              <div class="card">
                <div class="panel panel-white post panel-shadow">
                  <a href="profile.php?member_id=<?=$id?>"><img class="card-img-top" src="images/post/<?=$row['image_link']?>" alt=""></a>
                  <div class="post-heading">
                    <div class="pull-left image">
                      <a href="profile.php?member_id=<?=$id?>">
                        <img src="images/avatar/<?=$row['image_avatar']?>" class="img-circle avatar" alt="user profile image">
                      </a>
                    </div>
                    <div class="pull-left meta">
                      <div class="h5">
                        <a href="profile.php?member_id=<?=$id?>"><b><?=$row['name']." ".$row['surname']?></b></a>
                      </div>
                      <h6 class="text-muted time"><?=date("jS F, Y", strtotime($row['timestamp']));?></h6>
                    </div>
                  </div>
                  <div class="post-description"> 
                    <p><?=substr($row['content'], 0, 150)?></p>
                    <div class="float-right stats">
                      <?php if($row['member_genre'] == "band"){ 
                        $result_like = $conn->query("SELECT `like` FROM band WHERE member_id = '".$row['id']."'");
                        while ($row_like = $result_like->fetch_assoc()) {
                          ?>
                          <a style="color: #fff;" onclick="OnClickLike('<?=$id?>','<?=$_SESSION['id']?>')" type="button" class="btn btn-info btn-round btn-checklog"><span class="like<?=$id?>"><?=$row_like['like']?></span> <i class="fa fa-heart"></i></a>
                        <?php 
                        }
                      }else if($row['member_genre'] == "member" && isset($_SESSION['member_genre']) && $_SESSION['member_genre'] == "band" && $row['status'] != "confirm"){ ?>
                          <button type="button" class="float-right btn btn-outline-danger btn-checklog btn-modal-sendprice"  value="<?=$row['reserve_id']?>" data-toggle="modal" data-target="#model-sendprice">ส่งข้อความ</button>
                        <?php } ?>
                      </div><br><br><br>
                    </div>
                  </div>
                </div>
                <?php 
              }
            }
            ?>
          </div>
      </div>
    </div>
  </div>

  <!-- Modal send price -->
  <div class="modal fade" id="model-sendprice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h5 class="modal-title text-center" id="exampleModalLabel">เสนอราคา</h5>
        </div>
        <form method="post" action="src/offer_prices.php">
          <div class="modal-body">
            <div class="form-group">
              <label>ราคา</label>
              <input type="number" class="form-control" placeholder="ราคา" min="1" name="price" required="">
            </div>
            <div class="form-group">
              <label>ราคามัดจำ</label>
              <input type="number" class="form-control" placeholder="ราคามัดจำ" min="1" name="pledge" required="">
            </div>
            <input id="sendprice_reserve_id" type="hidden" name="reserve_id" value="">
        </div>
          <div class="modal-footer">
            <div class="left-side">
              <button type="button" class="btn btn-default btn-link" data-dismiss="modal">ยกเลิก</button>
            </div>
            <div class="divider"></div>
            <div class="right-side">
              <button type="submit" name="send" value="" class="btn btn-danger btn-link">ส่งข้อความ</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

    <?php require 'footer.php'; ?>
</body>

</html>
<?php 
require 'import-script.php';
?>

<script type="text/javascript">

$(document).ready(function() {
   $('.btn-modal-sendprice').click(function(){
        $('#sendprice_reserve_id').val($(this).val())
    });
});

</script>

<style type="text/css">

  .carousel-inner>.carousel-item>img, .carousel-inner>.carousel-item>a>img{
    border-radius: 0;
  }
  .panel-shadow {
    box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
  }
  .panel-white  .panel-heading {
    color: #333;
    background-color: #fff;
    border-color: #ddd;
  }
  .panel-white  .panel-footer {
    background-color: #fff;
    border-color: #ddd;
  }

  .post .post-heading {
    height: 95px;
    padding: 20px 15px;
  }
  .post .post-heading .avatar {
    width: 60px;
    height: 60px;
    display: block;
    margin-right: 15px;
  }
  .post .post-heading .meta .title {
    margin-bottom: 0;
  }
  .post .post-heading .meta .title a {
    color: black;
  }
  .post .post-heading .meta .title a:hover {
    color: #aaaaaa;
  }
  .post .post-heading .meta .time {
    margin-top: 8px;
    color: #999;
  }
  .post .post-image .image {
    width: 100%;
    height: auto;
  }
  .post .post-description {
    padding: 15px;
  }
  .post .post-description p {
    font-size: 14px;
  }
  .post .post-description .stats {
    margin-top: 20px;
  }
  .post .post-description .stats .stat-item {
    display: inline-block;
    margin-right: 15px;
  }
  .post .post-description .stats .stat-item .icon {
    margin-right: 8px;
  }
  .post .post-footer {
    border-top: 1px solid #ddd;
    padding: 15px;
  }
  .post .post-footer .input-group-addon a {
    color: #454545;
  }
  .post .post-footer .comments-list {
    padding: 0;
    margin-top: 20px;
    list-style-type: none;
  }
  .post .post-footer .comments-list .comment {
    display: block;
    width: 100%;
    margin: 20px 0;
  }
  .post .post-footer .comments-list .comment .avatar {
    width: 35px;
    height: 35px;
  }
  .post .post-footer .comments-list .comment .comment-heading {
    display: block;
    width: 100%;
  }
  .post .post-footer .comments-list .comment .comment-heading .user {
    font-size: 14px;
    font-weight: bold;
    display: inline;
    margin-top: 0;
    margin-right: 10px;
  }
  .post .post-footer .comments-list .comment .comment-heading .time {
    font-size: 12px;
    color: #aaa;
    margin-top: 0;
    display: inline;
  }
  .post .post-footer .comments-list .comment .comment-body {
    margin-left: 50px;
  }
  .post .post-footer .comments-list .comment > .comments-list {
    margin-left: 50px;
  }

  .card-profile .card-avatar{
    min-width: 120px;
    min-height: 120px;
  }
</style>