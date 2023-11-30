<?php
class Login
{
    private $error = "";

    public function evaluate($data)
    {
        
        session_start();

        $email = addslashes($data['email']);
        $password = addslashes($data['password']);


        $query = "select * from users where email='$email' limit 1";
        $database = new Database();
        $result = $database->read($query);
        if ($result) {
            $row=$result[0];
            if($this->hashed_text_out($password)==$row['password']){
               $_SESSION['userId']=$row['userId'];
            }else{
                $this->error .="wrong email or password <br>";
            }
        }else{
            $this->error.="wrong email or password <br>";
        }
        return $this->error;

    }

    
    private function hashed_text_out($text){

        $text=hash("sha1",$text);
        return $text;
    }

    public function check_login($id){
        if(is_numeric($id)){
        $query = "select * from users where userId='$id' limit 1";
        $database = new Database();
        $result = $database->read($query);
        if($result){
            $user_data=$result[0];
            return $user_data;
        }else {
            header("Location:login.php");
            die;
        }

            } else {
                header("Location:login.php");
                die;
            }
        
    }
}
