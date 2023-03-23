<?php include "header.php";
if(!isset($_SESSION['username'])){header("Location: /inews/admin");} 
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <?php
            include 'config.php';
            // fetch post
            $recordsperpage = 10;
            $offset = ($page - 1) * $recordsperpage;
            $getpost = "SELECT * FROM post ORDER BY post_id DESC LIMIT $offset, $recordsperpage";
            $res = $conn->query($getpost);
            if ($res->num_rows < 1) {
                echo 'No Records Found!';
            } else {
            ?>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php  $serial = $offset + 1;
                        while($post = $res->fetch_assoc()){
                          echo "<tr>
                              <td class='id'>$serial</td>
                              <td>{$post['title']}</td>
                              <td>{$post['category']}</td>
                              <td>{$post['post_date']}</td>
                              <td>{$post['author']}</td>
                              <td class='edit'><a href='update-post.php?id={$post['post_id']}'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a onclick='delete_post({$post['post_id']},\"{$_SERVER['REQUEST_URI']}\",\"{$post['category']}\")'><i class='fa fa-trash-o'></i></a></td>
                          </tr>";
                          $serial++;
                          }?>
                      </tbody>
                  </table>
                  <?php
                  $allpost = "SELECT * FROM post";
                  $res1 = mysqli_query($conn, $allpost);
                  if (mysqli_num_rows($res1) > 0) {
                      $totalpost = mysqli_num_rows($res1);
                      $recordsneeded = 10;
                      $totalpage = ceil($totalpost / $recordsneeded);
                      echo "<ul class='pagination admin-pagination'>";
                      if ($page > 1) {
                          echo "<li><a href='post.php?page=" . ($page - 1) . "'>Prev</a></li>";
                      }
                      for ($i = 1; $i <= $totalpage; $i++) {
                          if ($i == $page) {
                              $active = "active";
                          } else {
                              $active = "";
                          }
                          echo "<li class='$active'><a href='post.php?page=$i'>$i</a></li>";
                      }
                      if ($totalpage > $page) {
                          echo "<li><a href='post.php?page=" . ($page + 1) . "'>Next</a></li>";
                      }
                  }
                  mysqli_close($conn); ?>
                  </ul>
              </div>
              <?php } ?>
          </div>
      </div>
  </div>
  <script>
    function delete_post(id,uri,cat){
        let msg = confirm(`Do you want to Delete this Article?`);
        if(msg){
            location.href = `delete-post.php?id=${id}&cat=${cat}&uri=${uri}`;
        }
    }
  </script>
<?php include "footer.php"; ?>
