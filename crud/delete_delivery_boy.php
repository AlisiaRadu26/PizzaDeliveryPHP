<?php
if(isset($_POST["id"]) && !empty($_POST["id"])){
    include "../config.php";

    $sql = "DELETE FROM delivery_boy WHERE id = ?";

    var_dump(mysqli_prepare($connect, $sql));
    if($stmt = mysqli_prepare($connect, $sql)){
        $param_id = trim($_POST["id"]);
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        if(mysqli_stmt_execute($stmt)){
            header("location: http://localhost/pizza_delivery/delivery_boy.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($connect);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="../css/style_delete.css?version=1">
    <script src="https://kit.fontawesome.com/258a11fd7c.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <div class="first-element">
            <i class="fa-solid fa-trash-can fa-2xl"></i>
        </div>
        
        <div class="second-element">
            <h2 class="delete-title">Delete Record</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="content">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Are you sure you want to delete this record?</p>
                        <p>This action can not be undone!</p>
                        <p class="buttons-container">
                            <input type="submit" value="Yes" class="btn-yes">
                            <a href="http://localhost/pizza_delivery/delivery_boy.php" class="btn-no">No</a>
                        </p>
                    </div>
                </form>
        </div>
    </div>
</body>
</html>