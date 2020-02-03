<?php
	$band_id = $_GET['id'];
	$result = $conn->query("SELECT * FROM band_like where band_id = '$band_id'");
	echo mysqli_num_rows($result);
?>
