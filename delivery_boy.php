<?php
    
    
    include("config.php");
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['authentification_complete']){
        $id = $_SESSION['id'];
        $filter = '';
        $query = "SELECT * FROM admins WHERE id = ".$id." limit 1";

        $result = mysqli_query($connect, $query);


        if($result && mysqli_num_rows($result) === 1){
            $user_data = mysqli_fetch_assoc($result);
        }
        else{
            header("Location: index.php");
            die;
        }
        if(isset($_POST['filter'])){
            $filter = $_POST['filter'];
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
    <link rel="stylesheet" type="text/css" href="css/style_index.css?version=9">
    <link rel="stylesheet" type="text/css" href="css/style_delivery_boy.css?version=13">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Delivery Boy Page</title>
</head>
<body>
    <ul class="menu-container-top">
        <li>
            <a href="logout.php">
                <i class="fa-solid fa-circle-user"></i>
                Logout <?php echo $user_data['first_name']?>
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

    <h4 class="title-delivery-boy"> Delivery Boys</h4>
    <div class="categories-list">
        <form method="POST" action="">
            <button name="filter" value="all_delivery_boys"> All Delivery Boys </button>
            <button name="filter" value="available_delivery_boys"> Available Delivery Boys</button>
            <a href="crud/add_delivery_boy.php" ><i class="fa-solid fa-circle-plus"></i>Add Delivery Boy</a>
        </form>
    </div>
    <?php if($filter === '' || $filter === "all_delivery_boys"):?>
    <div class="info-container">
        <table class="table-delivery-boy">
            <tr>
                <th class='username'>Username</th>
                <th>Email</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                <?php
                     $delivery_boy_rows = mysqli_query($connect, "SELECT * FROM delivery_boy");
                     while($row = mysqli_fetch_assoc($delivery_boy_rows)){
                        echo "<tr>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['fullname']."</td>";
                        echo "<td>".$row['phone_number']."</td>";
                        if($row['status'] == 1){
                            echo "<td class='on_duty'><p></p><span>ON</span></td>";
                        }elseif($row['status'] == 0){
                            echo "<td class='off_duty'>OFF<p></p></td>";
                        }
                        echo "<td>
                            <a href='crud/delete_delivery_boy.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_delivery_boy.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
    <?php elseif($filter === "available_delivery_boys"):?>
    <div class="info-container">
        <table class="table-delivery-boy">
            <tr>
                <th class='username'>Username</th>
                <th>Email</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                <?php
                     $delivery_boy_rows = mysqli_query($connect, "SELECT * FROM delivery_boy WHERE status = 1");
                     while($row = mysqli_fetch_assoc($delivery_boy_rows)){
                        echo "<tr>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['fullname']."</td>";
                        echo "<td>".$row['phone_number']."</td>";
                        if($row['status'] == 1){
                            echo "<td class='on_duty'><p></p><span>ON</span></td>";
                        }elseif($row['status'] == 0){
                            echo "<td class='off_duty'>OFF<p></p></td>";
                        }
                        echo "<td>
                            <a href='crud/delete_delivery_boy.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_delivery_boy.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
    <?php endif;?>
</body>
</html>
