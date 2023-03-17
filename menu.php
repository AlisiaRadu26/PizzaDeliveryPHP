<?php
    include("config.php");
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['password']) && $_SESSION['authentification_complete']){
        $id = $_SESSION['id'];
        $filter = '';

        $admin_rows = mysqli_query($connect, "SELECT * FROM admins WHERE id = ".$id." limit 1");
     
        if($admin_rows && mysqli_num_rows($admin_rows) === 1){
            $admin_data = mysqli_fetch_assoc($admin_rows);
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
    <link rel="stylesheet" type="text/css" href="css/style_index.css?version=18">
    <link rel="stylesheet" type="text/css" href="css/style_menu.css?version=18">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Menu Page</title>
</head>
<body>
    <ul class="menu-container-top">
        <li>
            <a href="logout.php">
                <i class="fa-solid fa-circle-user"></i>
                Logout <?php echo $admin_data['first_name']?>
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
    <h4 class="title-menu"> Menu </h4>
    <div class="categories-list">
        <form method="POST" action="">
            <button name="filter" value="all_products"> All Products </button>
            <button name="filter" value="pizza"> Pizza </button>
            <button name="filter" value="sweet"> Sweets </button>
            <a href="crud/add_menu.php" ><i class="fa-solid fa-circle-plus"></i>Add Product</a>
        </form>
    </div>
    <?php 
    if($filter === 'all_products' || $filter === ''):?>
        <div class="info-container">
        <table class="table-menu">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
                <?php
                    $menu_rows = mysqli_query($connect, "SELECT * FROM menu");
                    while($row = mysqli_fetch_assoc($menu_rows)):
                        echo "<tr>";
                        echo "<td><img src='images/".$row['image_src']."'/></td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['description']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['price']."</td>";
                        echo "<td>
                            <a href='crud/delete_menu.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                            <a href='crud/update_menu.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                        </td>";
                    ?>
                <?php 
                    echo "</tr>";
                    endwhile;
                ?>
        </table>
    </div>
    <?php 
    elseif($filter === 'pizza'):?>
        <div class="info-container">
    
        <table class="table-menu">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
                <?php
                    $menu_rows = mysqli_query($connect, "SELECT * FROM menu WHERE category = '".$filter."'");
                    while($row = mysqli_fetch_assoc($menu_rows)):
                        echo "<tr>";
                        echo "<td><img src='images/".$row['image_src']."'/></td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['description']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['price']."</td>";
                        echo "<td>
                                <a href='crud/delete_menu.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                                <a href='crud/update_menu.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                            </td>";
                    ?>
                <?php 
                    echo "</tr>";
                    endwhile;
                ?>
        </table>
    </div>
    <?php 
    elseif($filter === 'sweet'):?>
        <div class="info-container">
        <table class="table-menu">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
                $menu_rows = mysqli_query($connect, "SELECT * FROM menu WHERE category = '".$filter."'");
                while($row = mysqli_fetch_assoc($menu_rows)):
                    echo "<tr>";
                    echo "<td><img src='data:image/".$row["image_type"].";base64,".base64_encode($row["image_data"])."'></td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['description']."</td>";
                    echo "<td>".$row['category']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td>
                        <a href='crud/delete_menu.php?id=".$row['id']."'><span class='fa-solid fa-trash-can'></span></a>
                        <a href='crud/update_menu.php?id=".$row['id']."'><span class='fa-solid fa-pen-to-square'></span></a>
                    </td>";
                ?>
                <?php 
                    echo "</tr>";
                    endwhile;
                ?>
        </table>
        </div>
    <?php endif; ?>
</body>
</html>