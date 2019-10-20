<?php

require "dbConnect.php";
$db = get_db();
$ids = explode( ',', $_POST["order"] )
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
		$charid = $row['charid'];
		echo "<td><img class='art' src='$art' title='$name' alt='$name'/></td>";
		$count++;
	}
	echo "</tr>";
}
while (($count + 5) < $_POST["sortsize"])
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
		echo "<td>$name</td>";
		$count++;
	}
	echo "</tr>";
}
echo "<tr>";
while ($count < $_POST["sortsize"])
{
	$statement = $db->prepare("SELECT name, art FROM characters WHERE charid=:id");
	$statement->bindValue(':id', $ids[$count], PDO::PARAM_INT);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	$name = $row['name'];
	$art = $row['art'];
	echo "<td>$name</td>";
	$count++;
}
echo "</tr>";
?>

</table>
</body>
</html>