<?php

include("includes/autoload.php");

$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;
$ERROR = "";
$ROW;
if (isset($_GET['id'])) {
    $post_class = new Post();
    $ROW = $post_class->get_one_posts($_GET['id']);
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
$Post = new Post();
$User = new User();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style/profile.css?version=1534313">
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
                <?php

                $DB = new Database();
                $id=esc($_SESSION['userId']);
                $limit_notifications=10;
                $query = "select * from notifications where user_id!='$id' and content_owner='$id' order by id desc limit $limit_notifications";
                $data = $DB->read($query);

                ?>
                <?php if (is_array($data)) { ?>
                    <?php foreach ($data as $key => $notific_row) { 
                        include("includes/single_notification.php");
                     } ?>



                <?php }else{
                    echo "No notifications were found";
                } ?>
            </div>


        </div>
    </div>
    </div>
</body>

</html>