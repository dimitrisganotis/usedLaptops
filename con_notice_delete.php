<?php

    session_start();
    require('includes/database.php');
    require('includes/functions.php');

    if(isset($_POST['delete'])) {

        $userID         = $_SESSION['userID'];
        $laptopID       = $_POST['laptopID'];

        //Έλεγχος για κενά πεδία στη φόρμα
        if(empty($userID) || empty($laptopID)) {
            header('Location: page_notice_edit.php?msg=ERROR');
            exit();
        } else {
            try {
                //Εισαγωγή των στοιχείων στη database
                $sql = 'DELETE FROM images WHERE laptopID = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$laptopID]);

                $sql = 'DELETE FROM laptops WHERE laptopID = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$laptopID]);

                $stmt->closeCursor();
                $pdo = null;

                //Η αγγελία διαγράφηκε
                header('Location: page_notices.php?msg=Η αγγελία διαγράφηκε!');
                exit();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }
    } else {
        header('Location: page_notice_edit.php?msg=Πρόβλημα με την διαγραφή της αγγελίας');
        exit();
    }
?>