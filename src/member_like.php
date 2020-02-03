<?php
	require 'condb.php';
	$band_id = $_GET['band_id'];
	$member_id = $_GET['member_id'];
	$result = $conn->query("SELECT `member_id` FROM `band_like` WHERE band_id = '$band_id'");
	$count = mysqli_num_rows($result);

	$storeArray = Array();
	while ($row = $result->fetch_assoc()) {
		array_push($storeArray,$row['member_id']);
	}
	$check = in_array($member_id, $storeArray);
	if(!$check){
		$conn->query("INSERT INTO `band_like`(`band_id`, `member_id`) VALUES ('$band_id','$member_id')");
		$result = $conn->query("SELECT band_id FROM band_like WHERE band_id = '$band_id'");
		$count = mysqli_num_rows($result);
		$conn->query("UPDATE `band` SET `like`='$count' WHERE member_id = '$band_id'");
	}

	echo !$check;
?>
