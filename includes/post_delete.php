<div>

    <div>
        <?php
        $image = ROOT."images/female.jpg";
        $image_class = new Image();
        if ($ROW_USER['gender'] == "Male") {
            $image = ROOT."images/man.jpg";
        } 
       if ($user_data['profile_image']) {
         $image = ROOT."uploads/" . $user_data['userId'] . '/' . $user_data['profile_image'];
        }
        ?>
    </div>
    <div>
        <img src="<?php echo $image ?>" style="width:50px;float:left;margin-right:4px;border-radius:50px;">
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
    <br><br>
</div>