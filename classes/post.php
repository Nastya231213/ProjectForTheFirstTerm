<?php
class Post
{


    private $error = "";
    public function create_post($data, $userId, $file)
    {
        $DB = new Database();
        if (!empty($data['post']) || !empty($file['file']['name'])) {

            $my_image = "";
            $has_image = 0;

            if (!empty($file['file']['name'])) {
                $image_class = new Image();

                $folder = "../uploads/" . $userId . "/";
                if (!file_exists($folder)) {

                    mkdir($folder, 7777, true);
                }
                $image = new Image();
                $file_name = $folder . $image->getnerate_filename(15) . ".jpg";
                $my_image = $file_name;
                $has_image = 1;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
                $image_class->resize_image($my_image, $my_image, 1500, 1500);
                $has_image = 1;
            }

            $post = addslashes($data['post']);

            $postId = $this->create_post_id();
            $parent = 0;
            if (isset($data['parent']) && is_numeric($data['parent'])) {
                $parent = $data['parent'];
                $sql = "update posts set comments=comments+1 where post_id='$parent' limit 1";
                $DB->save($sql);
            }
            $query = "insert into posts(user_id,post_id, post,image,has_image,parent) values('$userId','$postId','$post','$my_image','$has_image','$parent')";
            $DB = new Database();
            $DB->save($query);
            $parent_post = $this->get_one_posts($data['parent']);

            if ($parent_post['user_id'] != $userId && isset($data['parent'])) {

                add_notification($userId, "comment", $parent_post);
            }
        } else {
            $this->error = "Please type something!<br>";
        }
        return $this->error;
    }

    public function edit_post($data, $file)
    {
        if (!empty($data['post']) || !empty($file['file']['name'])) {

            $my_image = "";
            $has_image = 0;

            if (!empty($file['file']['name'])) {
                $image_class = new Image();

                $folder = "../uploads/" . $data['user_id'] . "/";
                if (!file_exists($folder)) {

                    mkdir($folder, 7777, true);
                }
                $image = new Image();
                $file_name = $folder . $image->getnerate_filename(15) . ".jpg";
                $my_image = $file_name;
                $has_image = 1;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
                $image_class->resize_image($my_image, $my_image, 1500, 1500);
                $has_image = 1;
            }

            $post = addslashes($data['post']);

            $postId = addslashes($data['post_id']);

            if ($has_image) {
                $query = "update posts set post='$post', image='$my_image' where post_id='$postId'";
            } else {
                $query = "update posts set post='$post' where post_id='$postId'";
            }
            $DB = new Database();
            $DB->save($query);
        } else {
            $this->error = "Please type something!<br>";
        }
        return $this->error;
    }
    public function delete_post($post_id)
    {
        if (!is_numeric($post_id)) {
            return false;
        }
        $DB = new Database();

        $sql = "select parent from posts where post_id='$post_id'";
        $data = $DB->read($sql);
        if ($data[0]['parent']) {
            $parent = $data[0]['parent'];
            $sql = "update posts set comments=comments-1 where post_id='$parent' limit 1";
            $DB->save($sql);
        }

        $query = "delete from posts where post_id='$post_id' limit 1";

        $DB->save($query);
    }
    public function i_own_post($post_id, $userId)
    {
        if (!is_numeric($post_id)) {
            return false;
        }

        $query = "select * from posts where post_id='$post_id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);
        if (is_array($result)) {
            if ($result[0]['user_id'] == $userId) {
                return true;
            }
        }
        return false;
    }
    private function create_post_id()
    {

        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }
    public function get_posts($id)
    {
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page_number = ($page_number < 1) ? 1 : $page_number;
        $limit = 10;
        $offset = ($page_number - 1) * $limit;
        $query = "select * from posts where user_id='$id' and parent='null' order by id desc limit $limit offset $offset";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_comments($id)
    {
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page_number = ($page_number < 1) ? 1 : $page_number;
        $limit = 5;
        $offset = ($page_number - 1) * $limit;

        $query = "select * from posts where parent='$id' order by id asc limit $limit offset $offset";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_likes($id, $type)
    {


        if (is_numeric($id)) {
            $DB = new Database();
            $sql = "select likes from likes where type='$type' and content_id='$id' limit 1";
            $result = $DB->read($sql);
            if (is_array($result) && isset($result)) {
                $likes = json_decode($result[0]['likes'], true);
                return $likes;
            }
        }

        return false;
    }


    public function like_post($id, $type, $user_id)
    {
        $DB = new Database();

        if ($type == "post" || $type == "comment") {
            //increment the posts table

            //save likes details
            $sql = "select likes from likes where type='$type' and content_id='$id' limit 1";

            $result = $DB->read($sql);
            if (is_array($result) && isset($result[0])) {
                $likes = json_decode($result[0]['likes'], true);
                $user_ids = array_column($likes, "user_id");
                if (!in_array($user_id, $user_ids)) {
                    $arr["user_id"] = $user_id;
                    $arr["date"] = date("Y-m-d H:i:s");
                    $arr2[] = $arr;

                    $likes[] = $arr2;

                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes='$likes_string' where type='$type' and content_id='$id' limit 1";
                    $DB->save($sql);
                    $sql = "update posts set likes=likes+1 where post_id='$id' limit 1";

                    $DB->save($sql);
                } else {
                    $key = array_search($user_id, $user_ids);
                    unset($likes[$key]);
                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes='$likes_string' where type='$type' and content_id='$id' limit 1";
                    $DB->save($sql);
                    $sql = "update posts set likes=likes-1 where post_id='$id' limit 1";

                    $DB->save($sql);
                }
            } else {
                $arr["user_id"] = $user_id;
                $arr["date"] = date("Y-m-d H:i:s");
                $arr2[] = $arr;
                $likes = json_encode($arr2);
                $sql = "insert into likes(type,content_id,likes) values('$type','$id','$likes') ";
                $DB->save($sql);

                $sql = "update posts set likes=likes+1 where post_id='$id' limit 1";

                $DB->save($sql);
            }
        
        }
        if ($type == "user") {
            //increment the posts table
            //save likes details
            $sql = "select likes from likes where type='$type' and content_id='$id' limit 1";

            $result = $DB->read($sql);
            if (is_array($result) && isset($result[0])) {
                $likes = json_decode($result[0]['likes'], true);
                $user_ids = array_column($likes, "user_id");
                if (!in_array($user_id, $user_ids)) {
                    $arr["user_id"] = $user_id;
                    $arr["date"] = date("Y-m-d H:i:s");

                    $likes[] = $arr;

                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes='$likes_string' where type='$type' and content_id='$id' limit 1";
                    $DB->save($sql);
                    $sql = "update users set likes=likes+1 where userId='$id' limit 1";

                    $DB->save($sql);
                } else {
                    $key = array_search($user_id, $user_ids);
                    unset($likes[$key]);
                    $likes_string = json_encode($likes);
                    $sql = "update likes set likes='$likes_string' where type='$type' and content_id='$id' limit 1";
                    $DB->save($sql);
                    $sql = "update users set likes=likes-1 where userId='$id' limit 1";

                    $DB->save($sql);
                }
            } else {
                $arr["user_id"] = $user_id;
                $arr["date"] = date("Y-m-d H:i:s");
                $arr2[] = $arr;
                $likes = json_encode($arr2);
                $sql = "insert into likes(type,content_id,likes) values('$type','$id','$likes') ";
                $DB->save($sql);

                $sql = "update users set likes=likes+1 where userId='$id' limit 1";

                $DB->save($sql);
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
    //Function to get user by id
    public function get_user($id)
    {
        $query = "select * from users where user_id='$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
}
