<?php include "header.php";
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                if (isset($_POST['save'])) {
                    include 'config.php';
                    $check = "SELECT * FROM category WHERE category_name = '{$_POST['cat']}'";
                    $res_check = mysqli_query($conn, $check);
                    if (mysqli_num_rows($res_check) > 0) {
                        echo "<p class='text-warning text-center'><strong>{$_POST['cat']}</strong> is already exists!";
                    } else {
                        $insert = "INSERT INTO category SET category_name = '{$_POST['cat']}'";
                        $res = mysqli_query($conn, $insert);
                    if (!$res) {
                        echo "<p class='text-danger'><strong>Error Occured!</strong>";
                    } else {
                        echo "<p class='text-success text-center'><strong>{$_POST['cat']}</strong> is added to the database.";
                    }
                }}
                ?>
                <!-- Form Start -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>