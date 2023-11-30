<?php
class Signup
{

    private $error = "";
    public function evaluate($data)
    {

        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error .= $key . " is empty!<br/>";
            }
            if ($key == "email") {
                if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $value)) {
                    $this->error = $this->error . " invalid email address!<br>";
                }
            }
            if ($key == "last_name") {
                if (is_numeric($value)) {
                    $this->error = $this->error . "last name cant be a number!<br>";
                }
                if (strstr($value, " ")) {
                    $this->error = $this->error . "last name cant be spaces!<br>";
                }
            }
            if ($key == "fisrt_name") {
                if (is_numeric($value)) {
                    $this->error = $this->error . "first name cant be a number!<br>";
                }
                if (strstr($value, " ")) {
                    $this->error = $this->error . "first name cant be spaces!<br>";
                }
            }




            if ($this->error == "") {
                $this->create_user($data);
            } 
            return $this->error;
        }
    }
    private function create_userid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }
    public function create_user($data)
    {
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);
        $gender = $data['gender'];
        $email = $data['email'];
        $password = hash("sha1",$data['password']);
        $url_address = strtolower($first_name) . "." . strtolower($last_name);
        $userId = $this->create_userid();

        $query = "insert into users(userId,first_name,last_name,gender,email,password,url_address) values('$userId',
        '$first_name','$last_name','$gender','$email','$password','$url_address')";
        $DB = new Database();
        $DB->save($query);
    }
}
