<?php

require "dbConnect.php";
$db = get_db();

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: sort.php");
    exit;
}

$username = $password = $password2 = "";
$username_err = $password_err = $password2_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
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
    
    if(empty($username_err) && empty($password_err) && empty($password2_err)){
        $param_username = trim($_POST["username"]);
        $param_pass = trim($_POST["username"]);
        $stmt = $db->prepare("SELECT username FROM persons WHERE username=:username");
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $username_err = "Username is already taken.";
        } else{
            $stmt = $db->prepare("INSERT INTO persons (username, password) VALUES (:username, :password)");
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_pass, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $db->prepare("SELECT userid FROM persons WHERE username=:username");
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $id = row['userid'];

            $stmt = $db->prepare("SELECT workid FROM works");
            $stmt->execute();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $statement2 = $db->prepare("INSERT INTO selectedworks (userid, workid, isincluded) VALUES (:id, :workid, '0')");
                $statement2->bindValue(':id', $id, PDO::PARAM_INT);
                $statement2->bindValue(':workid', $row['charid'], PDO::PARAM_INT);
                $statement2->execute();
            }

            $stmt = $db->prepare("SELECT charid FROM characters");
            $stmt->execute();
            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {
                $statement2 = $db->prepare("INSERT INTO selectedworks (userid, workid, isincluded, userRank) VALUES (:id, :workid, '0', NULL)");
                $statement2->bindValue(':id', $id, PDO::PARAM_INT);
                $statement2->bindValue(':workid', $row['charid'], PDO::PARAM_INT);
                $statement2->execute();
            }

            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;                            
            header("location: sort.php");

        }
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
        <h2>Create Account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div >
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>    
            <div >
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
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>