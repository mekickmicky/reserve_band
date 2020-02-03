<?php
	require 'condb.php';

	$post_id = $_GET['post_id'];

	$result = $conn -> query("SELECT image_link,reserve_id FROM post Where id = '$post_id'");
	while ($row = $result -> fetch_assoc()) {
		if($row['image_link'] != "null")
    		unlink("../images/post/". $row['image_link']);
    	if(isset($row['reserve_id'])){
    		$id = $row['reserve_id'];
    		$conn -> query("DELETE FROM reserve Where id = '$id'");
    		$conn -> query("DELETE FROM offer_prices Where reserve_id ='$id'");
    	}
	}
	
	$result = $conn -> query("DELETE FROM post Where id = '$post_id'");
	header('Refresh: 0; ../profile.php?member_id='.$_SESSION['id']);

	$conn->close();
?>