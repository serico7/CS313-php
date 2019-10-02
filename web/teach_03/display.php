<?php

$name = (isset($_POST['name']) ? $_POST['name'] : '');
$email = (isset($_POST['email']) ? $_POST['email'] : '');
$major = (isset($_POST['major']) ? $_POST['major'] : '');
$comments = (isset($_POST['comments']) ? $_POST['comments'] : '');
$continents = (isset($_POST['continents']) ? $_POST['continents'] : '');

$map = array("na" => "North America", "sa" => "South America", "eu" => "Europe", "as" => "Asia", "au" => "Australia", "af" => "Africa", "an" => "Antarctica");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Results</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="main">
    <h1>Your information:</h1>
    <dl>
      <dt>Name</dt>
      <dd><?php echo $name; ?>
      <dt>Email</dt>
      <dd><?php echo $email; ?></dd>
      <dt>Major</dt>
      <dd><?php echo $major; ?></dd>
      <dt>Continents Visited</dt>
      <dd><?php 
            if (is_array($continents)) {
              foreach($continents as $continent) {
                if (strlen($continent) == 2) {
                  echo $map[$continent] . "<br>";
                } else {
                  echo $continent . "<br>";
                }
                
              }
            } else {
              echo $continents;
            }
         ?>
      </dd>
      <dt>Comments</dt>
      <dd><?php echo $comments; ?></dd>
    </dl>


  </div>
</body>
</html>