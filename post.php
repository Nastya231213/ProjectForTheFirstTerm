<div>

    <div>
        <?php
        $image = "images/female.jpg";
        if ($ROW_USER['gender'] == "Male") {
            $image = "images/man.jpg";
        }
        if (file_exists($root."uploads/" . $ROW_USER['userId'] . '/' . $ROW_USER['profile_image']) && $ROW_USER['profile_image']) {
            $image = "uploads/" . $ROW_USER['userId'] . '/' . $ROW_USER['profile_image'];
        }
        ?>
    </div>
    <div>
        <img src="<?php echo ROOT.$image ?>" style="width:50px;float:left;margin-right:4px;border-radius:50px;">
    </div>
    <div style="font-weight:bold;color:#405d9b"><?php echo $ROW_USER['first_name'] ?></div>
    <?php echo htmlspecialchars($ROW['post']) ?>

    <br><br>
    <div align="center">
        <?php
        if (file_exists($ROW['image'])) {
            $post_image = $image_class->get_thumb_cover($ROW['image']);

            echo "<img src='".ROOT."$post_image' style='width:90%;';>";
        }
        ?>
    </div>
    <div style="margin-left:29px;">
        <br>
        <?php
        $likes = "";
        $likes = ($ROW['likes'] > 0) ? '(' . $ROW['likes'] . ')' : "";
        ?>

        <a href="/website/like_page.php?id=<?php echo $ROW['post_id'] ?>&type=post">Like <?php echo $likes ?></a>
        <?php
        $comments = "";
        if ($ROW['comments'] > 0) {
            $comments = "(" . $ROW['comments'] . ")";
        }
        ?>

        . <a href="<?php echo ROOT?>single_post/<?php echo $ROW['post_id'] ?>">Comment <?php echo $comments; ?></a> .<span style="color:#999;"> <?php echo $ROW['date']; ?>

        </span><span style="float:right;margin-right:10px;">
            <?php
            $post_class = new Post();
            if ($post_class->i_own_post($ROW['post_id'], $ROW['user_id'])) {
                echo "<a href='".ROOT."edit/$ROW[post_id]'>Edit</a> . 
                <a href='delete/$ROW[post_id]'>Delete</a> </span>";
            }
            if (isset($_SESSION['userId'])) {

                $DB = new Database();
                $sql = "select likes from likes where type='post' and content_id='$ROW[post_id]' limit 1";
                $i_liked = false;
                $result = $DB->read($sql);
                if (is_array($result) && isset($result[0])) {
                    $likes = json_decode($result[0]['likes'], true);
                    $user_ids = array_column($likes, "user_id");
                    if (in_array($_SESSION['userId'], $user_ids)) {
                        $i_liked = true;
                    }
                }
                if ($ROW['likes'] > 0) {
                    echo "<br/>";
                    echo "<a href='show_likes.php?type=post&id=$ROW[post_id]'>";
                    if ($ROW['likes'] > 1) {
                        if ($i_liked) {

                            echo "<span style='float:left;color:gray;margin-top:5px;'> You and " . ($ROW['likes'] - 1) . " people liked this post </span>";
                        } else {
                            echo "<span style='float:left;color:gray;margin-top:5px;'> " . $ROW['likes'] . " people liked this post </span>";
                        }
                    } else {
                        if ($i_liked) {
                            echo "<span style='float:left;color:gray;margin-top:5px;'> You liked this post </span>";
                        } else {
                            echo "<span style='float:left;color:gray;margin-top:5px;'> 1 person liked this post </span>";
                        }
                    }

                    echo "</a>";
                }
            }



            ?>

    </div>
    <br><br>
</div>