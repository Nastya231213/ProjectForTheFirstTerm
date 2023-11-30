<?php

include("includes/autoload.php");

$login = new Login();
$post_class=new Post();

$user_data = $login->check_login(($_SESSION['userId']));
$USER=$user_data;
$ERROR = "";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $ROW=$post_class->get_one_posts($URL[1]);

    $post_class->delete_post(($URL[1]));

    header("Location: /website/profile");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT?>style/profile.css?version=153431">
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
                <h2>Delete Post</h2>
                <form method="post">

                    <?php
                    if ($ERROR != "") {
                        echo $ERROR;
                    } else {
                        $ROW=$post_class->get_one_posts($URL[1]);

                        if ($ROW) {
                            echo  "Are you sure you want to delete this post?";
                            echo "<br><br>";

                            $user = new User();
                            $ROW_USER = $user->get_data($ROW['user_id']);


                            include("includes/post_delete.php");
                            echo "<input type='hidden' name='post_id' value='$ROW[post_id]'>";
                            echo "<input id='post_button' type='submit' value='Delete'>";
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