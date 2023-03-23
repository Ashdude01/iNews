<?php
session_start();
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}

$id = $_GET['id'];
include 'config.php';
$delete = "DELETE FROM category WHERE category_id = '$id'";
if($conn->query($delete)=== TRUE){
    header("Location: /inews/admin/category.php");
}else{echo "Error Occured!";}
mysqli_close($conn);
?>