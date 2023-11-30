<div id="friends">
    <?php

    $image ="images/man.jpg";
    if ($FRIEDNS_ROW['gender'] == "Female") {
        $image = "images/female.jpg";
    }
    if (file_exists("uploads/" . $FRIEDNS_ROW['userId'] . '/' . $FRIEDNS_ROW['profile_image']) && $FRIEDNS_ROW['profile_image']) {
        $image = "uploads/" . $FRIEDNS_ROW['userId'] . '/' . $FRIEDNS_ROW['profile_image'];
    }
    ?> 
    <a href="<?php echo ROOT."profile/".$FRIEDNS_ROW['userId']?>">
    <img id="friends_img" src="<?php echo ROOT.$image?>">
    <br>
    <div id="friend_name"><?php echo $FRIEDNS_ROW['first_name']." ".$FRIEDNS_ROW['last_name']; ?></div>
    </a>
</div>