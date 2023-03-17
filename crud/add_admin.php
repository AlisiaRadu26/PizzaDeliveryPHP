<?php
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+}|?><';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
    $string_pass = implode($pass); //turn the array into a string
    $hash_pass = password_hash($string_pass, PASSWORD_DEFAULT);
    return $hash_pass;
}
?>

<?php
    $username = $email = $first_name = $last_name = '';
    $username_err = $email_err = $first_name_err = $last_name_err = [];
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        include "../config.php";
        if(empty(trim($_POST["username"]))){
            array_push($username_err,"You must introduce a username!");
        }
        else{
            if(!preg_match('/^[a-zA-Z0-9_.]*$/', trim($_POST["username"]))){
                array_push($username_err,"Username can only contain letters, numbers, points and underscore!");
            }
            else{
                if(!empty(trim($_POST["username"])) && empty($username_err)){
                    $username = trim($_POST["username"]);
                }
            }
        }


        if(empty(trim($_POST["first_name"]))){
            array_push($first_name_err,"You must introduce a name!");
        }
        else{
            if(!preg_match('/^[A-Za-z]*$/', trim($_POST["first_name"]))){
                array_push($first_name_err,"Name can only contain letters!");
            }
            else{
                if(!empty(trim($_POST["first_name"])) && empty($first_name_err)){
                    $first_name = trim($_POST["first_name"]);
                }
            }
        }

        if(empty(trim($_POST["last_name"]))){
            array_push($last_name_err,"You must introduce a name!");
        }
        else{
            if(!preg_match('/^[A-Za-z]*$/', trim($_POST["last_name"]))){
                array_push($last_name_err,"Name can only contain letters!");
            }
            else{
                if(!empty(trim($_POST["last_name"])) && empty($last_name_err)){
                    $last_name = trim($_POST["last_name"]);
                }
            }
        }

        if(empty(trim($_POST["email"]))){
            array_push($email_err,"You must introduce an email!");
        }
        else{
            if(!preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', trim($_POST["email"]))){
                array_push($email_err,"Email must be like this smthg@server.com!");
            }
            else{
                if(!empty(trim($_POST["email"])) && empty($email_err)){
                    $email = trim($_POST["email"]);
                }
            }
        }
        
        if(empty($username_err) && empty($email_err) && empty($first_name_err) && empty($last_name_err)){
            $password = randomPassword();
            $insert = "INSERT INTO admins (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)";
            
            if($stmt = mysqli_prepare($connect, $insert)){
                mysqli_stmt_bind_param($stmt, "sssss", $username, $first_name, $last_name, $email, $password);

                if(mysqli_stmt_execute($stmt)){
                    header("location: http://localhost/pizza_delivery/admins.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
             
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/style_add_menu.css?version=3">
    <link rel="stylesheet" type="text/css" href="../css/style_update_delivery_boy.css?version=3">
    <link rel="stylesheet" type="text/css" href="../css/style_add_admin.css?version=3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Update Record</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "add_admin.php"; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>ADD RECORD</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="username" value="<?php echo $username;?>" placeholder="Username">
                <label class = "error"> <?php echo $username_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="first_name" value="<?php echo $first_name;?>" placeholder="First Name">
                <label class = "error"> <?php echo $first_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="last_name" value="<?php echo $last_name;?>" placeholder="Last Name">
                <label class = "error"> <?php echo $last_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="email" value="<?php echo $email;?>" placeholder="E-mail">
                <label class = "error"> <?php echo $email_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="http://localhost/pizza_delivery/admins.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>
