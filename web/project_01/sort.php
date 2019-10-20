<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: login.php");
 //   exit;
//}
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
$(document).ready(function(){
	$( "#sortable" ).sortable();
	$( "#sortable" ).disableSelection();
	$('ul').sortable({
        axis: 'y',
        stop: function (event, ui) {
	        var data = $(this).sortable('toArray');
            $('#order').val(data);
}});});
</script>
</head>

<body>
<form method="post" action="generate.php">
<ul id="sortable" >
<?php
$id=1;
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
	$count = $count++;
}
    echo "</ul><input id='sortsize' type='hidden' value='$count' name='sortsize'></input>"
?>
<input id='order' type='hidden' value='' name='order'></input>
Number of images: <select class="selector" name="Imagenum">
    <option value="1">Five</option>
    <option value="2">Ten</option>
    <option value="3">Fifteen</option>
    <option value="4">Twenty</option>
</select>
<button type="submit"> Generate </button>
</form>
</body>
</html>