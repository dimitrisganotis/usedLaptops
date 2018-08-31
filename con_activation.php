<?php

    session_start();
    require('includes/database.php');

    if(isset($_POST['activation'])) {
        $username = $_SESSION['username'];
        $status = $_SESSION['status'];
        $activationCode = trim($_POST['activationCode']);

        //Έλεγχος αν έχει συμπληρωθεί το πεδίο
        if (empty($activationCode)) {
            header('Location: page_code_activation.php?msg=Παρακαλώ συμπληρώστε το κωδικό!');
            exit();
        } else {
            //Έλεγχος της κατασταστασης του λογαριασμού
            if($status == 1) {
                header('Location: /');
                exit();
            } else {
                //Έλεγχος αν ο κωδικός είναι σωστός
                try {
                    $sql = 'SELECT activationCode FROM users WHERE username = ?';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$username]);
                    $result = $stmt->fetch();
                    $dbActivationCode = $result['activationCode'];

                    //Ο κωδικός είναι σωστός
                    if ($activationCode == $dbActivationCode) {
                        $status = 1; //O λογαριασμός να γίνει ενεργοποιημένος
                        $sql = 'UPDATE users SET status = ? WHERE username = ?';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$status, $username]);
                        $stmt->closeCursor();
                        $pdo = null;
                        //κρατάω το νέο status για να με κρατήσει συνδεδεμενο η αρχική
                        $_SESSION['status'] = $status;
                        header('Location: /');
                        exit('Σωστός κωδικός');
                    } else {
                        //Ο κωδικός είναι λάθος
                        header('Location: page_code_activation.php?msg=Λάθος κωδικός. Προσπάθησε ξανά!');
                        exit('Λάθος κωδικός');
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit();
                }
            }
        }
    }
?>
