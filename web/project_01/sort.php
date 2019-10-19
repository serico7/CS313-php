<?php

require "dbConnect.php";
$db = get_db();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sort</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$( function() {
			$( "#sortable" ).sortable();
			$( "#sortable" ).disableSelection();
		} );
</script>
</head>

<body>

<ul id="sortable">
<?php
$id=1;
$statement = $db->prepare("SELECT why.charid, exs.name, exs.art FROM rankedchars AS why JOIN characters AS exs ON why.charid = exs.charid WHERE userid=:id AND isIncluded ORDER BY userRank, why.charid");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
while ($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['name'];
	$art = $row['exs.art'];
	$charid = $row['why.charid'];
	echo "<li> $name </li>";
}
?>
</ul>

</body>
</html>