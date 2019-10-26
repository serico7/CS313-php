<?php

require "dbConnect.php";
$db = get_db();

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: sort.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = "";
 
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
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT userid, username, password FROM persons WHERE username=:username";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["userid"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if($password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: sort.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
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
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    <a href="keiki.php">Create an Account</a>
    <h1 class="title">TohoRank v2.0</h1>
    <p class="title">This is a site for saving and editing a ranked list of characters from Touhou Project with consideration for which works you are familiar with. This is inspired by the site <a href="https://tohosort.frelia.my">Tohosort</a>. However, I was not fond of being unable to conveniently change the results of the list after it was generated. The art used is by <a href="https://www.pixiv.net/member.php?id=4920496">Dairi</a>. After you create an account, select the works that you are familiar with (or just pick whatever) and update to add them to the list of characters. You can then drag and drop the names in the order you'd like. If you'd like to see art of a character, click the X next to their name. You can save to continue sorting later, which I reccomend doing often to prevent the site from timing out. You can also generate a chart to display the order in a more shareable format. </p>
</body>
</html>