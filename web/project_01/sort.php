<?php

require "dbConnect.php";
$db = get_db();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sort</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div>


<table>
<?php
$id=1;
$statement = $db->prepare("SELECT why.charid, exs.name, exs.art FROM rankedchars AS why JOIN characters AS exs ON why.charid = exs.charid WHERE userid=:id AND isIncluded ORDER BY userRank, why.charid");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
while ($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['exs.name'];
	$art = $row['exs.art'];
	$charid = $row['why.charid'];
	echo "<tr> $name </tr>";
}
?>
</table>

</div>

</body>
</html>