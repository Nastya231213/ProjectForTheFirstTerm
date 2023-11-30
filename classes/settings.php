<?php

Class Settings{

    public function get_settings($id){
        $DB=new Database();
        $sql="select * from users where userId='$id' limit 1";
        $row=$DB->read($sql);
        if(is_array($row)){
            return $row[0];
        }
    }

    public function save_settings($data, $id){
        $DB = new Database();
    
        $password = $data['password'];
        if (strlen($password) < 30) {
            if ($data['password'] == $data['password2']) {
                $data['password'] = hash('sha1', $password);
            } else {
                unset($data['password']);
            }
        }
        unset($data['password2']);
    
        $sql = "UPDATE users SET ";
        $setClauses = [];
        foreach ($data as $key => $value) {
            // Check if the value is not empty before appending to the SET clause
            if (!empty($value)) {
                $setClauses[] = $key . "='" . $value . "'";
            }
        }
    
        $sql .= implode(", ", $setClauses);
        $sql .= " WHERE userId='$id' LIMIT 1";
    
        $DB->save($sql);
    }

}