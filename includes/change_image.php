<?php

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {

        if ($_FILES['file']['type'] == 'image/jpeg') {

            $allowedSize = 1024 * 1024 * 10;
            if ($_FILES['file']['size'] < $allowedSize) {

                $folder = ROOT."uploads/" . $user_data['userId'] . "/";
                echo $folder;
                die;
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
                if (isset($_GET['change'])) {
                    $change = $_GET['change'];
                }
                if ($change == "cover") {
                    unlink($folder . $user_data['cover_image']);

                    $image->crop_image($filename, $cropped_image, 1388, 388);
                } else {
                    unlink($folder . $user_data['profile_image']);

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
                    header("Location: profile");
                }
                die;
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

