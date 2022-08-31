<!DOCTYPE html>
<html>
    <body>

    <?php 
    $a = array(
        'One' => 'Cat',
        'Two' => 'Dog',
        'Three' => 'Elephant',
        'Four' => 'Fox'
    );
    
    foreach ($a as $key => $value) {
        echo "$key : $value <br>";
    }

    ?>

    </body>
</html>

