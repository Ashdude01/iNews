<?php
                    $id = $_GET['id'];
                    if (!$id) {
                        echo "<script>
                            alert('Invalid ID');
                            location.href='index.php';
                            </script>";
                    } else {
                        include 'config.php';
                        $getpost = "SELECT * FROM post WHERE post_id=$id";
                        $res = $conn->query($getpost);
                        if ($res->num_rows < 1) {
                            echo "<script>
                            alert('No Record Found!');
                            location.href='index.php';
                            </script>";
                        } else {
                            $post = $res->fetch_assoc();
                        }
                    }
                    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $post['title'] ?></title>
    <meta name="description" content="<?php echo substr($post['description'],0,140) ?> Category">
    <meta name="keywords" content="<?php echo $post['title']." , ".substr($post['description'],0,140) ?> ,">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <div class="post-content single-post">
                        <h3><?php echo $post['title'] ?></h3>
                        <div class="post-information">
                            <span>
                                <i class="fa fa-tags" aria-hidden="true"></i>
                                <?php echo $post['category'] ?>
                            </span>
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <?php echo "<a href='author.php?q={$post['author']}'>{$post['author']}</a>" ?>
                            </span>
                            <span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo $post['post_date'] ?>
                            </span>
                        </div>
                        <?php echo "<img class='single-feature-image' src='images/{$post['post_img']}' alt='{$post['title']}' />"?>
                        <p class="description">
                            <?php echo $post['description'] ?>
                        </p>
                    </div>
                </div>
                <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>