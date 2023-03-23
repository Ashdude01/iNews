<?php include "header.php";
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}
include "config.php";
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
              <h1 class="adin-heading"> Update Category</h1>
                  </div>
                <?php
                $id = $_GET['id'];
                if(!$id){
                  echo "<script>
                            alert('Invalid ID');
                            location.href='category.php';
                            </script>";
                }else{
                  $res = $conn->query("SELECT * FROM category WHERE category_id=$id");
                  $cat = $res->fetch_assoc();

                }
                  ?>
              <div class="col-md-offset-3 col-md-6">
                  <form action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $cat['category_name']?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php
                  include 'config.php';
                    if(isset($_POST['save'])){
                      $check = "SELECT category_name FROM category WHERE category_name='{$_POST['cat_name']}'";
                      $result = $conn->query($check);
                      if($result->num_rows > 0){
                        echo "<p class='text-warning text-center'><strong>{$_POST['cat_name']}</strong> is already exists.";
                      }else{
                        $update = "UPDATE category SET category_name = '{$_POST['cat_name']}' WHERE category_id=$id";
                        if($conn->query($update) === TRUE){
                          echo "<script>
                            alert('{$cat['category_name']} is updated!');
                            location.href='category.php';
                            </script>";
                        }else{
                          echo "<script>
                            alert('Error Occured!');
                            </script>";
                        }
                        
                      }
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
<?php 
include "footer.php";
?>
