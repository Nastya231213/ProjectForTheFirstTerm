<?php
include("../website/includes/autoload.php");
$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;

//profile? that accessed

if (isset($URL[1])) {
    $profile = new Profile();

    $profile_data = $profile->get_profile($URL[1]);

    if (is_array($profile_data)) {
        $user_data = $profile_data[0];
    }
}

//for posting 
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if ($_POST['change'] == "profile" || $_POST['change'] == "cover") {
        include("../website/change_profile_image.php");
    } else {
        if (isset($_POST['first_name'])) {
            $settings_class = new Settings();
            $settings_class->save_settings($_POST, $_SESSION['userId']);
        } else {
            $post = new Post();

            $post->create_post($_POST, $_SESSION['userId'], $_FILES);
            if ($result == "") {
                header("Location: profile");
            } else {

                echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
                echo "<br>The following errors occured:<br><br>";
                echo $result;
                echo "<br></div>";
            }
        }
    }
}
//collect all the posts together
$post = new Post();
$id = $user_data['userId'];
$posts = $post->get_posts($id);
//collect all friends
$user = new User();
$friends = $user->get_following($id, "user");
$image_class = new Image();
if (isset($_GET['notific'])) {
    notification_seen($_GET['notific']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>


    <link rel="stylesheet" type="text/css" href="<?php echo ROOT ?>style/profile.css?version=31">

</head>

<body>
    <?php

    include("includes/header.php");
    ?>
    <!--change profile image area-->
    <div id="profile_image_change" class="container_image_change">
        <div style="min-height:400px;flex:2.5;padding:20px;max-width:500px;margin:auto;">
            <div id="write_post_bar">
                <form method="post" enctype="multipart/form-data">
                    <input type="file" id="file_profile_image" name="file" class="file">
                    <label class="file-selector-button" for="file_profile_image">Select file <i class="fas fa-file-alt"></i></label>
                   
                    <input name="change" value="profile" type="hidden">
                    <input id="post_button" type="submit" value="Change">
                    <br>
                    <div style="text-align: center">
                        <br>
                        <?php

                        $change = "profile";
                        // check the mode


                        if ($user_data['profile_image']) {
                            echo "<img src='" . ROOT . "uploads/" . $user_data['userId'] . "/" . $user_data['profile_image'] . "'" . "  style=max-width:300px; >";
                        }

                        ?>
                    </div>
                </form>
                <br>
            </div>
        </div>

    </div>
    <!-- change cover image-->
    <div id="cover_image_change" class="container_image_change">
        <div style="min-height:400px;flex:2.5;padding:20px;max-width:500px;margin:auto;">
            <div id="write_post_bar">
                <form method="post" enctype="multipart/form-data">
                <input type="file" id="file_cover_image" name="file" class="file">
                    <label class="file-selector-button" for="file_cover_image">Select file <i class="fas fa-file-alt"></i></label>                    <input name="change" value="cover" type="hidden">
                    <input name="change" value="cover" type="hidden">
                    <input id="post_button" type="submit" value="Change">
                    <br>
                    <div style="text-align: center">
                        <br>
                        <?php

                        $change = "profile";
                        // check the mode


                        if ($user_data['cover_image']) {
                            echo "<img src='" . ROOT . "uploads/" . $user_data['userId'] . "/" . $user_data['cover_image'] . "' style='max-width:100%;'>";
                        }


                        ?>
                    </div>
                </form>
                <br>
            </div>
        </div>

    </div>
    <!--cover area-->

    <div id="area_cover">
        <div style="background-color:white;text-align:center;color:#405d9b">
            <?php
            $image = "images/cover_image.jpg";
            if ($user_data['cover_image']) {
                $image = "uploads/" . $user_data['userId'] . '/' . $user_data['cover_image'];
            }
            ?>
            <img src="<?php echo ROOT . $image ?>" id="image_main">
            <br>
            <?php
            $myLikes = "";
            if ($user_data['likes'] > 0) {
                $myLikes = "(" . $user_data['likes'] . " followers)";
            }
            ?>
            <?php
            //set a default photo of the profile
            $image = "images/man.jpg";
            if ($user_data['gender'] == "Female") {
                $image = "images/female.jpg";
            }
            if ($user_data['profile_image'] != null) {
                $image = "uploads/" . $user_data['userId'] . '/' . $user_data['profile_image'];
            }
            ?>

            <img src="<?php echo ROOT . $image ?>" id="profile_pic"><br>

            <a onclick="show_change_profile_image(event)" class="link" href="change_profile_image.php?change=profile">Change Image </a>|
            <a onclick="show_change_cover(event)" class="link" href="change_profile_image.php?change=cover">Change Cover<i class="fas fa-images"></i></a>



            <div style="font-size:30px;color:black;"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></div>
            <a href="../like_page.php?type=user&id=<?php echo $user_data['userId'] ?>"><input class="button_like" type="submit" value="Follow <?php echo $myLikes; ?>"></a>


            <?php if ($user_data['userId'] == $_SESSION['userId']) : ?>
                <a href="<?php echo ROOT?>messages/new"><input class="button_like" style="background:green" type="submit" value="Messages"></a>
                </a>
            <?php else : ?>
                <a href="<?=ROOT?>messages/new/<?= $user_data['userId']?>"><input class="button_like" style="background:green" type="submit" value="Message"></a>
                </a>
            <?php endif; ?>
            <br>
            <div id="menu_buttons"><a href="index" class="link_social_network">Timeline</a></div>

            <div id="menu_buttons"><a href="/website/profile?section=followers&id=<?php echo $user_data['userId'] ?>" class="link_social_network">Followers</a></div>

            <div id="menu_buttons"><a href="/website/profile?section=following&id=<?php echo $user_data['userId'] ?>" class="link_social_network">Following</a></div>
            <div id="menu_buttons"><a href="/website/profile?section=photos&id=<?php echo $user_data['userId'] ?>" class="link_social_network">Photos</a> </div>
            <?php if ($user_data['userId'] == $_SESSION['userId']) {
                echo '<div id="menu_buttons" ><a href="profile?section=settings&id=' . $user_data['userId'] . '"class="link_social_network"> Settings</a></div>';
            }
            ?>

        </div> <?php
                $section = "default";
                if (isset($_GET['section'])) {
                    $section = $_GET['section'];
                }

                if ($section == "default") {
                    include("includes/profile_content_default.php");
                } else if ($section == "photos") {
                    include("includes/profile_content_photos.php");
                } else if ($section == "followers") {
                    include("includes/profile_content_followers.php");
                } else if ($section == "following") {
                    include("includes/profile_content_following.php");
                } else if ($section == "settings") {

                    include("includes/profile_content_setting.php");
                }
                ?>
    </div>


</body>

</html>

<script type="text/javascript">
    function show_change_profile_image(event) {
        event.preventDefault();

        var profile_image = document.getElementById("profile_image_change");
        profile_image.style.display = "block";
    }

    function hide_change_profile_image() {
        var profile_image = document.getElementById("profile_image_change");

        profile_image.style.display = "none";

    }

    function show_change_cover(event) {
        event.preventDefault();

        var cover_image = document.getElementById("cover_image_change");
        cover_image.style.display = "block";
    }

    function hide_change_cover() {
        var cover_image = document.getElementById("cover_image_change");

        cover_image.style.display = "none";

    }
    window.onkeydown = function(key) {
        if (key.keyCode == 27) {
            hide_change_cover();
            hide_change_profile_image();
        }
    }
</script>