<?php
session_start();
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}
session_unset();
session_destroy();
echo "<script>
alert('You have been logged out')
location.href = '/inews';
</script>";
// header("Location: /inews/admin");

?>
