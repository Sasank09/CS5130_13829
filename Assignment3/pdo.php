<?php

const DB_HOST = 'localhost';
const DB_PORT = 3306;
const DB_NAME = 'gmailaccount';
const DB_USER = 'php';
const DB_PASSWORD = 'phpdb';

function dbConnection()
{
    $connString = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
    try {
        $databaseConnection = new PDO($connString, DB_USER, DB_PASSWORD);
        // See the "errors" folder for details...
        $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $databaseConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $databaseConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return  $databaseConnection;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        echo $message;
    }
}

$pdo = dbConnection();

