
<div class="container">
    <div id="divider">
<?php

$DB = new Database();
$sql = "select image, post_id from posts where has_image=1 && user_id=$user_data[userId] order by id desc limit 30";
$images=$DB->read($sql);


$image_class=new Image();
if(is_array($images)){
    foreach($images as $image_row){
        echo "<img src='". $image_class->get_thumb_cover($image_row['image'])."' style='width:150px;margin:10px;' />";
    }
}else{
    echo "No images were found!";
}

?>
</div>
</div>