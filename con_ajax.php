<?php

    header('Location: /');
    require('includes/database.php');
    //AJAX call
    try {
        $sql = 'SELECT * FROM users WHERE username = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['username']]);
        if ($stmt->rowCount() > 0) {
            $stmt->closeCursor();
            $pdo = null;
            echo 'Υπάρχει ήδη';
        }
        echo 'Δεν υπάρχει';
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

?>