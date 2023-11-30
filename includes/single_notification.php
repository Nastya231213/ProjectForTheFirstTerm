<?php
$link = "";
if ($notific_row['content_type'] == "post") {
    $link = "single_post/" . $notific_row['content_id']."?notific=".$notific_row['id'];
} else if ($notific_row['content_type'] == "profile") {
    $link = "profile/". $notific_row['content_id'];
} else if ($notific_row['content_type'] == "comment") {
    $link = "single_post/" . $notific_row['content_id']."?notific";
}

$query ="select * from notification_seen where user_id='".$notific_row['content_owner']."' && notification_id='".$notific_row['id']."'";
$seen=$DB->read($query);
$color="#dfcccc";

if($seen){
    $color="#eee";

}
?>
<a href="<?php echo $link ?>">
    <div id="notific" style="background-color:<?=$color?>">
        <?php
        $actor = $User->get_data($notific_row['user_id']);
        $owner = $User->get_data($notific_row['content_owner']);

        if (is_array($actor) && is_array($owner)) {
            $image = "images/female.jpg";
            if ($actor['gender'] == "Male") {
                $image = "images/man.jpg";
            }
            if (file_exists($root."uploads/" . $actor['userId'] . '/' . $actor['profile_image']) && $actor['profile_image']) {
                $image = ROOT."uploads/" . $actor['userId'] . '/' . $actor['profile_image'];
            }
            echo "<img src='$image' class='photos_user_notification'/>";
            if ($owner['userId'] != $actor['userId']) {
                echo $actor['first_name'] . " " . $actor['last_name'];
            } else {
                echo "You ";
            }
            if ($notific_row['activity'] == 'like') {
                echo " liked";
            } else if ($notific_row['activity'] == 'follow') {
                echo " followed";
            }else if($notific_row['activity']=='comment'){
                echo " commented";
            }
            if ($owner['userId'] != $id) {
                echo $owner['first_name'] . " " . $owner['last_name'] . "'s";
            } else {
                echo " your ";
            }
            $content_row = $Post->get_one_posts($notific_row['content_id']);
             
            if ($notific_row['content_type'] == "1") {
                if ($content_row['has_image']) {
                    echo " image ";
                    $url = $content_row['image'];

                    if (file_exists($url)) {
                        echo "<img src='$url' style='width:40px;float:right;'/>";
                    }
                    echo "
                    <span style='float:right; font-size:11px;color:#888;display:inline-block;margin-right:20px'>" . htmlspecialchars($content_row['post']) . "</span>";
                } else {
                    echo $notific_row['content_type'];
                }
            } else {
                echo $notific_row['content_type'];
            }

            $date = date("jS M Y H:i:s", strtotime($notific_row['date']));
            echo "<br>
            
            <span class='date'>$date</span>
            ";
        }
        ?>
    </div>
</a>