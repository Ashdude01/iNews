<?php include "header.php";
if($_SESSION['role'] == 0){header("Location: /inews/admin/post.php");}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <?php
            include 'config.php';
            $recordsperpage = 5;
            $offset = ($page - 1) * $recordsperpage;
            $getuser = "SELECT * FROM user ORDER BY user_id DESC LIMIT $offset, $recordsperpage";
            $res = mysqli_query($conn, $getuser) or die("failed to get users");
            if (mysqli_num_rows($res) <= 0) {
                echo 'No Records Found!';
            } else {
            ?>
            <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <th>Id</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($users = mysqli_fetch_assoc($res)) { ?>
                                <tr>
                                    <td class='id'><?php echo $users['user_id'] ?></td>
                                    <td><?php echo $users['fname'] . " " . $users['lname'] ?></td>
                                    <td><?php echo $users['username'] ?></td>
                                    <td><?php
                                        if ($users['role'] == 1) {
                                            echo "Admin";
                                        } else {
                                            echo "Normal";
                                        }
                                        ?></td>
                                    <td class='edit'><a href="update-user.php?id=<?php echo $users['user_id'] ?>"><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a onclick="delete_user(<?php echo $users['user_id'] ?>,'<?php echo $users['username'] ?>','<?php echo $_SERVER['REQUEST_URI']?>')"><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php }

            $allusers = "SELECT * FROM user";
            $res = mysqli_query($conn, $allusers);
            if (mysqli_num_rows($res) > 0) {
                $totaluser = mysqli_num_rows($res);
                $recordsneeded = 5;
                $totalpage = ceil($totaluser / $recordsneeded);
                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo "<li><a href='users.php?page=" . ($page - 1) . "'>Prev</a></li>";
                }
                for ($i = 1; $i <= $totalpage; $i++) {
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    echo "<li class='$active'><a href='users.php?page=$i'>$i</a></li>";
                }
                if ($totalpage > $page) {
                    echo "<li><a href='users.php?page=" . ($page + 1) . "'>Next</a></li>";
                }
            }
            mysqli_close($conn); ?>
                </ul>
                </div>
        </div>
    </div>
</div>
<script>
    function delete_user(id, name, uri) {
        let alertmsg = confirm(`Do you want to Delete ${name}`);
        if(alertmsg) location.href = `delete-user.php?id=${id}&uri=${uri}`
    }
</script>