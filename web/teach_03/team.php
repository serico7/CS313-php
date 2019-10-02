<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Team - Week 3</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

<?php
  $majors = array("CS" => "Computer Science", "WDD" => "Web Design and Development", "CIT" => "Computer Information Technology", "CE" => "Computer Engineering");
?>

</head>
<body>
  <div class="main">
<form action="display.php" method="POST">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" name="email" id="email">
  </div>
  <div class="form-group">
    <?php foreach($majors as $abbr => $major) {
        echo "<div class=\"form-check\">";
        echo "<input type=\"radio\" class=\"form-check-input\" id=\"$abbr\" name=\"major\" value=\"$major\">";
        echo "<label class=\"form-check-label\" for=\"$abbr\">$major</label>";
        echo "</div>";
    }
    ?>
  </div>
  <div class="form-group">
    <label for="continents">Continents Visited:</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="na" name="continents[]" id="na">
      <label class="form-check-label" for="na">North America</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="sa" name="continents[]" id="sa">
      <label class="form-check-label" for="sa">South America</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="eu" name="continents[]" id="eu">
      <label class="form-check-label" for="eu">Europe</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="as" name="continents[]" id="as">
      <label class="form-check-label" for="as">Asia</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="au" name="continents[]" id="au">
      <label class="form-check-label" for="au">Australia</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="af" name="continents[]" id="af">
      <label class="form-check-label" for="af">Africa</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="an" name="continents[]" id="an">
      <label class="form-check-label" for="an">Antarctica</label>
    </div>
  
  </div>
  <div class="form-group">
    <label for="comments">Comments:</label>
    <textarea name="comments" id="comments" class="form-control" rows="5"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</body>
</html>