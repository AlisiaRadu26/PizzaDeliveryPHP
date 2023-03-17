<?php
    $username = $status = $payment_type = '';
    $username_err = $total_err = $status_err = $payment_type_err = $date_err = $time_err =[];
    $total = 0.0;
    $status_array = array('Processing', 'Confirmed', 'Cancelled', 'Completed', 'processing', 'confirmed', 'cancelled', 'completed');

    if(isset($_GET['id']) && !empty($_GET)){
        include("../config.php");
        $id = intval(trim($_GET['id']));
        $count=1;

        $sql = "SELECT * from orders WHERE id = ".$id;
        $res = mysqli_query($connect, $sql);
        $numRows = mysqli_num_rows($res);

        while ($row = mysqli_fetch_assoc($res)) {
            
            $username_db = $row['username'];
            $total_db = doubleval($row['total']);
            $status_db = $row['status'];
            $payment_type_db = $row['payment_type'];
            $date_db = $row['date'];
            $time_db = $row['time'];
        }
    }

    if(isset($_POST['id']) && !empty($_POST)){
        $count = 2;
        if(!preg_match('/^[a-zA-Z0-9_.]*$/', trim($_POST["username"]))){
            array_push($username_err,"Username can only contain letters, numbers, points and underscore!");
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

        if(!empty(trim($_POST["total"])) && empty($total_err)){
            $total = trim($_POST["total"]);
        }else{
            if(empty(trim($_POST["total"])) && empty($total_err)){
                $total = $total_db;
            }
        }

        if(!in_array(trim($_POST["status"]), $status_array) && !empty(trim($_POST["status"]))){
            array_push($status_err,"Status be only 'Processing', 'Confirmed', 'Cancelled', 'Completed'!");
        }
        else{
            if(!empty(trim($_POST["status"])) && empty($status_err)){
                $status = ucfirst(trim($_POST["status"]));
            }else{
                if(empty(trim($_POST["status"])) && empty($status_err)){
                    $status = $status_db;
                }
            }
        }

        if(!preg_match('/^[a-zA-Z\s]*$/', trim($_POST["payment_type"]))){
            array_push($payment_type_err,"Payment type can only contain letters!");
            $payment_type = '';
        }
        else{
            if(!empty(trim($_POST["payment_type"])) && empty($payment_type_err)){
                $payment_type = trim($_POST["payment_type"]);
            }else{
                if(empty(trim($_POST["payment_type"])) && empty($payment_type_err)){
                    $payment_type = $payment_type_db;
                }
            }
        }
        
        if(!empty(trim($_POST["date"])) && empty($date_err)){
            $date = trim($_POST["date"]);
        }else{
            if(empty(trim($_POST["date"])) && empty($date_err)){
                $date = $date_db;
            }
        }

        if(!empty(trim($_POST["time"])) && empty($time_err)){
            $time = trim($_POST["time"]);
        }else{
            if(empty(trim($_POST["time"])) && empty($time_err)){
                $time = $time_db;
            }
        }

        if(empty($username_err) && empty($total_err) && empty($status_err) && empty($payment_type_err) && empty($date_err) && empty($time_err)){
            
            $update = "UPDATE orders SET username = ?, total = ?, status = ?, payment_type = ?, date = ?, time = ? WHERE id = ?";
            
            if($stmt = mysqli_prepare($connect, $update)){
                mysqli_stmt_bind_param($stmt, "sdssssi", $username, $total, $status, $payment_type, $date, $time, $id);

                if(mysqli_stmt_execute($stmt)){
                    header("location: https://pizzadelivery.herokuapp.com/orders.php");
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
    <link rel="stylesheet" type="text/css" href="../css/style_update_orders.css?version=5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Update Record</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "update_orders.php?id=".$_GET['id']; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>UPDATE RECORD</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="username" value="<?php if($count === 1 ){echo $username_db;}elseif($count === 2){echo $username;}?>" placeholder="Username">
                <label class = "error"> <?php echo $username_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="number" min = "0" step="0.01" name="total" value="<?php if($count === 1 ){echo $total_db;}elseif($count === 2){echo $total;}?>" placeholder="Total">
                <label class = "error"> <?php echo $total_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="status" value="<?php if($count === 1 ){echo $status_db;}elseif($count === 2){echo $status;}?>" placeholder="Status">
                <label class = "error"> <?php echo $status_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="payment_type" value="<?php if($count === 1 ){echo $payment_type_db;}elseif($count === 2){echo $payment_type;} echo $payment_type?>" placeholder="Payment Type">
                <label class = "error"> <?php echo $payment_type_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="date" name="date" value="<?php if($count === 1 ){echo $date_db;}elseif($count === 2){echo $date;} echo $date?>" placeholder="Date">
                <label class = "error"> <?php echo $date_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="time" name="time" value="<?php if($count === 1 ){echo $time_db;}elseif($count === 2){echo $time;} echo $time?>" placeholder="Time">
                <label class = "error"> <?php echo $time_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="https://pizzadelivery.herokuapp.com/orders.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>
