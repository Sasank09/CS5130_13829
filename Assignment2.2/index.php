<?php
// model and controller
require_once 'pdo.php';

/* ======================================================
The below condition is to check if menupollingForm is submitted
If the person already exist in table then updates the data else inserts the data
 ====================================================== */
if (isset($_POST['submit']) && isset($_POST['person_name']) && isset($_POST['item_name']) && isset($_POST['suggestion'])) {

    $sql = "SELECT name,menu,suggestion FROM family WHERE name =:personName";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':personName' => $_POST['person_name']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === FALSE) {
        $sql = "INSERT INTO family (name, menu, suggestion) VALUES (:personName, :item, :suggestion)";
    } else {
        $sql = "UPDATE family SET menu=:item, suggestion=:suggestion WHERE name=:personName";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':personName' => $_POST['person_name'],
        ':item' => $_POST['item_name'],
        ':suggestion' => $_POST['suggestion']
    ));
}

/* ======================================================
The below condition is to check if resetform is submitted with correct code 0000
====================================================== */ 
else if (isset($_POST['reset']) && isset($_POST['reset_id']) && $_POST['reset_id'] === '0000') {
    $sql = "DELETE FROM family WHERE 1";
    $stmt = $pdo->query($sql);
}

$stmt = $pdo->query("SELECT name, menu, suggestion FROM family");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<!-- View and Controller -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinner Menu Polling App</title>
    <style>
        body {
            margin: auto;
            box-sizing: border-box;
            width: 95%;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <main>
        <h1><b><q>What do you want for dinner tonight?</q></b></h1>
        <div>
            <form method="post" id="menupollingForm">
                <div>
                    <label for="person_name">Who are you?</label><br>
                    <input type="radio" name="person_name" id="dad" value="Dad">
                    <label for="dad">Dad</label><br>
                    <input type="radio" name="person_name" id="mom" value="Mom">
                    <label for="mom">Mom</label><br>
                    <input type="radio" name="person_name" id="daniel" value="Daniel">
                    <label for="daniel">Daniel</label><br>
                    <input type="radio" name="person_name" id="timothy" value="Timothy">
                    <label for="timothy">Timothy</label><br>
                    <input type="radio" name="person_name" id="noah" value="Noah">
                    <label for="noah">Noah</label><br>
                </div>
                <br>
                <div>
                    <label for="item_name">What do you want for dinner tonight?:</label><br>
                    <select name="item_name" id="item_name">
                        <option value="">-- Please Select --</option>
                        <option value="CM Chicken">CM Chicken</option>
                        <option value="Pizza (Costco frozen)">Pizza (Costco frozen)</option>
                        <option value="Korean bbq (Costco item)">Korean bbq (Costco item)</option>
                        <option value="Ramen">Ramen</option>
                        <option value="I don't Know">I don't Know</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="suggestion">Other Suggestion?</label><br>
                    <textarea name="suggestion" id="suggestion" cols="25" rows="5">N/A</textarea>
                </div>
                <br>
                <input type="submit" name="submit" id="submit" value="Submit">
            </form>
        </div>
        <br>
        <div>
            <table border="1">
                <th>Who</th>
                <th>Menu</th>
                <th>Suggestion</th>
                <?php
                foreach ($rows as $row) {
                    echo "<tr><td>";
                    echo ($row['name']);
                    echo ("</td><td>");
                    echo ($row['menu']);
                    echo ("</td><td>");
                    echo ($row['suggestion']);
                    echo ("</td></tr>\n");
                }
                ?>
            </table>
        </div>
        <br>
        <div>
            <form id="resetform" method="post">
                <label for="reset_id">Reset ID (Only Dad knows this):</label>
                <input type="text" id="reset_id" name="reset_id"><br><br>
                <input type="submit" name="reset" value="Reset">
            </form>
        </div>


    </main>
</body>

</html>