<?php
$sum = 0;
if (isset($_POST['dopost']) && isset($_POST['number']) && isset($_POST['meal']) && isset($_POST['place'])) {
  $number = $_POST['number'];
  $meal = $_POST['meal'];
  $place = $_POST['place'];
  $meal_cost = '';
  $place_cost = '';
  switch ($meal) {
    case "Burrito":
      $meal_cost = 8;
      break;
    case "Kimbap":
      $meal_cost = 8;
      break;
    case "Curry":
      $meal_cost = 12;
      break;
    case "Fried Rice":
      $meal_cost = 10;
      break;
    default:
      $meal_cost = 0;
  }
  switch ($place) {
    case "Union Station":
      $place_cost = 3;
      break;
    case "Lake Jacomo":
      $place_cost = 10;
      break;
    case "Shawnee Mission Park":
      $place_cost = 10;
      break;
    case "AMC Movie Theater":
      $place_cost = 8;
      break;
    default:
      $place_cost = 0;
  }
  $total_cost = $number * ($meal_cost + $place_cost);
}

?>


<head>
  <title>Let's schedule for the Weekend!</title>
</head>

<body>
  <h1>"Weekend Scheduler"</h1>
  <form method="post">
    How many people do we have?:
    <input type="number" name="number" min="1" max="5"><br />

    <p>Lunch Menu:<br>
      <input type="radio" name='meal' value="Burrito">Burrito: $8<br>
      <input type="radio" name='meal' value="Kimbap">Kimbap: $8<br>
      <input type="radio" name='meal' value="Curry">Curry: $12<br>
      <input type="radio" name='meal' value="Fried Rice">Fried Rice: $10<br>
    </p>

    <p>Places To Go:
      <select name="place">
        <option name="place" value="0">-- Please Select --</option>
        <option name="place" value="Union Station">Union Station: $3</option>
        <option name="place" value="Lake Jacomo">Lake Jacomo: $10</option>
        <option name="place" value="Shawnee Mission Park">Shawnee Mission Park: $10</option>
        <option name="place" value="AMC Movie Theater">AMC Movie Theater: $8</option>
      </select>
    </p>
    <p><input type="submit" name="dopost" value="Calculate" /></p>
    <?php
    if (isset($total_cost)) {
      echo "<p># of People: $number</p>";
      echo "<p>Lunch: $meal</p>";
      echo "<p>Place: $place</p>";
      echo "<p>Total Cost: $ $total_cost</p>";
    }
    ?>
  </form>