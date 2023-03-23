<?php include "header.php";
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}
?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="desc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                            <?php include 'config.php';
                                $cat = "SELECT category_name FROM category WHERE 1";
                                $res = $conn->query($cat);
                                while($cat_name = $res->fetch_assoc()){
                                    echo "<option value='{$cat_name['category_name']}'>{$cat_name['category_name']}</option>";
                                }
                            ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="thumb" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
                  <?php
                    include 'config.php';
                    if(isset($_POST['submit'])){
                        $errors = [];
                        if(isset($_FILES['thumb'])){
                            $thumb_name = $_FILES['thumb']['name'];
                            $thumb_size = $_FILES['thumb']['size'];
                            $thumb_type = $_FILES['thumb']['type'];
                            $thumb_temp = $_FILES['thumb']['tmp_name'];
                            $thumb_ext = explode('.',$thumb_name);
                            $ext = strtolower(end($thumb_ext));
                            $extension = ['jpg','jpeg','png'];
                            if(in_array($ext,$extension) === false){
                                $errors[] = "only 'jpg','jpeg','png' images are accepted!";
                            }
                            if($thumb_size > 2097152){
                                $errors[] = "Image should be 2mb or lower!";
                            }
                            if(empty($errors) == true){
                                $file_target = "../images/".time()."-".$thumb_name;
                                move_uploaded_file($thumb_temp, $file_target);
                            }else{print_r($errors);die();}

                        }

                        $title = mysqli_real_escape_string($conn, $_POST['title']);
                        $desc = mysqli_real_escape_string($conn, $_POST['desc']);
                        $category = mysqli_real_escape_string($conn, $_POST['category']);
                        $date = date("d M, Y");
                        $author = $_SESSION['username'];

                        $sql = "INSERT INTO post(title,description,category,post_date,author,post_img)
                        VALUES('{$title}','{$desc}','{$category}','{$date}','{$author}','{$thumb_name}');";
                        $sql .= "UPDATE category SET post = post+1 Where category_name = '$category'";
                        $response = $conn->multi_query($sql);
                        if($response === true){
                            echo "<script>
                            alert('post added successfully');
                            location.href='post.php';
                            </script>";
                        }else{    
                            echo "<script>
                            alert('Error Occured!');
                            </script>";
                        }
                        

                    }

                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
