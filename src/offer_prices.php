<?php
	require 'condb.php';

	$reserve_id = $_POST['reserve_id'];
	$pledge = $_POST['pledge'];
	$price = $_POST['price'];
	$band_id = $_SESSION['id'];

	$result = $conn->query("INSERT INTO `offer_prices`(`reserve_id`, `band_id`, `pledge`, `price`) VALUES ('$reserve_id','$band_id','$pledge','$price')");

	if($result)
	echo "<script>alert('ส่งข้อความเรียบร้อย')</script>";
	
	header('Refresh: 0; ../index.php');
?>