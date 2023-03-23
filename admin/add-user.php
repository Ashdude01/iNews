<?php include "header.php";
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add User</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                if (isset($_POST['save'])) {
                    include 'config.php';

                    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
                    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
                    $username = mysqli_real_escape_string($conn, $_POST['username']);
                    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
                    $role = mysqli_real_escape_string($conn, $_POST['role']);

                    $validateuser = "SELECT * FROM user WHERE username = '{$username}'";
                    $res = mysqli_query($conn, $validateuser);
                    if (mysqli_num_rows($res) > 0) {
                        echo "<p style='color:red;text-align:center;'><strong>$username</strong> already exists, Try a unique username</p>";
                    } else {
                        $adduser = "INSERT INTO user (fname,lname,username,password,role) VALUES ('{$fname}', '{$lname}', '{$username}', '{$password}', '{$role}')";
                        mysqli_query($conn, $adduser);
                        echo "<p style='color:green;text-align:center'><strong>$username</strong> is registered, you can now <a href='/inews/admin'>Log in</a></p>";
                    }
                }
                ?>
                <!-- Form Start -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role">
                            <option value="0">Normal User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Register" required />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>