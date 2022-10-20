<?php
    #Modal & Controller
    #Defining constant for track id
    define("REAL_TRACK_ID", "9261290989312153023597", false);
    #get track Id from user Input through html form get method
    $tracking_id = $_GET['track_id'];
    $trackId = isset($tracking_id) ? $tracking_id : '';
    #Using Ternary operator - to check if input matches with track Id else checking for input type and validity
    $status_message = $tracking_id == REAL_TRACK_ID ? "The package is on its way!!" : (is_numeric($tracking_id) ? "Enter Valid Tracking Number." : "Please provide only numbers!!");
    #To display the status of trackId after get request 
    $message = isset($tracking_id) ? $status_message : '';
?>

<!DOCTYPE html>
<html lang="en">
<!-- View & Controller -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fedex Tracking App</title>
</head>

<body>
    <h1><b>Fedex Tracking App</b></h1>
    <form method="get">
        <p><label for="track_id">Enter Tracking Number</label></p>
        <input type="text" name="track_id" id="track_id" value="<?= htmlentities($trackId) ?>">
        <input type="submit" id="submit" name="dopost" value="Submit">
    </form>
    <h2 style="color:red;"><b><?= htmlentities($message) ?></b></h2>
</body>

<pre>
$_GET =
<?php
    print_r($_GET);
?>
</pre>

</html>