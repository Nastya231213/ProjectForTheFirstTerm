<div style="background:#e0dede ;margin-bottom:10px;">

    <div>
        <?php
        $image = "images/female.jpg";
        if ($ROW_USER['gender'] == "Male") {
            $image = "images/man.jpg";
        }
        if ($ROW_USER['profile_image']) {
            $image = "uploads/" . $ROW_USER['userId'] . '/' . $ROW_USER['profile_image'];
        }
        ?>
    </div>
    <div>
        <img src="<?php echo ROOT.$image ?>" style="width:50px;float:left;margin-right:4px;border-radius:50px;">
    </div>
    <div style="font-weight:bold;color:#405d9b"><?php echo $ROW_USER['first_name'] ?></div>
    <?php echo htmlspecialchars($COMMENT['post']) ?>

    <br><br>
    <div align="center">
        <?php
        if (file_exists($COMMENT['image']) && $COMMENT['image']) {
            $post_image = $image_class->get_thumb_cover($COMMENT['image']);

            echo "<img src='$post_image' style='width:90%;';>";
        }
        ?>
    </div>
    <div style="margin-left:29px;">
        <br>
        <?php
        $likes = "";
        $likes = ($COMMENT['likes'] > 0) ? '(' . $COMMENT['likes'] . ')' : "";
        ?>

        <a href="pages/like_page.php?id=<?php echo $COMMENT['post_id'] ?>&type=post">Like <?php echo $likes ?></a>


        . <a href="single_post.php?id=<?php echo $COMMENT['post_id'] ?>">Comment</a> .<span style="color:#999;"> <?php echo $COMMENT['date']; ?>

        </span><span style="float:right;margin-right:10px;">
            <?php
            $post_class = new Post();
            if ($post_class->i_own_post($COMMENT['post_id'], $COMMENT['user_id'])) {
                echo "<a href='edit.php?id=$COMMENT[post_id]'>Edit</a> 
                <a href='".ROOT."delete/".$COMMENT['post_id']."'>Delete</a> </span>";
            }
            if (isset($_SESSION['userId'])) {

                $DB = new Database();
                $sql = "select likes from likes where type='post' and content_id='$COMMENT[post_id]' limit 1";
                $i_liked = false;
                $result = $DB->read($sql);
                if (is_array($result) && isset($result[0])) {
                    $likes = json_decode($result[0]['likes'], true);
                    $user_ids = array_column($likes, "user_id");
                    if (in_array($_SESSION['userId'], $user_ids)) {
                        $i_liked = true;
                    }
                }
                if ($COMMENT['likes'] > 0) {
                    echo "<br/>";
                    echo "<a href='show_likes.php?type=post&id=$COMMENT[post_id]'>";
                    if ($COMMENT['likes'] > 1) {
                        if ($i_liked) {

                            echo "<span style='float:left;color:gray;margin-top:5px;'> You and " . ($COMMENT['likes'] - 1) . " people liked this post </span>";
                        } else {
                            echo "<span style='float:left;color:gray;margin-top:5px;'> " . $COMMENT['likes'] . " people liked this post </span>";
                        }
                    } else {
                        if ($i_liked) {
                            echo "<span style='float:left;color:gray;margin-top:5px;'> You liked this post </span>";
                        } else {
                            echo "<span style='float:left;color:gray;margin-top:5px;'> 1 person liked this post </span>";
                        }
                    }

                    echo "</a><br><br>";
                }
            }


            ?>
           
    </div>

</div>
<br>