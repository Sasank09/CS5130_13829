<?php
/* ======================================================
 * Database connection
/* ====================================================== */
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dinner', 'php', 'phpdb');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



