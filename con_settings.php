<?php

    session_start();
    require('includes/database.php');

    if(isset($_POST['change'])) {

        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        $phone    = trim($_POST['phone']);

        //******************
        //Έλέγχος για errors
        //******************

        //Έλεγχος για κενά πεδία στη φόρμα
        if(empty($username) || empty($email) || empty($password) || empty($phone)) {
            header('Location: page_settings.php?msg=Παρακαλώ συμπληρώστε το form!');
            exit('Παρακαλώ συμπληρώστε το form!');
        } else {
            //Έλεγχος εισαγμένων χαρακτήρων
            $pattern1 = "/^[A-Za-z]+[A-Za-z0-9_]*[A-Za-z0-9]+$/";
            $pattern2 = "/^[A-Za-z0-9_]+$/";
            $pattern3 = "/^\d{10}$/";

            //Έλεγχος username για pattern και μήκος χαρακτήρων
            if(!preg_match($pattern1, $username) || strlen($username) > 25) {
                header('Location: page_settings.php?msg=Πρόβλημα με το username.');
                exit();
            } else {
                //Έλεγχος εγκυρότητας email
                if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
                    header('Location: page_settings.php?msg=Πρόβλημα με το email.');
                    exit();
                } else {
                    //Έλεγχος password για pattern και μήκος χαρακτήρων
                    if(!preg_match($pattern2, $password) || strlen($password) < 10) {
                        header('Location: page_settings.php?msg=Πρόβλημα με το password.');
                        exit();
                    } else {
                        //Έλεγχος phone για pattern και μήκος αριθμών
                        if(!preg_match($pattern3, $phone) || strlen($phone) != 10) {
                            header('Location: page_register_login.php?msg=Πρόβλημα με το phone.');
                            exit();
                        } else {
                            //Έλεγχος ύπαρξης του username/email στη database
                            try {
                                $sql = 'SELECT username, email FROM users WHERE username = ? OR email = ?';
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$username, $email]);

                                if ($stmt->rowCount() > 1) {
                                    $stmt->closeCursor();
                                    $pdo = null;
                                    header('Location: page_settings.php?msg=Το username ή το email υπάρχει ήδη!');
                                    exit();
                                } else {
                                    //Δεν υπάρχουν errors. Η φόρμα έχει συμπλήρωθεί σωστά
                                    //Παραγωγή 16 τυχαίων χαρακτήρων
                                    //--------------------------------------------------------------------------------
                                    $length = 16;
                                    $sillyString = "0123456789()AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz";
                                    $randomString = substr(str_shuffle($sillyString), 0, $length);
                                    $salt = '$6$' . $randomString;
                                    //--------------------------------------------------------------------------------
                                    //Κρυπτογράφηση password με SHA-512
                                    $encryptedPassword = crypt($password, $salt);

                                    //Ενημέρωηση των στοιχείων του χρήστη στη database
                                    $sql = 'UPDATE users SET username = ?, email = ?, password = ?, phone = ? WHERE userID = ?';
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$username, $email, $encryptedPassword, $phone, $_SESSION['userID']]);
                                    $stmt->closeCursor();
                                    $pdo = null;

                                    $_SESSION['username'] = $username;

                                    header('Location: page_settings.php?msg=Η ενημέρωση του λογαριασμού ολοκληρώθηκε!');
                                    exit();
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                                exit();
                            }
                        }
                    }
                }
            }
        }
    } else {
        header('Location: page_settings.php.php?msg=Πρόβλημα εγγραφής');
        exit();
    }

?>