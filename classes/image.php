<?php
class Image
{
    public function getnerate_filename($length)
    {

        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $letters = range('A', 'Z');
        $letters = array_merge($letters, range('a', 'z'));
        $array = array_merge($array, $letters);
        $text = "";
        for($x=0;$x<$length;$x++){
            $random=rand(0,61);
            $text.=$array[$random];
        }
        return $text;
    }

    public function crop_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        $new_height = 0;
        $new_width = 0;
        if (file_exists( $original_file_name)) {
            $original_image = imagecreatefromjpeg($original_file_name);
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            if ($original_height > $original_width) {
                $ratio = $max_width / $original_width;
                $new_width = $max_width;
                $new_height = $original_height * $ratio;
            } else {
                $ratio = $max_height / $original_height;
                $new_height = $max_height;
                $new_width = $original_width * $ratio;
            }

            //get rid of black square
            if ($max_width != $max_height) {
                if ($max_height > $max_width) {
                    if ($max_height > $new_height) {
                        $adjustment = ($max_height / $new_height);
                    } else {
                        $adjustment = ($new_height / $max_height);
                    }
                    $new_width = $new_width * $adjustment;
                    $new_height = $new_height * $adjustment;
                } else {
                    if ($max_width > $new_width) {
                        $adjustment = ($max_width / $new_width);
                    } else {
                        $adjustment = ($new_width / $max_width);
                    }
                    $new_width = $new_width * $adjustment;
                    $new_height = $new_height * $adjustment;
                }
            }
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
            imagedestroy($original_image);
            if ($max_width != $max_height) {
                if ($max_width > $max_height) {
                    $diff = ($new_height - $new_width);
                    $diff = $diff * (-1);
                    $y = round($diff / 2);
                    $x = 0;
                } else {
                    $diff = ($new_width - $max_height);
                    if ($diff < 0) {
                        $diff = $diff * (-1);
                    }
                    $y = round($diff / 2);
                    $x = 0;
                }
            } else {
                if ($new_height > $new_width) {
                    $diff = ($new_height - $new_width);
                    $y = round($diff / 2);
                    $x = 0;
                } else {
                    $diff = ($new_width - $new_height);
                    $x = round($diff / 2);
                    $y = 0;
                }
            }



            $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
            imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
            imagedestroy($new_image);
            imagejpeg($new_cropped_image, $cropped_file_name, 90);
            imagedestroy($new_cropped_image);
        }
    }
    public function resize_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        $new_height = 0;
        $new_width = 0;
        if (file_exists( $original_file_name)) {
            $original_image = imagecreatefromjpeg($original_file_name);
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            if ($original_height > $original_width) {
                $ratio = $max_width / $original_width;
                $new_width = $max_width;
                $new_height = $original_height * $ratio;
            } else {
                $ratio = $max_height / $original_height;
                $new_height = $max_height;
                $new_width = $original_width * $ratio;
            }

            //get rid of black square
            if ($max_width != $max_height) {
                if ($max_height > $max_width) {
                    if ($max_height > $new_height) {
                        $adjustment = ($max_height / $new_height);
                    } else {
                        $adjustment = ($new_height / $max_height);
                    }
                    $new_width = $new_width * $adjustment;
                    $new_height = $new_height * $adjustment;
                } else {
                    if ($max_width > $new_width) {
                        $adjustment = ($max_width / $new_width);
                    } else {
                        $adjustment = ($new_width / $max_width);
                    }
                    $new_width = $new_width * $adjustment;
                    $new_height = $new_height * $adjustment;
                }
            }
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
            imagedestroy($original_image);
            imagejpeg($new_image, $cropped_file_name, 90);
            imagedestroy($new_image);
        }
    }
    public function get_thumb_cover($file_name){
        $thumbnail=$file_name;
        $this->crop_image($file_name,$file_name,800,800);
        if(file_exists($thumbnail)){
            return $thumbnail;
        }else{
            return $file_name;
        }

    }
}
