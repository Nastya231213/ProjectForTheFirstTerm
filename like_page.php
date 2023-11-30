<?php
include("includes/autoload.php");

$login = new Login();
$user_class=new User();
$user_data = $login->check_login(($_SESSION['userId']));
$return_to;
if (isset($_SERVER['HTTP_REFERER'])) {
    $return_to = $_SERVER['HTTP_REFERER'];
} else {
    $return_to = "profile.php";
}
if (isset($_GET['type']) && isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {

        $allowed[]='post';
        $allowed[]='user';
        $allowed[]='comment';
        if(in_array($_GET['type'],$allowed)){
            $single_item="";
            $post = new Post();

            if($_GET['type']=='post'){
                $single_item=$post->get_one_posts($_GET['id']);

                $type='post';
                if($single_item['parent']!=0){
                    $type='comment';
                }
                $post->like_post($_GET['id'],$type,$_SESSION['userId']);
                add_notification($_SESSION['userId'],"like",$single_item);

            }
    
            if($_GET['type']=="user"){
                $user_class->follow_user($_GET['id'],$_GET['type'],(string)$_SESSION['userId']);
                $post->like_post($_GET['id'],$_GET['type'],$_SESSION['userId']);

                add_notification($_SESSION['userId'],"follow",$single_item);

            }
        }     
    }
}

header("Location: " . $return_to);
die;
