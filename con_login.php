<?php

    session_start();
    require('includes/database.php');

    if(isset($_POST['login'])) {

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        //******************
        //Έλέγχος για errors
        //******************

        //Έλεγχος για κενά πεδία στη φόρμα
        if(empty($username) || empty($password)) {
            header('Location: page_register_login.php?msg=Παρακαλώ συμπληρώστε το form!');
            exit();
        } else {
            //Η φόρμα έχει συμπλήρωθεί
            //Έλεγχος ύπαρξης του username στη database
            try {
                $sql = 'SELECT userID, username, password, status FROM users WHERE username = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username]);

                //Το username δεν υπάρχει
                if($stmt->rowCount() < 1) {
                    $stmt->closeCursor();
                    $pdo = null;
                    header('Location: page_register_login.php?msg=Το username δεν υπάρχει!');
                    exit();
                } else {
                    //To username υπάρχει
                    //Ελεγχος password - Αποκρυπτογράφηση
                    $result = $stmt->fetch();
                    $encryptedPassword = $result['password'];
                    $userID = $result['userID'];
                    $status = $result['status'];

                    if(crypt($password, $encryptedPassword) != $encryptedPassword) {
                        header('Location: page_register_login.php?msg=Λάθος username ή password!');
                        exit();
                    } else {
                        //Έλεγχος captcha
                        if (!isset($_POST["captcha"]) && $_POST["captcha"] == "" && $_SESSION["code"] != $_POST["captcha"]) {
                            header('Location: page_register_login.php?msg=Λάθος captcha!');
                            exit();
                        } else {
                            //--------------------------------------------------
                            //Δεν υπάρχουν errors. Όλα τα στοιχεία είναι σωστά!
                            //Να αποθηκευτεί ο χρήστης στο SESSION
                            //--------------------------------------------------
                            $_SESSION['userID'] = $userID;
                            $_SESSION['username'] = $username;
                            $_SESSION['status'] = $status;

                            //Έλεγχος λογαριασμού
                            if($status != 0) {
                                header('Location: page_notices.php');
                                exit();
                            } else {
                                header('Location: page_code_activation.php');
                                exit();
                            }
                        }
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
        }
    } else {
        header('Location: page_register_login.php?msg=Πρόβλημα σύνδεσης');
        exit();
    }

?>