<?php 
require 'condb.php';
if(isset($_POST["username"])&& isset($_POST["password"])){

	$username = $_POST["username"];
	$password = $_POST["password"];

	$sql = "SELECT * from member WHERE username = '$username' AND password = '$password'";
	$result = $conn->query($sql);
	if ($result) {
		if(mysqli_num_rows($result)==0){
			echo "<script>alert('ไม่มีชื่อในระบบ')</script>";
			header('Refresh: 0; ');
			return;
		}

		$member_genre = "";
		while ($row = $result->fetch_assoc()) {

			$_SESSION["id"] = $row['id'];
			$_SESSION["email"] = $row['email'];
			$_SESSION["name"] = $row['name'];
			$_SESSION["member_genre"] = $row['member_genre'];
		}
		

		if($_SESSION["member_genre"] == "admin")
			header('Location: ../admin.php');
		else{

			echo "<script>alert('ยินดีตอนรับ')</script>";
			header('Refresh: 0; ../profile.php');

		}
	} else {
		$res['status'] = 500;
		$res['message'] = "Read data fail";
	}

	$conn->close();
}

?>