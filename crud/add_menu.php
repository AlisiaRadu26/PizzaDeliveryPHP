<?php
    $image_src = $name = $description = $category = '';
    $image_err = $name_err = $description_err = $category_err = $price_err = [];
    $price = 0.0;

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        include("../config.php");
        
        if($_FILES['image']['full_path'] == ""){
            array_push($image_err,"You must choose an image!");
        }else{
            // Process uploaded file
            $product_image = $_FILES['image'];
            $image_data = file_get_contents($product_image["tmp_name"]);
            $image_src = $product_image['full_path'];

            $image_extension = pathinfo($product_image['full_path'], PATHINFO_EXTENSION);

            if($image_extension !== "jpg" && $image_extension !== "jpeg"  && $image_extension !== "png" && $image_extension !== "webp"){
                array_push($image_err,"The image can be only jpg, jpeg, png or webp!");
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

        if(empty(trim($_POST["description"]))){
            array_push($description_err,"You must introduce a description!");
        }
        else{
            if(!preg_match('/^[a-zA-Z\\s\\,]*$/', trim($_POST["description"]))){
                array_push($description_err,"Description can only contain letters and spaces!");
            }
            else{
                if(!empty(trim($_POST["description"])) && empty($description_err)){
                    $description = trim($_POST["description"]);
                }
            }
        }

        if(empty(trim($_POST["category"]))){
            array_push($category_err,"You must introduce a category!");
        }
        else{
            if(!preg_match('/^[A-Za-z]*$/', trim($_POST["category"]))){
                array_push($category_err,"Category can only contain letters!");
            }
            else{
                if(!empty(trim($_POST["category"])) && empty($category_err)){
                    $category = trim($_POST["category"]);
                }
            }
        }

        if(empty(trim($_POST["price"]))){
            array_push($price_err,"You must introduce a price!");
        }else{
            if(!empty(trim($_POST["price"])) && empty($price_err)){
                $price = trim($_POST["price"]);
            }
        }
        

        if(empty($image_err) && empty($name_err) && empty($description_err) && empty($category_err) && empty($price_err)){
            $insert = "INSERT INTO menu (image_data, image_type, image_src, name, description, category, price) VALUES (?, ?, ?, ?, ?, ?, ?)";

            if($stmt = mysqli_prepare($connect, $insert)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssssd", $image_data, $image_extension, $image_src, $name, $description, $category, $price);

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records updated successfully. Resdirect to landing page
                    header("location: http://localhost/pizza_delivery/menu.php");
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
    <link rel="stylesheet" type="text/css" href="../css/style_add_menu.css?version=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
    <title>Add Record</title>
</head>
<body>
    <div class="form_container">
        <form class="form_admin" action="<?php echo "add_menu.php"; ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h3>ADD RECORD</h3>
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>"/>
            <div class = "input-container">
                <input class="input-photo" type="file" name="image" id="image">
                <label class = "error"> <?php echo $image_err[0]?></label>
            </div>
                
            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="name" value="<?php echo $name?>" placeholder="Name">
                <label class = "error"> <?php echo $name_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="description" value="<?php echo $description?>" placeholder="Description">
                <label class = "error"> <?php echo $description_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="text" name="category" value="<?php echo $category?>" placeholder="Category">
                <label class = "error"> <?php echo $category_err[0]?></label>
            </div>

            <div class = "input-container">
                <i class="fa-solid fa-pen-to-square"></i>
                <input type="number" min = "0" step="0.01" name="price" value="<?php echo $price?>" placeholder="Price">
                <label class = "error"> <?php echo $price_err[0]?></label>
            </div>

            <input type="submit" name="submit" class="button">
            <a href="http://localhost/pizza_delivery/menu.php" class="btn-no">X</a>
            </form>
        </div>

</body>
</html>