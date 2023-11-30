<?php

$corner_image = "images/man.jpg";
if ($USER['gender'] == "Female") {
    $corner_image = "/images/female.jpg";
}
if (isset($USER)) {
    if ($USER['profile_image']) {
        $corner_image ="uploads/" . $USER['userId'] . '/' . $USER['profile_image'];
    }

}
?>
<div id="bar" style="margin: 0 auto;">
    <form method="get" action="/website/search">

        <div id="sub_bar">
            NetSphere<i class="fas fa-globe-americas"></i> &nbsp&nbsp 
<input type="text" name="find" id="search_box" placeholder="Search friends">
            <a href="<?php echo ROOT?>profile"> <img src="<?php echo  ROOT.$corner_image; ?>" id="image_profile">
                <a href="<?php echo ROOT?>logout"> <span class="logout"><i class="fas fa-sign-out-alt"></i></span></a>
                <span style="position:relative;display:inline-block;">
                <a href="/website/notifications"><img src="<?php echo ROOT?>images/notif.svg" id="notification"></a>

                    <?php
                          $notif = check_notifications();
                      

                          if($notif>0):
                    ?>
                    
                    <div id="quantity_of_notifications"><?=$notif?></div>
                    <?php endif; ?>
                </span>
        </div>
    </form>

</div>