<?php 
$query = $_GET['q'];
if (!$query or strlen($query) < 3) {
    echo "<script>
                alert(`Enter a Valid Search Query`);
                location.href='index.php';
                </script>";
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Search - <?php echo $query ?></title>
    <meta name="description" content="Get Latest News & Updates related to <?php echo $query ?> Category">
    <meta name="keywords" content="<?php echo $query ?> - latest news, top news, trending today news abc news alt news">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php';?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <h2 class="page-heading"><?php echo $query?></h2>
                  <?php
                        include 'config.php';
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {$page = 1;}
                        $recordsperpage = 2;
                        $offset = ($page - 1) * $recordsperpage;
                        $getpost = "SELECT * FROM post WHERE title LIKE '%{$query}%' OR description LIKE '%{$query}%' OR author LIKE '%{$query}%' OR category LIKE '%{$query}%' ORDER BY post_id DESC LIMIT $offset, $recordsperpage";
                        $res = $conn->query($getpost);
                        // print_r($res->fetch_assoc());
                        // die();
                        if ($res->num_rows < 1) {
                            echo 'No Records Found!';
                        } else {
                            while($post = $res->fetch_assoc()){
                        ?>
                    <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $post['post_id']?>"><img src="images/<?php echo $post['post_img']?>" alt="<?php echo $post['title']?>"/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $post['post_id']?>'><?php echo $post['title']?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <?php echo "<a href='category.php?q={$post['category']}'>{$post['category']}</a>"?>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <?php echo "<a href='author.php?q={$post['author']}'>{$post['author']}</a>"?>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $post['post_date']?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($post['description'],0,140)."..."?>
                                    </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $post['post_id']?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }}
                        $allpost = "SELECT * FROM post WHERE title LIKE '%{$query}%' OR description LIKE '%{$query}%' OR author LIKE '%{$query}%' OR category LIKE '%{$query}%'";
                        $res1 = mysqli_query($conn, $allpost); 
                        if (mysqli_num_rows($res1) > 0) {
                            $totalpost = mysqli_num_rows($res1);
                            $recordsneeded = 2;
                            $totalpage = ceil($totalpost / $recordsneeded);
                            echo "<ul class='pagination admin-pagination'>";
                            if ($page > 1) {
                                echo "<li><a href='?q=$query&page=" . ($page - 1) . "'>Prev</a></li>";
                            }
                            for ($i = 1; $i <= $totalpage; $i++) {
                                if ($i == $page) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                                echo "<li class='$active'><a href='?q=$query&page=$i'>$i</a></li>";
                            }
                            if ($totalpage > $page) {
                                echo "<li><a href='?q=$query&page=" . ($page + 1) . "'>Next</a></li>";
                            }
                        }
                        mysqli_close($conn); ?>
                        </ul>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; }?>
