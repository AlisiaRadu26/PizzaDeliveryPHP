<?php
    
    
    include("config.php");
    session_start();

    $username = $first_name = $last_name = $email = $password = '';
    $username_err = $first_name_err = $last_name_err = $email_err = $password_err = [];
    if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['authentification_complete']){
        $id = $_SESSION['id'];
        $query = "SELECT * FROM admins WHERE id = ".$id." limit 1";

        $result = mysqli_query($connect, $query);


        if($result && mysqli_num_rows($result) === 1){
            
            $count = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $username_db = $row['username'];
                $first_name_db = $row['first_name'];
                $last_name_db = $row['last_name'];
                $email_db = $row['email'];
                $password_db = $row['password'];
            }

            if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])){
                $count = 2;
                $check_modify = false;
                if(!preg_match('/^[a-zA-Z0-9_.]*$/', trim($_POST["username"]))){
                    array_push($username_err,"Username can only contain letters, numbers and underscore!");
                    $username = '';
                }
                else{
                    if(!empty(trim($_POST["username"])) && empty($username_err)){
                        $username = trim($_POST["username"]);
                    }else{
                        if(empty(trim($_POST["username"])) && empty($username_err)){
                            $username = $username_db;
                        }
                    }
                }
                
                if(!preg_match('/^[A-Za-z]*$/', trim($_POST["first_name"]))){
                    array_push($first_name_err,"Name can only contain letters!");
                    $first_name = '';
                }
                else{
                    if(!empty(trim($_POST["first_name"])) && empty($first_name_err)){
                        $first_name = trim($_POST["first_name"]);
                    }else{
                        if(empty(trim($_POST["first_name"])) && empty($first_name_err)){
                            $first_name = $first_name_db;
                        }
                    }
                }

                if(!preg_match('/^[A-Za-z]*$/', trim($_POST["last_name"]))){
                    array_push($last_name_err,"Name can only contain letters!");
                    $last_name = '';
                }
                else{
                    if(!empty(trim($_POST["last_name"])) && empty($last_name_err)){
                        $last_name = trim($_POST["last_name"]);
                    }else{
                        if(empty(trim($_POST["last_name"])) && empty($last_name_err)){
                            $last_name = $last_name_db;
                        }
                    }
                }

                if(!preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', trim($_POST["email"]))){
                    array_push($email_err,"Email must be like this smthg@server.com!");
                    $email = '';
                }
                else{
                    if(!empty(trim($_POST["email"])) && empty($email_err)){
                        $email = trim($_POST["email"]);
                    }else{
                        if(empty(trim($_POST["email"])) && empty($email_err)){
                            $email = $email_db;
                        }
                    }
                }

                $hash_pass_db = false;
                if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', trim($_POST["password"])) && !empty(trim($_POST["password"]))){
                    array_push($password_err,"Password must contain at least eight characters, one special character, digit and uppercase letter!");
                    $password = '';
                }
                else{
                    if(!empty(trim($_POST["password"])) && empty($password_err)){
                        $password = trim($_POST["password"]);
                    }else{
                        if(empty(trim($_POST["password"])) && empty($password_err)){
                            $password = $password_db;
                            $hash_pass_db = true;
                        }
                    }
                }

                if(empty($username_err) && empty($email_err) && empty($first_name_err) && empty($last_name_err) && empty($password_err)){
                    if($hash_pass_db === false){
                        $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    }else{
                        $hash_pass = $password;
                    }
                    $update = "UPDATE admins SET username = ?, first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
        
                    if($stmt = mysqli_prepare($connect, $update)){
                        mysqli_stmt_bind_param($stmt, "sssssi", $username, $first_name, $last_name, $email, $hash_pass, $id);
        
                        if(mysqli_stmt_execute($stmt)){
                            session_start();
                            $_SESSION = array();
                            session_destroy();
                            header("location: https://pizzadelivery.herokuapp.com/index.php");
                            exit();
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                     
                }
        
            }
        }
        else{
            header("Location: index.php");
            die;
        }
    }else{
        //redirect to login
        // echo 'You must login first';
        header("Location: index.php");
        die;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="css/style_index.css?version=5">
    <link rel="stylesheet" type="text/css" href="css/style_settings.css?version=5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Settings Page</title>
</head>
<body>
    <ul class="menu-container-top">
        <li>
            <a href="logout.php">
                <i class="fa-solid fa-circle-user"></i>
                Logout <?php echo $first_name_db?>
            </a>
        </li> 
    </ul>
    <ul class="menu-container-left">

        <a href="menu.php"><i class="fa-solid fa-utensils"></i></a>
        <li><a href="menu.php">MENU</a></li>

        <a href="orders.php"><i class="fa-solid fa-cart-shopping"></i></a>
        <li><a href="orders.php">ORDERS</a></li>

        <a href="delivery_boy.php"><i class="fa-solid fa-car"></i></a>
        <li><a href="delivery_boy.php">DELIVERY BOY</a></li>

        <a href="users.php"><i class="fa-solid fa-users"></i></a>
        <li><a href="users.php">USERS</a></li>

        <a href="admins.php"><i class="fa-solid fa-users-gear"></i></a>
        <li><a href="admins.php">ADMINS</a></li>

        <a href="settings.php"><i class="fa-solid fa-gears"></i></a>
        <li><a href="settings.php">SETTINGS</a></li>
    </ul>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "settings.php"; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>UPDATE Your Data</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="username" value="<?php if($count===1){echo $username_db;}elseif($count===2){echo $username;}?>" placeholder="Username">
                <label class = "error"> <?php echo $username_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="first_name" value="<?php if($count===1){echo $first_name_db;}elseif($count===2){echo $first_name;}?>" placeholder="First Name">
                <label class = "error"> <?php echo $first_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="last_name" value="<?php if($count===1){echo $last_name_db;}elseif($count===2){echo $last_name;}?>" placeholder="Last Name">
                <label class = "error"> <?php echo $last_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="email" value="<?php if($count===1){echo $email_db;}elseif($count===2){echo $email;}?>" placeholder="E-mail">
                <label class = "error"> <?php echo $email_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="password" name="password" value="<?php echo $password;?>" placeholder="Password">
                <label class = "error"> <?php echo $password_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            </form>
        </div>
</div>
</body>
</html>
