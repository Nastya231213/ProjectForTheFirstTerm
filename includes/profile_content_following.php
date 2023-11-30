<div class="container">
    <div id="divider">
        <div style="text-align:center;width:40%;margin: 0 auto;">
        <?php

        $DB = new Database();



        $image_class = new Image();
        $post_class=new Post();
        $user_class=new User();
        $following=$user_class->get_following($_GET['id'],"user") ;
        if (is_array($following)) {
            foreach ($following as $follower) {
                $FRIEDNS_ROW=$user_class->get_data($follower['user_id']);
                
                include("includes/show_friend.php");
            }
        } else {
            echo "This user isn't following";
        }
       
        ?>
        </div>
    </div>
</div>