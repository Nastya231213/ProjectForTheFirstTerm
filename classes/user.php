<?php

class User
{
    public function get_data($id)
    {
        $query = "select * from users where userId='$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];
            return $row;
        } else {
            return false;
        }
    }



    public function get_following($id, $type)
    {

        if (is_numeric($id)) {
            $DB = new Database();
            $type = addslashes($type);
            $sql = "select following from likes where type='$type' && content_id='$id' limit 1";
            $result = $DB->read($sql);
            if (is_array($result) && $result) {
                $following = json_decode($result[0]['following'], true);

                return $following;
            }
        }

        return false;
    }


    public function follow_user($id, $type, $user_id)
    {
 
        $DB = new Database();

        if ($type == 'user') {

            $sql = "SELECT following FROM likes WHERE type='$type' AND content_id='$user_id'";
            $result = $DB->read($sql);
            if (is_array($result) && isset($result[0])) {
                if ($result[0]['following'] == null) {
                    $following = [];
                } else {
                    $following = json_decode($result[0]['following'], true);
                }
                $user_ids = array_column($following, "user_id");
                $likes_string = "";
                if (!in_array($id, $user_ids)) {
                    $arr["user_id"] = $id;
                    $arr["date"] = date("Y-m-d H:i:s");

                    $following[] = $arr;

                    $likes_string = json_encode($following);

                } else {
                    $key = array_search($id, $user_ids);
                    unset($following[$key]);
                    $likes_string = json_encode($following);
                }
                $sql = "UPDATE likes SET following='$likes_string' WHERE type='user' AND content_id='$user_id'";
                $DB->save($sql);
            } else {
                $arr["user_id"] = $id;
                $arr["date"] = date("Y-m-d H:i:s");
                $arr2[] = $arr;
                $following = json_encode($arr2);
                $sql = "insert into likes(type,content_id,following) values('$type','$user_id','$following')";

                $DB->save($sql);
                $sql = "insert into likes(type,likes,following) values('$following','$user_id','$following')";


            }
            
        }
    }
    public function get_one_posts($post_id)
    {
        if (!is_numeric($post_id)) {
            return false;
        }
        $query = "select * from posts where post_id='$post_id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
}
