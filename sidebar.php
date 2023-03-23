<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        
        <h4>Recent Posts</h4>
        <?php
        include 'config.php';
        $getrecentpost = "SELECT * FROM post ORDER BY post_id DESC LIMIT 5";
        $res_recent = $conn->query($getrecentpost);
        if ($res_recent->num_rows < 1) {
            echo 'No Records Found!';
        } else {
            while($recentpost = $res_recent->fetch_assoc()){
        ?>
        <div class="recent-post">
            <a class="post-img" href="">
                <img src="images/<?php echo $recentpost['post_img']?>" alt="<?php echo $recentpost['title']?>"/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?id=<?php echo $recentpost['post_id']?>"><?php echo $recentpost['title']?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php'><?php echo $recentpost['category']?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $recentpost['post_date']?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo $recentpost['post_id']?>">read more</a>
            </div>
        </div>
        <?php }}?>
    <!-- /recent posts box -->
</div>
