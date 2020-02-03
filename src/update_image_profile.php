<?php

require 'condb.php';

$genre = "";
if(isset($_POST['imageavatar'])){
    $genre = "avatar";
}
else if(isset($_POST['imagecover'])){
    $genre = "cover";
}

$nameimageOld = $_POST['nameimageOld'];

$fileName = basename($_FILES["fileImageUp"]["name"]);

$target_dir = "../images/".$genre."/";
$target_file_current = $target_dir . $fileName;
$imageFileType = strtolower(pathinfo($target_file_current,PATHINFO_EXTENSION));

$newname = time().$_SESSION['id'].".".$imageFileType;

$target_file = $target_dir.$newname;

$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileImageUp"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file_current)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileImageUp"]["size"] > 5000000) {
    echo "<script>alert('ไฟลรูปขนาดเกิน 5mb')</script>";
    header('Refresh: 0; ../profile.php');
    return;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk != 0) {
    if (move_uploaded_file($_FILES["fileImageUp"]["tmp_name"], $target_file)) {
        
        //echo "The file ". basename( $_FILES["fileImageUp"]["name"]). " has been uploaded.";
        
        if($genre == "avatar"){
            $sql = "UPDATE member SET image_avatar = '$newname' Where id = '".$_SESSION['id']."'";
        }else if($genre == "cover"){
            $sql = "UPDATE member SET image_cover_link = '$newname' Where id = '".$_SESSION['id']."'";
        }

        $result = $conn -> query($sql);

        if($result){
            if($nameimageOld != "default-img-profile.png" && $nameimageOld != ""){

                $flgDelete = unlink("../images/".$genre."/".$nameimageOld);
            }
        }else{
         
            echo "<script>alert('อัพโหลดรูปไม่สำเร็จ โปรดลองอีกครั้ง')</script>";   
        }
    }
}



header('Refresh: 0; ../profile.php');
    $conn->close();
?>