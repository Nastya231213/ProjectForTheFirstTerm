<?php

include("../website/includes/autoload.php");

$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER = $user_data;
$user_class = new User();
$post_class = new Post();
$ERROR="";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $message_class = new Messages();


    if ($user_class->get_data($URL[2])) {
        $msg_class = new Messages();
        $message_class->send($_POST, $_FILES, $URL);
        header("Location:" . ROOT . "messages/read/" . $URL[2]);
    } else {
        $ERROR = "the requested user couldn't not be found";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT ?>/style/profile.css?version=153431">
    <style>
        #profile_pic {
            margin-top: 0px;
        }
    </style>
</head>

<body>
    <?php include("../website/includes/header.php") ?>

    <div style="display:flex;width:800px;min-height:400px;margin:auto">

        <div style="min-height:400px;flex:2.5;padding:20px;">
            <div id="write_post_bar" style="color:black;">
                <form method="post" enctype="multipart/form-data">

                    <?php
                    if ($ERROR != "") {
                        echo $ERROR;
                    } else {

                        if (isset($URL[1]) && $URL[1] == "read") {

                            $msg_class = new Messages();
                            $data=$msg_class->read($URL[2]);
                            if (isset($URL[2])) {


                                echo "Start New Message<br><br>";

                                $FRIEDNS_ROW = $user_class->get_data($URL[2]);
                                include("../website/message.php");
                                echo '<div>';
                                foreach ($data as $MSG_ROW){
                                       $MSG_ROW['receiver'];
                                }
                                echo '</div>';

                                echo '
                            
                                <br><br> <div id="write_post_bar">
                                <textarea name="message" placeholder="What is on your mind?" rows="3"></textarea>
                                <input type="file" id="file_profile_image_" name="file"  class="file">
                                    <label class="file-selector-button" for="file_profile_image_">Select file <i class="fas fa-file-alt"></i></i></label>
                                <input id="post_button" type="submit" value="Post">
                
                              <br>
                          </div>';
                            }
                        } else {

                            if (isset($URL[1]) && $URL[1] == "new") {


                                echo "Start New Message<br><br>";

                                $FRIEDNS_ROW = $user_class->get_data($URL[2]);
                                include("../website/message.php");

                                echo '<br><br> <div id="write_post_bar">
                                <textarea name="message" placeholder="What is on your mind?" rows="3"></textarea>
                                <input type="file" id="file_profile_image_" name="file"  class="file">
                                    <label class="file-selector-button" for="file_profile_image_">Select file <i class="fas fa-file-alt"></i></i></label>
                                <input id="post_button" type="submit" value="Post">
                
                            <br>
                        </div>';
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