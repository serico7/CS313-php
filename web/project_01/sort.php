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
	$ids = explode( ',', $_POST["order"] );
	for($i = 0; $i < $_POST["sortsize"]; $i++)
	{
		$statement = $db->prepare("UPDATE rankedchars SET userRank=:rank WHERE userid=:id AND charid=:charid");
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->bindValue(':rank', ($i + 1), PDO::PARAM_INT);
		$statement->bindValue(':charid', $ids[$i], PDO::PARAM_INT);
		$statement->execute();
	}
} 
//\o/

if(isset($_POST['update']))
{
	//clearing everything
	$statement = $db->prepare("UPDATE selectedworks SET isincluded=:bBool WHERE userid=:id");
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->bindValue(':rank', '0', PDO::PARAM_BOOL);
	$statement->execute();
	
	//setting selected works
	$ids = explode( ',', $_POST["true"] );
	for($i = 0; $i < $_POST["count"]; $i++)
	{
		$statement = $db->prepare("UPDATE rankedchars SET userRank=:rank WHERE userid=:id AND charid=:charid");
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->bindValue(':rank', '0', PDO::PARAM_BOOL);
		$statement->execute();
	}
	//clearing characters
	$statement = $db->prepare("UPDATE rankedchars SET isincluded=:bBool WHERE userid=:id");
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->bindValue(':bBool', '0', PDO::PARAM_BOOL);
	$statement->execute();

	//constructing query
    $query = "SELECT distinct charid FROM worktocharacter";
    if ($_POST["count"] > 0)
    	$query .= " WHERE workid = $ids[0]";
    for($i = 1; $i < $_POST["count"]; $i++)
    {

    	$query .= " OR workid = $ids[$i]";
    }
    $query .= " order by charid";

    //selecting character from many to many table
    $statement = $db->prepare($query);
	$statement->execute();
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		$statement2 = $db->prepare("UPDATE rankedchars SET isincluded=:cBool WHERE user id=:id AND charid=:charid");
		$statement2->bindValue(':id', $id, PDO::PARAM_INT);
		$statement2->bindValue(':cBool', '1', PDO::PARAM_BOOL);
		$statement2->bindValue(':charid', $row['charid'], PDO::PARAM_INT);
		$statement2->execute();
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
	echo "<li id='$charid'> $name (<a href='art/$art'>X</a>)</li>";
	$count++;
}
	echo "</ul><input id='sortsize' type='hidden' value='$count' name='sortsize'></input>";
?>

<input id='order' type='hidden' value='' name='order'></input>
<button id="save" type="submit" class="update" name="save"> Save </button>
</form>

<br/>
<form method="post" action="generate.php">
	<input id='sortsize2' type='hidden' value='$count' name='sortsize'></input>
	<input id='order2' type='hidden' value='' name='order2'></input>
Number of images: <select class="selector" name="Imagenum">
    	<option value="1">Five</option>
    	<option value="2">Ten</option>
    	<option value="3">Fifteen</option>
    	<option value="4">Twenty</option>
	</select>
	<button id="generate" class="update" type="submit"> Generate </button>
</form id="works">

<?php
$statement = $db->prepare("SELECT why.workid, why.isincluded, exs.name FROM selectedworks AS why JOIN works AS exs ON why.workid = exs.workid WHERE userid=:id ORDER BY why.workid");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$count = 0;
$array = array();
while ($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['name'];
	$aBool = $row['isincluded'];
	$workid = $row['workid'];
	echo "<input class='work' id='$workid' type='checkbox' name='$name' " . ($aBool ? 'checked' : '') . "/> $name <br>";
	if ($aBool)
	{
		$count++;
		array_push($array, $workid);
	}
}
	$array = implode(",", $array);
	echo "
	<input id='workcount' type='hidden' value='$count' name='count'></input>
	<input id='true' type='hidden' value='$array' name='true'></input>
	";
?>
<button id="update" class="update" name="update" type="submit"> Update Characters </button> 
</form>


</body>
</html>