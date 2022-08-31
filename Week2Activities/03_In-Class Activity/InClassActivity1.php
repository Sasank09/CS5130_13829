<!DOCTYPE html>
<html>
    <body>

    <?php 
    $input = 'The term <i>Official Ireland</i> is commonly <br />' .
    'used in <b>the Republic of Ireland</b> to denote<br />' .
    ' the media, cultural and religious establishment. '.
    '<script>alert("Nice try!");</script>' .
    '<img src="/spam.jpg" />';
    
    echo strip_tags($input, '<i>,<b>,<br>');

    echo "<br><br><br>";
    echo "Strip with exceptions of paragragh and italics: strip_tags($ input, '< i >,< p >') <br><br>";
    echo strip_tags($input, '<i>,<p>');

    ?>

    </body>
</html>
