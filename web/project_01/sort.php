<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$id=$_SESSION["id"];
require "dbConnect.php";
$db = get_db();

if(isset($_POST['save']))
{
	$order = $_POST["order"];
	for($i = 0; $i < $_SESSION["sortsize"]; $i++)
	{
		$statement = $db->prepare("UPDATE rankedchars SET rank=:rank WHERE userid=:id AND charid=:charid");
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->bindValue(':rank', ($i + 1), PDO::PARAM_INT);
		$statement->bindValue(':charid', $order[$i], PDO::PARAM_INT);
		$statement->execute();
	}
} 



?>
<!DOCTYPE html>
<html>
<head>
	<title>Sort</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="jquery.js"></script>
</head>

<body>
<form method="post" action="sort.php">
<ul id="sortable" >
<?php
$statement = $db->prepare("SELECT why.charid, exs.name, exs.art FROM rankedchars AS why JOIN characters AS exs ON why.charid = exs.charid WHERE userid=:id AND isIncluded ORDER BY userRank, why.charid");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$count = 0;
while ($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['name'];
	$art = $row['art'];
	$charid = $row['charid'];
	echo "<li id='$charid'> $name (<a href='$art'>X</a>)</li>";
	$count++;
}
    $_SESSION["sortsize"] = $count;
?>
<input id='order' type='hidden' value='' name='order'></input>
<button id="save" type="submit" name="save"> Save </button>
</form>

<br/>
<form method="post" action="generate.php">
<input id='order2' type='hidden' value='' name='order2'></input>
Number of images: <select class="selector" name="Imagenum">
    <option value="1">Five</option>
    <option value="2">Ten</option>
    <option value="3">Fifteen</option>
    <option value="4">Twenty</option>
</select>
<button id="generate" type="submit"> Generate </button>
</form>

<?php
$statement = $db->prepare("SELECT why.workid, why.isincluded, exs.name FROM selectedworks AS why JOIN works AS exs ON why.workid = exs.workid WHERE userid=:id ORDER BY why.workid");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
while ($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['name'];
	$aBool = $row['isincluded'];
	$workid = $row['workid'];
	echo "<input id='$workid' type='checkbox' name='$name' " . ($aBool ? 'checked' : '') . "/> $name <br>";
}
?>
<input id='count' type='hidden' value='' name='count'></input>
<input id='true' type='hidden' value='' name='true'></input>
<button> 
</form>


</body>
</html>