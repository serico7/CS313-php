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
	$("#generate").mouseenter(function () {
		var data = $("#sortable").sortable('toArray');
        $('#order').val(data);
		});
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
    echo "</ul><input id='sortsize' type='hidden' value='$count' name='sortsize'></input>"
?>
<input id='order' type='hidden' value='' name='order'></input>
Number of images: <select class="selector" name="Imagenum">
    <option value="1">Five</option>
    <option value="2">Ten</option>
    <option value="3">Fifteen</option>
    <option value="4">Twenty</option>
</select>
<button id="generate" type="submit"> Generate </button>
</form>

<br/>
<form>

<?php
$statement = $db->prepare("SELECT why.workid, why.isincluded, exs.name FROM selectedworks AS why JOIN works AS exs ON why.workid = exs.workid WHERE userid=:id ORDER BY why.workid");
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
while ($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$name = $row['name'];
	$aBool = $row['isincluded'];
	$workid = $row['workid'];
	echo "<input id='$workid' type='checkbox' name='$name' " . ($aBool ? 'checked' : '') . "/>";
}
?>	
</form>


</body>
</html>