<?php
session_start();
if($_SESSION['role'] == 0){header("Location: /inews/admin/post.php");}

$id = $_GET['id'];
$uri = $_GET['uri'];
include 'config.php';
$delete = "DELETE FROM user WHERE user_id = '$id'";
$res = mysqli_query($conn,$delete);
if($res){
    header("Location: $uri");
}else{echo "Error Occured!";}
mysqli_close($conn);
?>