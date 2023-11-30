<?php



$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {

        if ($_FILES['file']['type'] == 'image/jpeg') {

            $allowedSize = 1024 * 1024 * 7;
            if ($_FILES['file']['size'] < $allowedSize) {

                $folder = "uploads/" . $user_data['userId'] . "/";
                if (!file_exists($folder)) {

                    mkdir($folder, 7777, true);
                }
                $image = new Image();
                $generatedName = $image->getnerate_filename(15) . ".jpg";

                $filename = $folder . $generatedName;
                move_uploaded_file($_FILES['file']['tmp_name'], $filename);
                $cropped_image = $filename;
                $userId = $user_data['userId'];
                $change = "profile";
                if (isset($_POST['change'])) {
                    $change = $_POST['change'];
                }
                if ($change == "cover") {
                    unlink($folder.$user_data['cover_image']);

                    $image->crop_image($filename, $cropped_image, 1388, 388);
                } else {
                    unlink($folder.$user_data['profile_image']);

                    $image->crop_image($filename, $cropped_image, 800, 800);
                }
                if (file_exists($cropped_image)) {
                    if ($change == "cover") {

                        $query = "UPDATE users SET cover_image='$generatedName' where userId='$userId' limit 1";
                    } else {

                        $query = "UPDATE users SET profile_image='$generatedName' where userId='$userId' limit 1";
                    }
                    $DB = new Database();
                    $DB->save($query);
                    header("Location: ".ROOT."profile");
                }
            } else {

                echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
                echo "<br>The following errors occured:<br><br>";
                echo "The size isn't allowed";
                echo "<br></div>";
            }
        } else {
            echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
            echo "<br>The following errors occured:<br><br>";
            echo "The format of file isn't appropriate!";
            echo "<br></div>";
        }
    } else {
        echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
        echo "<br>The following errors occured:<br><br>";
        echo "Ony images of jpeg type are allowed!";
        echo "<br></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style/profile.css?version=1534341">
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
            <div id="write_post_bar">
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <input id="post_button" type="submit" value="Change">
                    <br>
                    <div style="text-align: center">
                    <br>
                        <?php
                        
                        // check the mode
                        if (isset($_POST['change']) && $_POST['change'] == "cover") {
                            $change = "cover";
                            echo "<img src='uploads/" . $user_data['userId'] . "/" . $user_data['cover_image'] .  "'"."  style=max-width:100%; >";
                        } else {
                            echo "<img src='uploads/" . $user_data['userId'] . "/" . $user_data['profile_image'] . "'" . "  style=max-width:300px; >";
                        }
                        ?>
                    </div>
                </form>
                <br>
            </div>


        </div>
    </div>
    </div>


</body>

</html>