
<?php

require 'condb.php';


$content = addslashes($_POST['content']);

$member_id = $_SESSION['id'];
$image_link = "null";

if(isset($_FILES["fileImagePost"]["name"])){

	$target_dir = "../images/post/";
	$image_link = basename($_FILES["fileImagePost"]["name"]);
	$target_file = $target_dir.$image_link;

	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$image_link = time().$member_id.".".$imageFileType;


	$uploadOk = 1;
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileImagePost"]["tmp_name"]);
		if($check !== false) {
			//echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			//echo "File is not an image.";
			$uploadOk = 0;
		}
	}
// Check if file already exists
	if (file_exists($target_file)) {
		//echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	$target_file = $target_dir.$image_link;
// Check file size
	if ($_FILES["fileImagePost"]["size"] > 5000000) {
    	echo "<script>alert('ไฟลรูปขนาดเกิน 5mb')</script>";
    	echo "<script>history.go(-1)</script>";
    	return;
	}
// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		//echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileImagePost"]["tmp_name"], $target_file)) {
			//echo "The file ". basename( $_FILES["fileImagePost"]["name"]). " has been uploaded.";
		} else {
			//echo "Sorry, there was an error uploading your file.";
		}
	}
	$sql = "INSERT INTO `post`(`image_link`, `content`, `member_id`) VALUES ('$image_link','$content','$member_id')";
	$conn -> query($sql);
	$last_post_id = mysqli_insert_id($conn);
	if(isset($_POST['member_post'])){
		$festival_genre_id = $_POST['festival_genre_id'];

		$date = new DateTime($_POST['date_time']);
		$date_time = $date->format('Y-m-d H:i:s');

		$hour = $_POST['hour'];
		$place = $_POST['place'];

		$sql = "INSERT INTO `reserve`(`festival_genre_id`, `date_time`, `hour`, `member_id`, `status`, `place`) VALUES ('$festival_genre_id','$date_time','$hour','$member_id','waitbandsendprire','$place')";
		$result = $conn->query($sql);
		$last_id = mysqli_insert_id($conn);
		$conn->query("UPDATE post SET reserve_id = '$last_id' WHERE id = '$last_post_id'");
	}
}

header('Refresh: 0; ../profile.php?member_id='.$member_id);


	$conn->close();
?>