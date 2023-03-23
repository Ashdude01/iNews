<?php
session_start();
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}

$id = $_GET['id'];
$cat = $_GET['cat'];
$uri = $_GET['uri'];
include 'config.php';
$del_img = "SELECT post_img FROM post WHERE post_id = $id";
$res = $conn->query($del_img);
$img = $res->fetch_assoc();
unlink("upload/{$img['post_img']}");

$delete = "DELETE FROM post WHERE post_id = '$id';";
$delete .= "UPDATE category SET post = post-1 Where category_name= '$cat'";

if($conn->multi_query($delete)=== TRUE){
    header("Location: /inews/admin/post.php");
}else{echo "Error Occured!";}
mysqli_close($conn);
?>