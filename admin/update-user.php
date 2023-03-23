<?php include "header.php";
if($_SESSION['role'] == 0){header("Location: /inews/admin/post.php");}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                <?php
                $user_id = $_GET['id'];
                    include 'config.php';
                    $getuser = "SELECT * FROM user WHERE user_id = '{$user_id}'";
                    $res = mysqli_query($conn,$getuser);
                    if(mysqli_num_rows($res)<=0){
                        echo "Invalid User ID";
                    }else{
                    $user = mysqli_fetch_assoc($res);
                ?>
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" value="<?php echo $user['fname']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" value="<?php echo $user['lname']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $user['username']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role">
                          <?php 
                          if($user['role'] == 1){
                            echo '<option value="0">normal User</option>
                            <option value="1" selected>Admin</option>';
                          }else{
                            echo '<option value="0" selected>normal User</option>
                            <option value="1">Admin</option>';
                          } ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                  <?php
                    
                    if(isset($_POST['submit'])){
                        $update = "UPDATE user SET fname = '{$_POST['fname']}',lname = '{$_POST['lname']}',username = '{$_POST['username']}',role = '{$_POST['role']}' WHERE user_id = '{$user_id}'";
                        $res = mysqli_query($conn,$update);
                        if($res){
                            echo "<script>
                            alert('{$user['username']} is updated');
                            location.href='users.php';
                            </script>";
                        }else{    
                            echo "<p style='color:red;text-align:center'>Error Occured!</p>";
                        }
                    }
                }
                mysqli_close($conn);
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
 