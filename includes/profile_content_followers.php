<div class="container">
    <div id="divider">
        <div style="text-align:center;width:40%;margin: 0 auto;">
            <?php

            $DB = new Database();



            $image_class = new Image();
            $post_class = new Post();
            $user_class = new User();
            $followers = $post_class->get_likes($user_data['userId'], "user");
            if (is_array($followers)) {
                foreach ($followers as $follower) {
                    $FRIEDNS_ROW = $user_class->get_data($follower['user_id']);

                    include("includes/show_friend.php");
                }
            } else {
                echo "No followers were found!";
            }

            ?>
        </div>
    </div>
</div>