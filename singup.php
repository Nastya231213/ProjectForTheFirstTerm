<?php
include("connect.php");
include("classes\singup.php");

$first_name="";
$last_name="";
$gender="";
$email="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $signup = new Signup();
    $result = $signup->evaluate($_POST);
    if ($result != "") {

        echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
        echo "<br>The following errors occured<br><br>";
        echo $result;
        echo "</div>";
    }else{
        header("Location:profile.php");
        die;
    }
    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $gender=$_POST['gender'];
    $email=$_POST['email'];
}


 
?>


<html>

<head>
    <title>Login in</title>
</head>
<link rel="stylesheet" type="text/css" href="style/login_page.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<body>

    <div id="bar">

        <div style="font-size:40px">NetSphere

            <i class="fas fa-globe-americas"></i>
        </div>


        <a href="login"><div id="signup_button">Sign in</div></a>

    </div>
    <div id="login_bar" style="height:400px">
        <form method="post" action="">
            Sign Up <br><br>
            <input value="<?php echo $first_name ?>" type="text" id="text" name="first_name" placeholder="First name"><br><br>
            <input  value="<?php echo $last_name?>" type="text" id="text" name="last_name" placeholder="Last name"><br><br>
            <span style="font-weight:normal;"> Gender:</span><br><br>
            <select id="text" name="gender">
                <option ><?php echo $gender?></option>
                <option>Female</option>
            
                <option>Male</option>
            </select><br><br>
            <input type="text" name="email" id="text" placeholder="Email"><br><br>

            <input name="password" type="password" id="text" placeholder="Password"><br><br>
            <input type="submit" id="button" value="Sign up">
        </form>
    </div>

</body>

</html>