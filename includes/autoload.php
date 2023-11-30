<?php
session_start();
include("connect.php");
include("classes\login.php");
include("classes\user.php");
include("classes\post.php");
include("classes\image.php");
include("classes\profile.php");
include("classes\settings.php");
include("classes\messages.php");

include("includes\pagination_link.php");
if(!defined("ROOT")){
    $root=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
    define("ROOT",str_replace("router.php","",$root));
}
$root="../website/";



?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
