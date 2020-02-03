<?php
	require 'condb.php';
	$reserve_id = $_POST['id'];

    $sql = "SELECT *,offer_prices.price FROM `offer_prices` 
    INNER JOIN band ON band.member_id = offer_prices.band_id
    where offer_prices.reserve_id = '$reserve_id'";
    $result_offer = $conn->query($sql);
   if(mysqli_num_rows($result_offer)>0){ 
    while ($row = $result_offer->fetch_assoc()) { 
	  ?>
		<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
		  <div class="d-flex w-100 justify-content-between">
		    <h5 class="mb-1">วง<?=$row['name']?></h5>
		    <small class="text-muted"><?=date("jS F, Y", strtotime($row['timestamp']));?></small>
		  </div>
		  <form action="src/reserve.php" method="post" enctype="multipart/form-data">
			  <div class="row">
			  	<div class="col-md-4">ราคามัดจำ : <?=$row['pledge']?></div>
			  	<div class="col-md-4">ราคาเต็ม : <?=$row['price']?></div>
			  	<div class="col-md-2">
			  		<div class="form-group">
	                  <label>อัพโหลดสลิป : </label>
	                  <input type="file" name="fileImageBill" id="fileToUpload" required="" style="width: 100px;height: 60px;">
	                </div>
			  	</div>
			  	<div class="col-md-2">
                    <input type="hidden" name="pledge" value="<?=$row['pledge']?>">
                    <input type="hidden" name="price" value="<?=$row['price']?>">
                    <input type="hidden" name="reserve_id" value="<?=$reserve_id?>">
                    <input type="hidden" name="member_band_id" value="<?=$row['band_id']?>">
			  		<button type="submit" name="send" value="member_slip" class="float-right btn btn-info">เลือก</button>
			  	</div>
			  </div>
		  </form>
		</a>
<?php } 
	} else{
	  ?><a href="#" class="list-group-item list-group-item-action flex-column">ไม่มีรายการ</a><?php
	 }
 ?>