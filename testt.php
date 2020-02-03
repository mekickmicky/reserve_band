<?php


    require 'src/condb.php';

    $conn->query("DELETE FROM band_like");
    $conn->query("UPDATE band SET `like` = 0");
?>