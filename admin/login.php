<?php include '../config/constants.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login: Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br/> <br/>
        <?php 
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if (isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br><br>
        <!-- Login form starts here -->
        <form action="" method="post" class="text-center">
            Username: <br/> <br/>
            <input type="text" name="username" placeholder="Enter your Username">
            <br/> <br/>
            Password: <br/> <br/>
            <input type="password" name="password" placeholder="Enter your Password">
            <br/> <br/>
            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <!-- Login form ends here -->
        <br/> <br/>
        <p class="text-center">Created By - <a href="#">Ariel Benvindo</a></p>
    </div>
</body>
</html>
<?php 

    //Check whether submit is clicked or not
    if(isset($_POST['submit'])){
        //Process for login
        //1. get the data from login form

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);
        
        //2. sql to check whether the user with username password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the query
        $res = mysqli_query($conn, $sql);

        //4. count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1){
            //User avaliable and login Success
            $_SESSION['login'] = "<div class='success' style='color: green;'>Login Successfull.</div>";
            $_SESSION['user'] = $username;
            
            //Redirect to home page/dashboard
            header('location:'.SITEURL.'admin/');
        }else{
            //User not avaliable and Login Failed
            $_SESSION['login'] = "<div class='error text-center' style='color: red;'>Username or Password did not match.</div>";
            //Redirect to home page/dashboard
            header('location:'.SITEURL.'admin/login.php');
         }
    }

?>