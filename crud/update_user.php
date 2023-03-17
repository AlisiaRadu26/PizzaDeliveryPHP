<?php
    $first_name = $last_name = $email = $phone_number = '';
    $first_name_err = $last_name_err = $email_err = $phone_number_err =[];

    if(isset($_GET['id']) && !empty($_GET)){
        include("../config.php");
        $id = intval(trim($_GET['id']));
        $count=1;

        $sql = "SELECT * from users WHERE id = ".$id;
        $res = mysqli_query($connect, $sql);
        $numRows = mysqli_num_rows($res);

        while ($row = mysqli_fetch_assoc($res)) {
            
            $first_name_db = $row['first_name'];
            $last_name_db = $row['last_name'];
            $email_db = $row['email'];
            $phone_number_db = $row['phone_number'];
        }
    }

    if(isset($_POST['id']) && !empty($_POST)){
        $count = 2;
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

        if(!preg_match('/^[\+][(]?[0-9]{2,3}[)]?[\s][0-9]{9}$/', trim($_POST["phone_number"]))){
            array_push($phone_number_err,"Phone number must be like this +40 123456789/+(40) 123456789!");
            $phone_number = '';
        }
        else{
            if(!empty(trim($_POST["phone_number"])) && empty($phone_number_err)){
                $phone_number = trim($_POST["phone_number"]);
            }else{
                if(empty(trim($_POST["phone_number"])) && empty($phone_number_err)){
                    $phone_number = $phone_number_db;
                }
            }
        }

        if(empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($phone_number_err)){
            
            $update = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ? WHERE id = ?";
            
            if($stmt = mysqli_prepare($connect, $update)){
                mysqli_stmt_bind_param($stmt, "ssssi", $first_name, $last_name, $email, $phone_number, $id);

                if(mysqli_stmt_execute($stmt)){
                    header("location: https://pizzadelivery.herokuapp.com/users.php");
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
    <link rel="stylesheet" type="text/css" href="../css/style_update_menu.css?version=4">
    <link rel="stylesheet" type="text/css" href="../css/style_update_user.css?version=3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Update Record</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "update_user.php?id=".$_GET['id']; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>UPDATE RECORD</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="first_name" value="<?php if($count === 1 ){echo $first_name_db;}elseif($count === 2){echo $first_name;}?>" placeholder="First Name">
                <label class = "error"> <?php echo $first_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="last_name" value="<?php if($count === 1 ){echo $last_name_db;}elseif($count === 2){echo $last_name;}?>" placeholder="Last Name">
                <label class = "error"> <?php echo $last_name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="email" value="<?php if($count === 1 ){echo $email_db;}elseif($count === 2){echo $email;}?>" placeholder="Email">
                <label class = "error"> <?php echo $email_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="phone_number" value="<?php if($count === 1 ){echo $phone_number_db;}elseif($count === 2){echo $phone_number;}?>" placeholder="Phone Number">
                <label class = "error"> <?php echo $phone_number_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="https://pizzadelivery.herokuapp.com/users.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>
