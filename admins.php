<?php
    
    
    include("config.php");
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['authentification_complete']){
        $id = $_SESSION['id'];
        $query = "SELECT * FROM admins WHERE id = ".$id." limit 1";

        $result = mysqli_query($connect, $query);


        if($result && mysqli_num_rows($result) === 1){
            $user_data = mysqli_fetch_assoc($result);
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
    <link rel="stylesheet" type="text/css" href="css/style_admins.css?version=2">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Admin Page</title>
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
    <h4 class="title-admins">Admins</h4>
    <div class="categories-list">
            <form method="POST" action="">
                <a href="crud/add_admin.php" ><i class="fa-solid fa-circle-plus"></i>Add Admin</a>
            </form>
    </div>
    <div class="info-container">
        <table class="table-admins">
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
                <?php
                     $admin_rows = mysqli_query($connect, "SELECT * FROM admins");
                     while($row = mysqli_fetch_assoc($admin_rows)){
                        echo "<tr>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$row['first_name']."</td>";
                        echo "<td>".$row['last_name']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>
                            <a href='crud/delete_admin.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                        </td>";
                        echo "</tr>";
                     }
                ?>
        </table>
    </div>
</body>
</html>