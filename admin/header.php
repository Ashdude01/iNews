<?php session_start(); 
if(str_contains($_SERVER['PHP_SELF'], 'post')){
    $post_active = 'li-active';
}else{$post_active = null;}
if(str_contains($_SERVER['PHP_SELF'], 'category')){
    $cat_active = 'li-active';
}else{$cat_active = null;}
if(str_contains($_SERVER['PHP_SELF'], 'user')){
    $user_active = 'li-active';
}else{$user_active = null;}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>ADMIN Panel</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <!-- Custom stlylesheet -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <!-- HEADER -->
        <div id="header-admin">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-2">
                        <a href="post.php"><img class="logo" src="../logo.png"></a>
                    </div>
                    <!-- /LOGO -->
                      <!-- LOGO-Out -->
                    <div class="col-md-offset-10">
                        <?php if(isset($_SESSION['username'])){
                            echo "<span>welcome</span>";
                            echo "<a style='margin:0 10px;color:white;font-style:bold;font-size:15px' href='post.php'>{$_SESSION['username']}</a>";
                            echo '<a href="logout.php" class="admin-logout"><i class="bi bi-box-arrow-right"></i></a>';
                        } else{
                            echo '<a href="/inews/admin" class="admin-logout">Login</a>';
                        }
                        
                        ?>
                    </div>
                    <!-- /LOGO-Out -->
                </div>
            </div>
        </div>
        <!-- /HEADER -->
        <!-- Menu Bar -->
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <ul class="admin-menu">
                            <li>
                                <a class="<?php echo $post_active ?>" href="post.php">Post</a>
                            </li>
                            <li>
                                <a class="<?php echo $cat_active ?>" href="category.php">Category</a>
                            </li>
                            <li>
                                <a class="<?php echo $user_active ?>" href="users.php">Users</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Menu Bar -->
