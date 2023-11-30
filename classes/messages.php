<?php

Class Messages{
    private $error;
    public function send($data, $FILES,$URL)
    {
        $DB = new Database();
        if (!empty($data['message']) || !empty($file['file']['name'])) {

            $my_image = "";
            $has_image = 0;
            $user_class=new User();

            if (!empty($file['file']['name'])) {
                $image_class = new Image();

                $folder = "../uploads/" . $_SESSION['userId'] . "/";
                if (!file_exists($folder)) {

                    mkdir($folder, 7777, true);
                }
                $image = new Image();
                $file_name = $folder . $image->getnerate_filename(15) . ".jpg";
                $my_image = $file_name;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
                $image_class->resize_image($my_image, $my_image, 1500, 1500);
            }
            $sender=$_SESSION['userId'];


            $receiver = addslashes($URL[2]);
            $msg_id = $this->create_message_id();
            $file=addslashes($my_image);
            $message=addslashes($data['message']);
            
            $query = "insert into messages(sender,msg_id,receiver, message,file,received) values('$sender',$URL[2],'$msg_id','$message','$my_image','1')";
            $DB = new Database();
            $DB->save($query);
      
        } else {
            $this->error = "Please type something!<br>";
        }
        return $this->error;
    }
    private function create_message_id()
    {

        $length = rand(4, 19);  
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }

    public function read($user_id){
        $DB=new Database();
        $me=addslashes($_SESSION['userId']);
        $query="select * from messages where (sender= '$me' && receiver ='$user_id') || (sender= '$user_id' && receiver ='$me') order by id desc";
        $data=$DB->read($query);
        return $data;

    }
}