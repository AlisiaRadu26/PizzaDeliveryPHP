<?php
    
    
    include("config.php");
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['authentification_complete']){
        $id = $_SESSION['id'];
        $query = "SELECT * FROM admins WHERE id = ".$id." limit 1";
        $filter = '';

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
    <link rel="stylesheet" type="text/css" href="css/style_index.css?version=8">
    <link rel="stylesheet" type="text/css" href="css/style_orders.css?version=8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Orders Page</title>
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
    <h4 class="title-orders"> Orders </h4>
    <div class="categories-list">
        <form method="POST" action="">
            <button name="filter" value="all_orders"> All Orders </button>
            <button name="filter" value="Processing"> Processing Orders </button>
            <button name="filter" value="Confirmed"> Confirmed Orders </button>
            <button name="filter" value="Completed"> Completed Orders </button>
            <button name="filter" value="Cancelled" class="last-button"> Cancelled Orders </button>
        </form>
    </div>
    <?php if($filter === 'all_orders' || $filter === ''):?>
        <div class="info-container">
            <table class="table-orders">
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
                <?php
                     $orders_rows = mysqli_query($connect, "SELECT * FROM orders");
                     while($row = mysqli_fetch_assoc($orders_rows)){

                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['total']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "<td>".$row['payment_type']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td>".$row['time']."</td>";
                        echo "<td>
                            <a href='crud/delete_orders.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_orders.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
            </table>
        </div>
    <?php elseif($filter === 'Processing'): ?>
        <div class="info-container">
        <table class="table-orders">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            <?php
                     $orders_rows = mysqli_query($connect, "SELECT * FROM orders WHERE status = 'Processing'");
                     while($row = mysqli_fetch_assoc($orders_rows)){

                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['total']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "<td>".$row['payment_type']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td>".$row['time']."</td>";
                        echo "<td>
                            <a href='crud/delete_orders.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_orders.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
    <?php elseif($filter === 'Confirmed'): ?>
        <div class="info-container">
        <table class="table-orders">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
                <?php
                     $orders_rows = mysqli_query($connect, "SELECT * FROM orders WHERE status = 'Confirmed'");
                     while($row = mysqli_fetch_assoc($orders_rows)){

                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['total']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "<td>".$row['payment_type']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td>".$row['time']."</td>";
                        echo "<td>
                            <a href='crud/delete_orders.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_orders.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
    <?php elseif($filter === 'Completed'): ?>
        <div class="info-container">
        <table class="table-orders">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
                <?php
                     $orders_rows = mysqli_query($connect, "SELECT * FROM orders WHERE status = 'Completed'");
                     while($row = mysqli_fetch_assoc($orders_rows)){

                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['total']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "<td>".$row['payment_type']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td>".$row['time']."</td>";
                        echo "<td>
                            <a href='crud/delete_orders.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_orders.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
    <?php elseif($filter === 'Cancelled'): ?>
        <div class="info-container">
        <table class="table-orders">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
                <?php
                     $orders_rows = mysqli_query($connect, "SELECT * FROM orders WHERE status = 'Cancelled'");
                     while($row = mysqli_fetch_assoc($orders_rows)){

                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['total']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "<td>".$row['payment_type']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td>".$row['time']."</td>";
                        echo "<td>
                            <a href='crud/delete_orders.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_orders.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
    <?php endif; ?>
</body>
</html>