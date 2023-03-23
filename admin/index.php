<?php
if(isset($_SESSION['username'])){header("Location: /inews/admin/post");}
?>
<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Login</h3>
                        <?php
                        if(isset($_POST['login'])){
                            $username = $_POST['username'];
                            $pass = md5($_POST['password']);
                            include 'config.php';
                            $check = "SELECT username,user_id,password,role FROM user WHERE username = '{$_POST['username']}'";
                            $res= $conn->query($check);
                            if($res->num_rows < 1){
                                echo "<p class='text-danger text-center'><strong>{$_POST['username']}</strong> is not found! - <a href='add-user.php'>Register Now</a>";
                            }else{
                            $user = $res->fetch_assoc();
                                if($username === $user['username'] && $pass === $user['password']){
                                    session_start();
                                    $_SESSION['username'] = $user['username'];
                                    $_SESSION['user_id'] = $user['user_id'];
                                    $_SESSION['role'] = $user['role'];
                                    echo "<p class='text-success text-center'><strong>Login Successful!</strong> Redirecting to the Admin panel...";
                                    echo "<script>
                                    setTimeout(function(){location.href = '/inews/admin/post.php';},2000);
                                    </script>";
                                    // header("Location: /inews/admin/users.php");
                                }else{
                                    echo "<p class='text-danger text-center'>Incorrect <strong>username</strong> or <strong>password</strong>";
                                }
                        }
                        $conn->close();
                        }
                        ?>
                        <!-- Form Start -->
                        <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="Login" />
                            <a href="add-user.php" class="btn btn-success"> New user? Register here</a>
                        </form>
                        <!-- /Form  End -->
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
