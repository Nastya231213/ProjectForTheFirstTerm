<?php

include("includes/autoload.php");

$login = new Login();
$user_data = $login->check_login(($_SESSION['userId']));
$USER=$user_data;
$results=0;
//find similar fisrt names and lastnames to the keyword
if (isset($_GET['find'])) {
    $find=addslashes($_GET['find']);
    $sql="select * from users where first_name like '%$find%' or last_name like '%$find%' limit 30";
    $DB=new Database();

    $results=$DB->read($sql);
    
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
                <?php

                $user_class = new User();
                $image_class = new Image();
                if (is_array($results) && !empty($results)) {
                    echo " <h2>People that are found</h2>";
                    foreach ($results as $row) {
                        $FRIEDNS_ROW = $user_class->get_data($row['userId']);
                        include("includes/show_friend.php");
                    }
                }else{
                    echo "<h2>No result were found</h2>";
                }
                ?>
                <br>
            </div>


        </div>
    </div>
    </div>
</body>

</html>