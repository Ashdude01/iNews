<?php include "header.php";
if (!isset($_SESSION['username'])) {
    header("Location: /inews/admin");
}
include "config.php";
$id = $_GET['id'];
if (!$id) {
    echo "<script>
            alert('Invalid ID');
            location.href='post.php';
            </script>";
} else {
    $res = $conn->query("SELECT * FROM post WHERE post_id=$id");
    $post = $res->fetch_assoc();
}if($_SESSION['role'] == 0) {
    $checkuser = "SELECT role FROM user WHERE username = '{$post['author']}'";
    $resql = $conn->query($checkuser);
    $admin = $resql->fetch_assoc();
    if($admin['role'] == 1){
        echo "<script>
        alert('You are not allowed to Edit this Post');
        location.href='post.php';
        </script>";    
    }
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form for show edit-->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <label for="exampleInputTile">Title</label>
                        <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $post['title'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" required rows="5"><?php echo $post['description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCategory">Category</label>
                        <select class="form-control" name="category">
                            <?php echo "<option value='{$post['category']}' selected>{$post['category']}</option>";
                            $cat_gory = "SELECT category_name FROM category WHERE 1";
                            $res = $conn->query($cat_gory);
                            while ($cat_name = $res->fetch_assoc()) {
                                echo "<option value='{$cat_name['category_name']}'>{$cat_name['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Post image</label>
                        <input type="file" name="thumb">
                        <img src="../images/<?php echo $post['post_img'] ?>" height="150px">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                </form>
                <!-- Form End -->
                <?php
                include 'config.php';
                if (isset($_POST['submit'])) {
                        if (empty($_FILES['thumb']['name'])) {
                            $thumb_name = $post['post_img'];
                        } else {
                            
                            // echo $_FILES['thumb']['name '];
                            // die();
                            $errors = [];
                            $thumb_name = $_FILES['thumb']['name'];
                            $thumb_size = $_FILES['thumb']['size'];
                            $thumb_type = $_FILES['thumb']['type'];
                            $thumb_temp = $_FILES['thumb']['tmp_name'];
                            $thumb_ext = explode('.', $thumb_name);
                            $ext = strtolower(end($thumb_ext));
                            $extension = ['jpg', 'jpeg', 'png'];
                            if (in_array($ext, $extension) === false) {
                                $errors[] = "only 'jpg','jpeg','png' images are accepted!";
                            }
                            if ($thumb_size = 0 or $thumb_size > 2097152) {
                                $errors[] = "Image should be 2mb or lower!";
                            }
                            if (empty($errors) == true) {
                                $file_target = "../images/".time()."-".$thumb_name;
                                move_uploaded_file($thumb_temp, $file_target);
                            } else {
                                print_r($errors);
                                die();
                            }
                        
                    }
                    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
                    $desc = htmlentities($_POST['postdesc']);
                    $desc_escaped = mysqli_real_escape_string($conn, $desc);
                    $category = mysqli_real_escape_string($conn, $_POST['category']);
                    $date = date("d M, Y");
                    unlink("upload/{$post['post_img']}");
                    $update = "UPDATE post SET title='$title',description='$desc_escaped',category='$category',post_date='$date',author='{$_SESSION['username']}',post_img='{$thumb_name}' WHERE post_id=$id;";
                    if($post['category'] != $_POST['category']){
                        $sql.= "UPDATE category SET post = post-1 WHERE category_name = '{$post['category']}';";
                        $sql.= "UPDATE category SET post = post+1 WHERE category_name = '{$_POST['category']}'";
                    }
                    if ($conn->multi_query($update) === TRUE) {
                        echo "<script>
                            alert('Post is updated successfully!');
                            location.href= '/inews/admin/post.php';
                            </script>";
                    } else {
                        echo "<script>
                            alert('Error Occured! - $conn->error');
                            </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>