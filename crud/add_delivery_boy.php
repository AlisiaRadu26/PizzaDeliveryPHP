
<?php
    $username = $email = $name = $phone_number = '';
    $username_err = $email_err = $name_err = $phone_number_err = $status_err = [];
    $status = 0;
    
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

        if(empty(trim($_POST["name"]))){
            array_push($name_err,"You must introduce a name!");
        }
        else{
            if(!preg_match('/^[A-Za-z\s]*$/', trim($_POST["name"]))){
                array_push($name_err,"Name can only contain letters and spaces!");
            }
            else{
                if(!empty(trim($_POST["name"])) && empty($name_err)){
                    $name = trim($_POST["name"]);
                }
            }
        }

        if(empty(trim($_POST["phone_number"]))){
            array_push($phone_number_err,"You must introduce a phone number!");
        }
        else{
            if(!preg_match('/^[\+][(]?[0-9]{2,3}[)]?[\s][0-9]{9}$/', trim($_POST["phone_number"]))){
                array_push($phone_number_err,"Phone number must be like this +40123456789/+40 123456789/+(40) 123456789!");
            }
            else{
                if(!empty(trim($_POST["phone_number"])) && empty($phone_number_err)){
                    $phone_number = trim($_POST["phone_number"]);
                }
            }
        }

        if(trim($_POST["status"]) === "choose_status"){
            array_push($status_err,"You must choose a status!");
        }
        else{
            if(trim($_POST["status"]) === "online"){
                $status = 1;
            }else{
                if(trim($_POST["status"]) === "offline"){
                    $status = 0;
                }
            }
        }
        
        if(empty($username_err) && empty($email_err) && empty($name_err) && empty($phone_number_err) && empty($status_err)){
        
            $insert = "INSERT INTO delivery_boy (username, email, fullname, phone_number, status) VALUES (?, ?, ?, ?, ?)";

            if($stmt = mysqli_prepare($connect, $insert)){
                mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $name, $phone_number, $status);

                if(mysqli_stmt_execute($stmt)){
                    header("location: https://pizzadelivery.herokuapp.com/delivery_boy.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Update Record</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "add_delivery_boy.php"; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>ADD RECORD</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="username" value="<?php echo $username;?>" placeholder="Username">
                <label class = "error"> <?php echo $username_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="email" value="<?php echo $email;?>" placeholder="E-mail">
                <label class = "error"> <?php echo $email_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="name" value="<?php echo $name;?>" placeholder="Name">
                <label class = "error"> <?php echo $name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="phone_number" value="<?php echo $phone_number;?>" placeholder="Phone Number">
                <label class = "error"> <?php echo $phone_number_err[0]?></label>
            </div>

            <div class = "input-container">
                <select id="status" name="status">
                    <option value="choose_status">Choose Status</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
                <label class = "error"> <?php echo $status_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="https://pizzadelivery.herokuapp.com/delivery_boy.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>
