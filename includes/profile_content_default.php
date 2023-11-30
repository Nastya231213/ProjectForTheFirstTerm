<div style="display:flex;">
    <!--friends area-->
    <div style="min-height:400px;flex:1">
        <div id="friends_bar">
            <div id="friend_name" style="font-size:20px; margin-top:0px;"> Friends<br></div>
            <?php
                  $user_class = new User();

            $friends=$user_class-> get_following($user_data['userId'],"user");
            if ($friends) {

                foreach ($friends as $friend) {
                    $FRIEDNS_ROW = $user_class->get_data($friend["user_id"]);
                    include("includes\show_friend.php");
                }
            }
            ?>
        </div>


    </div>
    <div style="min-height:400px;flex:2.5;padding:20px;">
        <div id="write_post_bar">
            <form method="post" enctype="multipart/form-data">
                <textarea name="post" placeholder="What is on your mind?" rows="3"></textarea>
                <input type="file" id="file_profile_image_" name="file"  class="file">
                    <label class="file-selector-button" for="file_profile_image_">Select file <i class="fas fa-file-alt"></i></i></label>

                <input id="post_button" type="submit" value="Post">
            </form>

            <br>
        </div>
        <!--posts-->
        <div id="post_bar">


            <?php

            
            if ($posts) {
                foreach ($posts as $ROW) {
                    $user = new User();
                    $ROW_USER = $user->get_data($ROW["user_id"]);
                    include("post.php");
                }
            }
            $pg=pagination_link($user_data['userId']);
            ?>
            <a href="<?php echo $pg['next_page'] ?>">
                <input id="post_button" type="button" value="Next Page" style="float:right; width:150px; margin-right:0px;">
            </a>
            <a href="<?php echo $pg['prev_page'] ?>">
                <input id="post_button" type="button" value="Prev Page" style="float:left; width:150px;">
            </a>
          <br>
          <br>
          
        </div>
    </div>
</div>
</div>