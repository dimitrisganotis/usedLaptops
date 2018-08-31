<?php

    $dbhost = 'localhost';
    $dbname = 'usedLaptops';
    $dbuser = 'usedLaptops_user';
    $dbpass = '123456789';

    try {
        $pdo = new PDO("mysql: host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdo->exec('set names utf8');
    } catch (PDOException $e) {
        echo 'PDO Exception: '.$e -> getMessage();
        exit("Αδυναμία δημιουργίας PDO Object");
    }

?>