<?php 

  require 'condb.php'; 
if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$detail = addslashes($_POST['detail']);
	$price = $_POST['price'];
	$bank_name = $_POST['bank_name'];
	$bank_number = $_POST['bank_number'];
	$bank_branches = $_POST['bank_branches'];
	$member_id = $_POST['member_id'];


	$sql = "INSERT INTO `band`(`name`, `detail`, `price`, `bank_name`, `bank_number`, `bank_branches`, `member_id`,`like`) VALUES ('$name','$detail','$price','$bank_name','$bank_number','$bank_branches','$member_id' , '0')";

	$result = $conn->query($sql);
	if ($result) {
		foreach ($_POST['style_id'] as $style_id) {
			$conn->query("INSERT INTO `style_band`(`band_id`, `style_id`) VALUES ('$member_id','$style_id')");
		}

		foreach ($_POST['festival_genre_id'] as $festival_genre_id) {
			$conn->query("INSERT INTO `festival_genre_band`(`band_id`, `festival_genre_id`) VALUES ('$member_id','$festival_genre_id')");
		}
		echo "<script>alert('เรียบร้อย')</script>";

	}
	header('Refresh: 0; ../index.php');
	$conn->close();

}
	

 ?>