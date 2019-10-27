<?php

require "dbConnect.php";
$db = get_db();

session_start();

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: login.php");
    exit;
}

$username_err = $password_err = $password2_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["password2"]))){
        $password2_err = "Please reenter your password.";
    } else{
        $password2 = trim($_POST["password2"]);
    }

    if(trim($_POST["password"]) != trim($_POST["password2"])){
        $password2_err = "Please ensure the passwords are the same";
    } else{
        $password2 = trim($_POST["password2"]);
    }
    
    if(empty($password_err) && empty($password2_err)){
        $id = $_SESSION["id"];
        
        $stmt = $db->prepare("DELETE FROM rankedchars WHERE userid=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $stmt = $db->prepare("DELETE FROM selectedworks WHERE userid=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $stmt = $db->prepare("DELETE FROM persons WHERE userid=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION["loggedin"] = false;
        header("location: login.php");
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Account</title>
</head>
<body>
    <div class="wrapper">
        <h2>Delete Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">    
            <p> If you are sure you want to do this, enter and confirm your password. The username will be free to be used in a new account.</p>
            <div>
                <label>Password</label>
                <input type="password" name="password" >
                <span><?php echo $password_err; ?></span>
            </div>
            <div >
                <label>Reenter Password</label>
                <input type="password" name="password2" >
                <span><?php echo $password2_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Delete Account">
            </div>
        </form>
    </div>
    <a href="sort.php">Back to Sort</a>
</body>
</html>