
<?php
    $image_data = $image_type = $image_src = $name = $description = $category = '';
    $image_err = $name_err = $description_err = $category_err = $price_err = [];
    $price = 0.0;

    if(isset($_GET['id']) && !empty($_GET)){
        include("../config.php");

        $id = intval(trim($_GET['id']));

        $sql = "SELECT * from menu WHERE id = ".$id;
        $res = mysqli_query($connect, $sql);
        $numRows = mysqli_num_rows($res);

        $count = 1;

        while ($row = mysqli_fetch_assoc($res)) {
            $image_data_db = $row['image_data'];
            $image_type_db = $row['image_type'];
            $image_src_db = $row['image_src'];
            $name_db = $row['name'];
            $description_db = $row['description'];
            $category_db = $row['category'];
            $price_db = doubleval($row['price']);
        }
    }
    
    if(isset($_POST['id']) && !empty($_POST)){
        $count = 2;
        if($_FILES['image']['full_path'] == ""){
            $image_data = $image_data_db;
            $image_src = $image_src_db;
            $image_extension = $image_type_db;
        }else{
            // Process uploaded file
            $product_image = $_FILES['image'];

            $image_data = file_get_contents($product_image["tmp_name"]);
            $image_src = $product_image['full_path'];

            $image_extension = pathinfo($product_image['full_path'], PATHINFO_EXTENSION);

            if($image_extension !== "jpg" && $image_extension !== "jpeg" && $image_extension !== "png" && $image_extension !== "webp"){
                array_push($image_err,"The image can be only jpg, jpeg, png or webp!");
            }
        }

        if(!preg_match('/^[A-Za-z\s]*$/', trim($_POST["name"]))){
            array_push($name_err,"Name can only contain letters and spaces!");
            $name = '';
        }
        else{
            if(!empty(trim($_POST["name"])) && empty($name_err)){
                $name = trim($_POST["name"]);
            }else{
                if(empty(trim($_POST["name"])) && empty($name_err)){
                    $name = $name_db;
                }
            }
        }

        if(!preg_match('/^[a-zA-Z\\s\\,]*$/', trim($_POST["description"]))){
            array_push($description_err,"Description can only contain letters, comma and spaces!");
            $description = '';
        }
        else{
            if(!empty(trim($_POST["description"])) && empty($description_err)){
                $description = trim($_POST["description"]);
            }else{
                if(empty(trim($_POST["description"])) && empty($description_err)){
                    $description = $description_db;
                }
            }
        }

        if(!preg_match('/^[a-zA-Z]*$/', trim($_POST["category"]))){
            array_push($category_err,"Category can only contain letters!");
            $category = '';
        }
        else{
            if(!empty(trim($_POST["category"])) && empty($category_err)){
                $category = trim($_POST["category"]);
            }else{
                if(empty(trim($_POST["category"])) && empty($category_err)){
                    $category = $category_db;
                }
            }
        }

        if(!empty(trim($_POST["price"])) && empty($price_err)){
            $price = trim($_POST["price"]);
        }else{
            if(empty(trim($_POST["price"])) && empty($price_err)){
                $price = ($price_db);
            }
        }

        if(empty($image_err) && empty($name_err) && empty($description_err) && empty($category_err) && empty($price_err)){
            $update = "UPDATE menu SET image_data = ?, image_type = ?, image_src = ?, name = ?, description = ?, category = ?, price = ? WHERE id = ?";
            
            if($stmt = mysqli_prepare($connect, $update)){
                mysqli_stmt_bind_param($stmt, "ssssssdi", $image_data, $image_extension, $image_src, $name, $description, $category, $price, $id);

                if(mysqli_stmt_execute($stmt)){
                    header("location: https://pizzadelivery.herokuapp.com/menu.php");
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
    <link rel="stylesheet" type="text/css" href="../css/style_update_menu.css?version=8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Update Record</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "update_menu.php?id=".$_GET['id']; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>UPDATE RECORD</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
            <div class = "input-container">
                <input class="input-photo" type="file" name="image" id="image">
                <label class = "error"> <?php echo $image_err[0]?></label>
            </div>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="name" value="<?php if($count===1){echo $name_db;}elseif($count===2){echo $name;}?>" placeholder="Name">
                <label class = "error"> <?php echo $name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="description" value="<?php if($count===1){echo $description_db;}elseif($count===2){echo $description;}?>" placeholder="Description">
                <label class = "error"> <?php echo $description_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="category" value="<?php if($count===1){echo $category_db;}elseif($count===2){echo $category;}?>" placeholder="Category">
                <label class = "error"> <?php echo $category_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="number" min = "0" step="0.01" name="price" value="<?php if($count===1){echo $price_db;}elseif($count===2){echo $price;}?>" placeholder="Price">
                <label class = "error"> <?php echo $price_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="https://pizzadelivery.herokuapp.com/menu.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>
