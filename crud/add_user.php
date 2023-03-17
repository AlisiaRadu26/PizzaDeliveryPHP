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
    $first_name = $last_name = $email = $phone_number = '';
    $first_name_err = $last_name_err = $email_err = $phone_number_err =[];

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        include "../config.php";
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

        if(empty(trim($_POST["phone_number"]))){
            array_push($phone_number_err,"You must introduce a phone number!");
        }
        else{ 
            if(!preg_match('/^[\+][(]?[0-9]{2,3}[)]?[\s][0-9]{9}$/', trim($_POST["phone_number"]))){
                array_push($phone_number_err,"Phone number must be like this +40 123456789/+(40) 123456789!");
            }
            else{
                if(!empty(trim($_POST["phone_number"])) && empty($phone_number_err)){
                    $phone_number = trim($_POST["phone_number"]);
                }
            }
        }

        if(empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($phone_number_err)){
            $password = randomPassword();
            $insert = "INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES (?, ?, ?, ?, ?)";
            
            if($stmt = mysqli_prepare($connect, $insert)){
                mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $phone_number, $password);

                if(mysqli_stmt_execute($stmt)){
                    header("location: http://localhost/pizza_delivery/users.php");
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
    <link rel="stylesheet" type="text/css" href="../css/style_add_menu.css?version=4">
    <link rel="stylesheet" type="text/css" href="../css/style_add_user.css?version=4">
    <link rel="stylesheet" type="text/css" href="../css/style_update_delivery_boy.css?version=4">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Add User</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "add_user.php"; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>ADD RECORD</h3>
            <!-- <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/> -->
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="first_name" autocomplete="off" value="<?php echo $first_name;?>" placeholder="First Name">
                <label class = "error"> <?php echo $first_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="last_name" autocomplete="off" value="<?php echo $last_name;?>" placeholder="Last Name">
                <label class = "error"> <?php echo $last_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="email" autocomplete="off" value="<?php echo $email;?>" placeholder="Email">
                <label class = "error"> <?php echo $email_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="phone_number" autocomplete="off" value="<?php echo $phone_number;?>" placeholder="Phone Number">
                <label class = "error"> <?php echo $phone_number_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="http://localhost/pizza_delivery/users.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>