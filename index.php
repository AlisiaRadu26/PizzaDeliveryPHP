<?php 
    include "config.php";
    session_start();

    $username_err_array = [];
    $password_err_array = [];


    $first_login = mysqli_query($connect, "SELECT id from admins WHERE username = '".$_SESSION['username']."'");

    if(mysqli_num_rows($first_login) === 0){
        $_SESSION['authentification_complete'] = false;
    }

    if(isset($_POST['submit']) && $_SESSION['authentification_complete'] === false)
    {  
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $res = mysqli_query($connect, "SELECT * from admins WHERE username = '".$username."'");
        $numRows = mysqli_num_rows($res);

        while ($row = mysqli_fetch_assoc($res)) {
            $_SESSION['id'] = intval($row['id']);
            $_SESSION['username'] = $row['username'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
        }
        if($numRows  == 1 && $username === $_SESSION['username'] && password_verify($password, $_SESSION['password'])){
            echo "You are login Successfully ";
            $_SESSION['authentification_complete'] = true;
            header("location: menu.php");   // create my-account.php page for redirection 	
        }
        else
        {
	        // echo "failed ";
            if(empty($username)){
                array_push($username_err_array, "You must introduce the username!");
            }elseif(!($username === $_SESSION['username'])){
                array_push($username_err_array, "This username does not exist!");
            }

            if(!$password){
                array_push($password_err_array, "You must introduce the password!");
            }elseif(!($password === $_SESSION['password'])){
                array_push($password_err_array, "This password is not corect!");
            }

        }
    }
    elseif($_SESSION['authentification_complete'] === true){
        echo 'You are already connect!';
        header("location: menu.php");  
        die;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Admin</title>
        <link rel="stylesheet" type="text/css" href="css/style_login.css?version=5">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="form_container">
            <form class="form_admin" action="index.php" method="POST" autocomplete="off">
                <h3>ADMIN-ONLY</h3>
                <p>Login</p>

                <div class = "input-container">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" value="<?php echo $username?>" placeholder="Username">
                    <label class = "error"> <?php echo $username_err_array[0]?></label>
                </div>
                
                <div class = "input-container">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" value="<?php echo $password?>" placeholder="Password">
                    <label class = "error"> <?php echo $password_err_array[0]?></label>
                </div>

                <input type="submit" name="submit" class="button">
            </form>
        </div>
    </body>
</html>

