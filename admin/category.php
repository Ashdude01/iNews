<?php include "header.php";
if(!isset($_SESSION['username'])){header("Location: /inews/admin");}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">

                <?php
                include 'config.php';
                $res = mysqli_query($conn, "SELECT * FROM category ORDER BY category_id DESC");
                if (mysqli_num_rows($res) <= 0) {
                    echo  '<h1 class="admin-heading">No Records!</h1>
                </div>';
                } else {
                    echo '<h1 class="admin-heading">All Categories</h1>
                </div>';
                ?>
                    <div class="col-md-2">
                        <a class="add-new" href="add-category.php">add category</a>
                    </div>
                    <div class="col-md-12">

                        <table class="content-table">
                            <thead>
                                <th>S.No.</th>
                                <th>Category Name</th>
                                <th>No. of Posts</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php
                                while ($data = mysqli_fetch_assoc($res)) {
                                ?>
                                    <tr>
                                        <td class='id'><?php echo $data['category_id'] ?></td>
                                        <td><?php echo $data['category_name'] ?></td>
                                        <td><?php echo $data['post'] ?></td>
                                        <td class='edit'><a href='update-category.php?id=<?php echo $data['category_id'] ?>'><i class='fa fa-edit'></i></a></td>
                                        <td class='delete'><a onclick="delete_category(<?php echo $data['category_id'] ?>, '<?php echo $data['category_name'] ?>')"><i class='fa fa-trash-o'></i></a></td>
                                    </tr>
                            <?php }
                            }
                            mysqli_close($conn) ?>
                            </tbody>
                        </table>
                        <!-- <ul class='pagination admin-pagination'>
                    <li class="active"><a>1</a></li>
                    <li><a>2</a></li>
                    <li><a>3</a></li>
                </ul> -->
                    </div>
            </div>
        </div>
    </div>
    <script>
        function delete_category(id, name){
            let msg = confirm(`Do you want to delete ${name} ?`);
            if(msg) location.href = `delete-category.php?id=${id}`;
        }
        </script>
    <?php include "footer.php"; ?>