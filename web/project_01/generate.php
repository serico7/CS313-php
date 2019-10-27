<?php

require "dbConnect.php";
$db = get_db();
$ids = explode( ',', $_POST["order2"] )
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<table>

<?php
$count = 0;
for ($i = 0; $i < $_POST["Imagenum"]; $i++)
{
	echo "<tr>";
	for ($j = 0; $j < 5; $j++)
	{
		$statement = $db->prepare("SELECT name, art FROM characters WHERE charid=:id");
		$statement->bindValue(':id', $ids[$count], PDO::PARAM_INT);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		$name = $row['name'];
		$art = $row['art'];
		echo "<td><img class='art' src='art/$art' title='"($count + 1) .". $name' alt='"($count + 1) .". $name'/></td>";
		$count++;
	}
	echo "</tr>";
}
while (($count + 5) < $_POST["sortsize2"])
{
	echo "<tr>";
	for ($j = 0; $j < 5; $j++)
	{
		$statement = $db->prepare("SELECT name, art FROM characters WHERE charid=:id");
		$statement->bindValue(':id', $ids[$count], PDO::PARAM_INT);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		$name = $row['name'];
		$art = $row['art'];
		echo "<td>$count" . ". $name</td>";
		$count++;
	}
	echo "</tr>";
}
echo "<tr>";
while ($count < $_POST["sortsize2"])
{
	$statement = $db->prepare("SELECT name, art FROM characters WHERE charid=:id");
	$statement->bindValue(':id', $ids[$count], PDO::PARAM_INT);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	$name = $row['name'];
	$art = $row['art'];
	echo "<td>"($count+1) . ". $name</td>";
	$count++;
}
echo "</tr>";
?>

</table>
<br/><br/><br/>
<a href="sort.php">Back to Sort</a>
</body>
</html>