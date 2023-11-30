<?php

include("includes/autoload.php");

$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;

if (isset($_GET['id'])) {
    $profile = new Profile();

    $profile_data = $profile->get_profile($_GET['id']);

    if (is_array($profile_data)) {
        $user_data = $profile_data[0];
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {



    $post = new Post();

    $post->create_post($_POST, $_SESSION['userId'], $_FILES);
    if ($result == "") {
        header("Location: index.php");
        die;
    } else {

        echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
        echo "<br>The following errors occured:<br><br>";
        echo $result;
        echo "<br></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style/profile.css?version=153432">
    <style>
        #profile_pic {
            margin-top: 0px;
        }
    </style>
</head>

<body>
    <?php include("includes/header.php") ?>

    <div style="display:flex;width:800px;min-height:400px;margin:auto">
        <!--friends area-->
        <div style="min-height:400px;flex:1">
            <div align="center" style="margin-top: 30px;min-height:400px;padding:8px;">
                <?php
                $image = "images/man.jpg";
                if ($user_data['profile_image']) {
                    $image = "uploads/" . $user_data['userId'] . '/' . $user_data['profile_image'];
                }
                ?>
                <img src="<?php echo $image ?>" id="profile_pic"><br>
                <br>
                <div id="name"><a href="profile.php" style="text-decoration:none"> <?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></a></div>
            </div>


        </div>
        <div style="min-height:400px;flex:2.5;padding:20px;">
            <div id="write_post_bar">
                <form method="post" enctype="multipart/form-data">
                    <textarea name="post" placeholder="What is on your mind?" rows="3"></textarea>
                    <input type="file" id="file_profile_image" name="file" class="file">
                    <label class="file-selector-button" for="file_profile_image">Select file <i class="fas fa-file-alt"></i></label>
                    <input id="post_button" type="submit" value="Post">
                </form>
                <br>
            </div>

            <div id="post_bar">
                <?php

                $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $page_number = ($page_number < 1) ? 1 : $page_number;

                $limit = 10;
                $offset = ($page_number - 1) * $limit;

                $pg = pagination_link();

                $DB = new Database();
                $user_class = new User();
                $image_class = new Image();

                $followers = $user_class->get_following($user_data['userId'], "user");
                $follower_ids = [];
                if (is_array($followers)) {
                    $follower_ids = array_column($followers, "user_id");
                    $follower_ids = implode("','", $follower_ids);
                }


                $sql = "SELECT * FROM posts WHERE (user_id='$user_data[userId]' OR user_id IN ('$follower_ids')) AND parent = '0' ORDER BY id DESC LIMIT $limit OFFSET $offset";
                $posts = $DB->read($sql);

                if (isset($posts) && $posts) {
                    foreach ($posts as $ROW) {
                        $user = new User();
                        $ROW_USER = $user->get_data($ROW['user_id']);
                        include("post.php");
                    }
                }
                ?>

                <a href="<?php echo $pg['next_page'] ?>">
                    <input id="post_button" type="button" value="Next Page" style="float:right; width:150px; margin-right:0px;">
                </a>
                <a href="<?php echo $pg['prev_page'] ?>">
                    <input id="post_button" type="button" value="Prev Page" style="float:left; width:150px;">
                </a>
                <br><br>
            </div>
        </div>
    </div>
</body>

</html>