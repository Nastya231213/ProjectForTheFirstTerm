<?php

include("includes/autoload.php");

$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;

$Post = new Post();
$ERROR = "";

if (isset($_GET['id']) && isset($_GET['type'])) {
    $likes = $Post->get_likes($_GET['id'], $_GET['type']);
} else {
    $ERROR = "No information post was found!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style/profile.css?version=153431">
    <style>
        #profile_pic {
            margin-top: 0px;
        }
    </style>
</head>

<body>
    <?php include("includes/header.php") ?>

    <div style="display:flex;width:800px;min-height:400px;margin:auto">

        <div style="min-height:400px;flex:2.5;padding:20px;">
            <div id="write_post_bar" style="color:black;">
                <h2>People who like the post</h2>
                <?php
                $user_class = new User();
                $image_class = new Image();
                if (is_array($likes)) {
                    foreach ($likes as $row) {
                        $FRIEDNS_ROW = $user_class->get_data($row['user_id']);
                        include("includes/show_friend.php");
                    }
                }
                ?>
                <br>
            </div>


        </div>
    </div>
    </div>
</body>

</html> 