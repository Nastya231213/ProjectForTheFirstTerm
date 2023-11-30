<?php

function pagination_link()
{
    $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page_number = ($page_number < 1) ? 1 : $page_number;
    $arr = array();
    $arr['next_page'] = "";
    $arr['prev_page'] = "";

    $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] ;
    $url = str_replace("router.php", "", $url);

    $num = 0;
    $page_found = false;

    $next_page_link = $url;
    $prev_page_link = $url;

    foreach ($_GET as $key => $value) {
        $num++;
        if ($num == 1) {
            if ($key == "page") {
                $next_page_link .= $key . "=" . ($page_number + 1);
                $prev_page_link .= $key . "=" . ($page_number - 1);
                $page_found = true;
            }   else if($key=="url") {
                $next_page_link .= $value;
                $prev_page_link .= $value;
            }else {
                $next_page_link .= $key . "=" . $value;
                $prev_page_link .= $key . "=" . $value;
            }
        } else {
            if ($key == "page") {
                $next_page_link .= "&" . $key . "=" .  ($page_number + 1);
                $prev_page_link .= "&" . $key . "=" .  ($page_number - 1);
                $page_found = true;
            } else if($key=="url") {
                $next_page_link .= $value.'/';
                $prev_page_link .= $value.'/';
            }else{
                $next_page_link .= "&" . $key . "=" . $value;
                $prev_page_link .= "&" . $key . "=" . $value;
            }
        }
    }
    $arr['next_page'] = $next_page_link;
    $arr['prev_page'] = $prev_page_link;
    if (!$page_found) {
        $arr['next_page'] = $next_page_link . "&page=2";
        $arr['prev_page'] = $prev_page_link . "&page=1";
    }

    return $arr;
}


function add_notification($userId, $activity, $row)
{
    $row = (object)$row;
    $userId = esc($userId);
    $activity = esc($activity);
    $content_id = 0;
    $content_owner = 0;
    $content_type = "";
    $date = date("Y-m-d H:i:s");

    if (isset($row->post_id)) {
        $content_id = $row->post_id;
  
        if($row->parent!=0){
            $content_type = "comment";

        }else{
            $content_type = "post";

        }
        $content_owner = $row->user_id;
    }
    if (isset($row->gender)) {
        $content_type = "profile";
        $content_id = $row->userId;
        $content_owner = $row->userId;;
    }

    $query = "insert into notifications(user_id,activity,content_owner,date,content_id,content_type) 
    values('$userId','$activity','$content_owner','$date','$content_id','$content_type')";

    $DB = new Database();
    $DB->save($query);
}

function content_i_follow($userId, $row)
{
    $userId = esc($userId);
    $content_owner = $row->userId;
    $content_id = 0;
    $date = date("Y-m-d H:i:s");

    if (isset($row->post_id)) {
        $content_id = $row->post_id;
        $content_type = "post";
        if ($row->parent > 0) {
            $content_type = "comment";
        }
    }
    if (isset($row->gender)) {
        $content_type = "profile";
    }

    $query = "insert into content_i_follow(user_id,activity,content_owner,date,content_id,content_type) 
    values('$userId','$content_owner','$date,'$content_id,'$content_type)";

    $DB = new Database();
    $DB->save($query);
}

function esc($value)
{


    return addslashes($value);
}

function notification_seen($id)
{

    $DB = new Database();
    $id = addslashes($id);
    $user_id = $_SESSION['userId'];
    $query = "select * from notification_seen where user_id='$user_id' && notification_id='$id' limit 1";
    $check = $DB->read($query);
    if (!$check) {
        $query = "insert into notification_seen (user_id,notification_id) values('$user_id','$id')";
        $DB->save($query);
    }
}

function check_notifications()
{
    $number = 0;
    $limit_notifications = 30;
    $DB = new Database();
    $user_id = $_SESSION['userId'];
    $query = "select * from notifications where user_id!='$user_id' and content_owner='$user_id' order by id desc limit $limit_notifications";
    $data = $DB->read($query);

    if ($data) {
        foreach ($data as $row) {

            $query = "select * from notification_seen where user_id='$user_id' && notification_id='$row[id]' limit 1";
            $check = $DB->read($query);
            if (!$check) {
                $number++;
            }
        }
    }

    return $number;
}
