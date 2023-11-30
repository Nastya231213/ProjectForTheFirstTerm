<?php
include($root . "includes/autoload.php");

$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;
$ERROR = "";
$ROW;

if (isset($URL[1])) {
    $post_class = new Post();
    $ROW = $post_class->get_one_posts($URL[1]);
    if (!$ROW) {
        $ERROR = "No such post was found!";
    } else {
        if ($ROW['user_id'] != $_SESSION['userId']) {
            $ERROR = "Access denied!You can't delete this file!";
        }
    }
} else {
    $ERROR = "No such post was found!";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post_class->edit_post($_POST, $_FILES);
    $_SESSION['return_to'] = ROOT."profile";
    if (isset($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], "edit")) {

        $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
    }
    header("Location: " . $_SESSION['return_to']);
    die;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../style/profile.css?version=153431">
    <style>
        #profile_pic {
            margin-top: 0px;
        }
    </style>
</head>

<body>
    <?php include($root . "includes/header.php") ?>

    <div style="display:flex;width:800px;min-height:400px;margin:auto">

        <div style="min-height:400px;flex:2.5;padding:20px;">
            <div id="write_post_bar" style="color:black;">
                <h2>Edit Post</h2>
                <form method="post" enctype="multipart/form-data">

                    <?php
                    if ($ERROR != "") {
                        echo $ERROR;
                    } else {

                        if ($ROW) {
                            echo '<textarea name="post" placeholder="What is on your mind?" rows="3">' . $ROW['post'] . '</textarea>';
                            echo "<input type='hidden' name='post_id' value='$ROW[post_id]'>";
                            echo "<input id='post_button' type='submit' value='Save'><br>";
                            echo "<input type='file' name='file' style='float:left;'>";

                            if (file_exists($ROW['image'])) {
                                $image_class = new Image();
                                $post_image =ROOT. $image_class->get_thumb_cover($ROW['image']);
                                echo "<br><br><div style='text-align:center'><img src='$post_image' style='width:50%';/></div>";
                            }
                        }
                    }

                    ?>

                </form>
                <br>
            </div>


        </div>
    </div>
    </div>
</body>

</html>