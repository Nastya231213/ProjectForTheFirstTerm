<?php
class Profile{
    function get_profile($id){
        $id=addslashes($id);
        $DB=new Database();
        $query="select * from users where userId='$id' limit 1";
        return $DB->read($query);
    }

}



?>