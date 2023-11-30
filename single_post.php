<?php

include("../website/includes/autoload.php");
$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;

$Post = new Post();
$User = new User();
$ERROR = "";
$ROW = false;
$ROW_USER = "";
if (isset($URL[1])) {

    $ROW = $Post->get_one_posts($URL[1]);
    $ROW_USER = $User->get_data($ROW['user_id']);
} else {
    $ERROR = "No post was found!";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (isset($_POST['first_name'])) {
        $settings_class = new Settings();
        $settings_class->save_settings($_POST, $_SESSION['userId']);

    } else {
        $post = new Post();

        $single_item=$post->create_post($_POST, $_SESSION['userId'], $_FILES);
        if ($result == "") {
            $location=ROOT."single_post/".$URL[1];
            header("Location: $location");
            die;
        } else {

            echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "<br></div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT?>style/profile.css?version=15343121">
    <style>
        #profile_pic {
            margin-top: 0px;
        }
    </style>
</head>

<body>
    
    <?php
 
    include($root."includes/header.php") ?>

    <div style="display:flex;width:800px;min-height:400px;margin:auto">

        <div style="min-height:400px;flex:2.5;padding:20px;">
            <div id="write_post_bar" style="color:black;">
                <?php
                if(isset($_GET['notific'])){
                    notification_seen($_GET['notific']);
                }
                
                $user_class = new User();
                $image_class = new Image();
                if (is_array($ROW)) {
                    $ROW_USER=$user_class->get_data($ROW['user_id']);
                    $COMMENT=$ROW;
                    if($ROW['parent']!=0){
                        $COMMENT=$ROW;
                        include($root."includes/comments.php");
                    }else{
                        include("post.php");
                    }
                    
                }
                ?>
                <?php if($ROW['parent']==0):?>
                <br>
                <div id="write_post_bar">
                    <form method="post" enctype="multipart/form-data">
                        <textarea name="post" placeholder="What is on your mind?" rows="3"></textarea>
                        <input type="file" id="file_profile_image" name="file" class="file">
                    <label class="file-selector-button" for="file_profile_image">Select file <i class="fas fa-file-alt"></i></label>
                                            <input type="hidden" name="parent" value="<?php echo $ROW['post_id'] ?>" style="float:left;">

                        <input id="post_button" type="submit" value="Post">
                    </form>

                    <br>
                </div>
                <br><br>
                 
                <?php
                $comments = $Post->get_comments($ROW['post_id']);
                if (is_array($comments)) {
                    foreach ($comments as $COMMENT) {

                        $ROW_USER=$User->get_data($COMMENT['user_id']);
                        include($root."includes/comments.php");
                    }
                }
                $pg=pagination_link();
                ?><br><br>

                <a href="<?php echo $pg['next_page'] ?>">
                    <input id="post_button" type="button" value="Next Page" style="float:right; width:150px; margin-right:0px;">
                </a>
                <a href="<?php echo $pg['prev_page'] ?>">
                    <input id="post_button" type="button" value="Prev Page" style="float:left; width:150px;">
                </a>
                <br><br>
            </div>

            <?php else:?>
                <br>
                <a href="/website/single_post/<?php echo $ROW['parent']?>">
                <input id="post_button" style="width:auto;float:left;cursor:pointer" type="button" value="Back to main post">
                </a>
            </a>
            <?php endif;?>

            <br><br>

        </div>
    </div>
    </div>
</body>

</html>