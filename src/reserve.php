
<?php

require 'condb.php';

if($_POST['send'] == "member_reserve"){
	$date = new DateTime($_POST['date']);
	$date_time = $date->format('Y-m-d H:i:s');
	// $date = $datetime->format('Y-m-d');
	// $time = $datetime->format('H:i:s');

	$hour = $_POST['hour'];
	$festival_genre_id = $_POST['festival_genre_id'];
	$place = $_POST['place'];

	$member_id = $_SESSION['id'];
	$member_band_id = $_POST['member_band_id'];

	$sql = "INSERT INTO `reserve`(`festival_genre_id`, `date_time`, `hour`, `member_id`, `member_band_id`, `status`, `place`, `image_slip`) VALUES ('$festival_genre_id','$date_time','$hour','$member_id','$member_band_id','waitbandsendprice','$place','')";

	$result = $conn -> query($sql);
	if($result){
		echo "<script>alert('ส่งข้อความจอง')</script>";
	}
	header('Refresh: 0; ../profile.php?member_id='.$member_band_id);

}else if($_POST['send'] == "band_sendprice"){ // ส่งราคาให้ member
	$reserve_id = $_POST['reserve_id'];
	$price = $_POST['price'];
	$pledge = $_POST['pledge'];
	$sql = "UPDATE `reserve` SET `pledge`= '$pledge',`price`= '$price',`status`= 'waitmemberpurchase' WHERE id = '$reserve_id'";
	$result = $conn -> query($sql);
	if($result){
		echo "<script>alert('ส่งราคาให้ผู้ว่าจ้าง')</script>";
	}
	header('Refresh: 0; ../index.php');
}else if($_POST['send'] == "member_slip"){ // member ส่งสลิปให้ band

	$reserve_id = $_POST['reserve_id'];

	$fileName = basename($_FILES["fileImageBill"]["name"]);

	$target_dir = "../images/slip/";
	$target_file_current = $target_dir . $fileName;
	$imageFileType = strtolower(pathinfo($target_file_current,PATHINFO_EXTENSION));

	$newname = time().$_SESSION['id'].".".$imageFileType;
	$target_file = $target_dir.$newname;

	$uploadOk = 1;
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileImageBill"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	}
	if (file_exists($target_file_current)) {		
		$uploadOk = 0;
	}
	if ($_FILES["fileImageBill"]["size"] > 5000000) {
		echo "<script>alert('ไฟลรูปขนาดเกิน 5mb')</script>";
		echo "<script>history.go(-1)</script>";
		return;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		$uploadOk = 0;
	}
	if ($uploadOk != 0) {
		if (move_uploaded_file($_FILES["fileImageBill"]["tmp_name"], $target_file)) {
			$member_id = $_SESSION['id'];
			$up_band_id = "";
			if(isset($_POST['member_band_id']) 
				&& isset($_POST['price']) 
				&& isset($_POST['pledge']))
				$up_band_id = ",member_band_id = '".$_POST['member_band_id']."',price ='".$_POST['price']."',pledge='".$_POST['pledge']."'";

		$sql = "UPDATE reserve SET status = 'waitbandconfirm' ,image_slip = '$newname'".$up_band_id." Where id = '$reserve_id'";
		$result = $conn -> query($sql);

		if($result){
			if(isset($_POST['nameimageOld']) && $_POST['nameimageOld'] != ""){
				$flgDelete = unlink("../images/slip/".$_POST['nameimageOld']);
			}
		}else{
			echo "<script>alert('อัพโหลดรูปไม่สำเร็จ โปรดลองอีกครั้ง')</script>";   
		}
	}
}
	echo "<script>history.go(-1)</script>";
}else if($_POST['send'] == "band_confirm"){

	$reserve_id = $_POST['reserve_id'];

	$sql = "UPDATE reserve SET status = 'confirm' Where id = '$reserve_id'";
	$result = $conn -> query($sql);

	$sql = "SELECT * FROM `reserve`
			INNER JOIN member ON reserve.member_id = member.id WHERE reserve.id = '$reserve_id'";
	$result = $conn -> query($sql);
	if($result){
		while ($row = $result -> fetch_assoc()) {
			$name = $row['name'];
			$date_time = $row['date_time'];
			$hour = $row['hour'];
			$place = $row['place'];
			$price = $row['price'];
			$band_id = $_SESSION['id'];
		}
		$sql = "INSERT INTO `schedule`( `name`, `reserve_id`, `date_time`, `hour`, `place`, `band_id`, `price`) VALUES ('$name','$reserve_id','$date_time','$hour','$place','$band_id','$price')";
		$result = $conn -> query($sql);

		if($result){
			$conn -> query("DELETE FROM offer_prices WHERE reserve_id = '$reserve_id'");
			echo "<script>alert('ลงตารางงานเรียบร้อย')</script>";   
		}
	}

	echo "<script>history.go(-1)</script>";
}
$conn->close();
?>