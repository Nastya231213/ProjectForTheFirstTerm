
<?php

include("connect.php");
include("classes\login.php");


$email="";
$password="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = new Login();
    $result = $login->evaluate($_POST);
    if ($result != "") {

        echo "<div style='text-align:center; fotn-size:12px;color:white; background-color:grey'>";
        echo "<br>The following errors occured:<br><br>";
        echo $result;
        echo "<br></div>";
    
    }else{
        header("Location:profile");
        die;
    } 
 
    $password=$_POST['password'];
    $email=$_POST['email'];
}


 
?>
<html>

<head>
    <title>Login in</title>
</head>
<link rel="stylesheet" type="text/css"  href="style/login_page.css?version=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<body>

    <div id="bar">

        <div style="font-size:40px">NetSphere
    
        <i class="fas fa-globe-americas"></i>
    </div>


        <div id="signup_button"><a href="singup.php">Signup</a></div>

    </div>
    <div id="login_bar">
                  Log in <br><br>
                  <form method="POST">
                  <input type="text" id="text" name="email" value="<?php echo $email?>"  placeholder="Email"><br><br>
                  <input type="password" name="password"value="<?php echo $password?>" id="text" placeholder="Password"><br><br>
                  <input type="submit" id="button" value="Login">
                  </form>
    </div>

</body>

</html>