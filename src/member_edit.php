<?php 
 require 'condb.php'; 
	
$member_id = $_POST['member_id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$facebook_link = $_POST['facebook_link'];
$line_id = $_POST['line_id'];
$phone = $_POST['phone'];
$province = $_POST['province'];
$password = $_POST['password'];

if($password != $_POST['passwordConfirm']){
	echo "<script>alert('รหัสผ่านไม่ตรงกัน')</script>";
	echo "<script>history.go(-1)</script>";
}

$sql = "UPDATE `member` SET `password`= '$password'  ,`name`= '$name'  ,`surname`= '$surname'  ,`email`= '$email'  ,`facebook_link`= '$facebook_link'  ,`line_id`= '$line_id'  ,`phone`= '$phone'  ,`province`= '$province' WHERE id = '$member_id'";

$result = $conn->query($sql);
if ($result) {
	if(isset($_POST['band_name'])){
		$name = $_POST['band_name'];
		$detail = $_POST['detail'];
		$price = $_POST['price'];
		$bank_name = $_POST['bank_name'];
		$bank_number = $_POST['bank_number'];
		$bank_branches = $_POST['bank_branches'];

		$sql = "UPDATE `band` SET `name`= '$name',`detail`= '$detail',`price`= '$price',`bank_name`= '$bank_name',`bank_number`= '$bank_number',`bank_branches`= '$bank_branches' WHERE member_id = '$member_id'";
		$result = $conn->query($sql);

		$result = $conn->query("DELETE FROM `style_band` WHERE band_id = '$member_id'");
		$result = $conn->query("DELETE FROM `festival_genre_band` WHERE band_id = '$member_id'");

		foreach ($_POST['style_id'] as $style_id) {
			$conn->query("INSERT INTO `style_band`(`band_id`, `style_id`) VALUES ('$member_id','$style_id')");
		}

		foreach ($_POST['festival_genre_id'] as $festival_genre_id) {
			$conn->query("INSERT INTO `festival_genre_band`(`band_id`, `festival_genre_id`) VALUES ('$member_id','$festival_genre_id')");
		}


		if ($result)
			echo "<script>alert('แก้ไขเรียบร้อย')</script>";
	}else
		echo "<script>alert('แก้ไขเรียบร้อย')</script>";
	
} else {
	echo "<script>history.go(-1)</script>";
}

header('Refresh: 0; ../profile.php');
$conn->close();
 ?>