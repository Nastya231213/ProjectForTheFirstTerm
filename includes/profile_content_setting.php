<div class="container">
    <div id="divider" style="display:inline-block;max-width:450px;">
        <form method="post" enctype="multipart/form-data">
            <textarea name="post" placeholder="What is on your mind?" rows="3"></textarea>

            <?php
            $settings_class = new Settings();
            $settings = $settings_class->get_settings($_SESSION['userId']);
            echo "<input type'text' id='text_box_small' value='".htmlspecialchars($settings['first_name'])."' name='first_name' placeholder='First Name' />";
            echo "<input type'text' id='text_box_small' name='last_name' value='".htmlspecialchars($settings['last_name'])."' placeholder='Last Name'/>";

            echo "<select id='text_box_small' name='email' value='".htmlspecialchars($settings['gender'])."' placeholder='Email'class='chooser_gender'>
<option>".htmlspecialchars($settings['gender'])."</option>
<option>Male</option>
<option>Female</option>
</select>
";

            echo "<input type='text' id='text_box_small' value='".htmlspecialchars($settings['email'])."' name='email' placeholder='Email'/>";


            echo "<input type='password' id='text_box_small'value='".htmlspecialchars($settings['password'])."'name='password' placeholder='Password'/>";
            echo "<input type='password' id='text_box_small'value='".htmlspecialchars($settings['password'])."' name='password2' placeholder='Password'/>";
            echo "About me:<br>
            <textarea name='about' style='height:200px;' id='text_box_small'>".htmlspecialchars($settings['about'])."</textarea>
            ";
            echo "<input id='post_button' type='submit' value='Save'>";

            ?>
        </form>

    </div>
</div>