<?php 

  require 'condb.php'; 
if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$facebook_link = $_POST['facebook_link'];
	$line_id = $_POST['line_id'];
	$phone = $_POST['phone'];
	$province = $_POST['province'];
	$member_genre = $_POST['member_genre'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];



	$result = $conn->query("SELECT * from member WHERE username = '$username'");
	if(mysqli_num_rows($result)>0){
		echo "<script>alert('มี username นี้แล้ว')</script>";
		echo "<script>history.go(-1)</script>";
		return;
	}


	$sql = "INSERT INTO `member`(`username`, `password`,`image_avatar`, `name`, `surname`, `email`, `facebook_link`, `line_id`, `phone`, `province`, `member_genre`, `image_cover_link`) VALUES ('$username','$password','default-img-profile.png','$name','$surname','$email','$facebook_link','$line_id','$phone','$province','$member_genre','')";

	$result = $conn->query($sql);
	if ($result) {
		$sql = "SELECT * from member WHERE email = '$email' AND password = '$password' ";
		$result = $conn->query($sql);
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$_SESSION["id"] = $row['id'];
				$_SESSION["email"] = $row['email'];
				$_SESSION["name"] = $row['name'];
				$_SESSION["member_genre"] = $row['member_genre'];
			}
			echo "<script>alert('เข้าสู่ระบบเรียบร้อยแล้ว')</script>";

			if ($member_genre == "band") {
				header('Refresh: 0; ../register_band.php');
				return;
			}
			header('Refresh: 0; ../profile.php');
		}
	} else {
		$res['status'] = 500;
		$res['message'] = "Read data fail";
		echo "<script>history.go(-1)</script>";
	}

	$conn->close();

}
	

 ?>