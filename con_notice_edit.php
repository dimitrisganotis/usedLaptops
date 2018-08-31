<?php

    session_start();
    require('includes/database.php');
    require('includes/functions.php');

    if(isset($_POST['edit'])) {

        $userID         = $_SESSION['userID'];
        $brand          = $_POST['brand'];
        $model          = $_POST['model'];
        $launchDate     = $_POST['launchDate'];
        $cpuBrand       = $_POST['cpuBrand'];
        $cpuModel       = $_POST['cpuModel'];
        $cpuCores       = $_POST['cpuCores'];
        $cpuFrequency   = $_POST['cpuFrequency'];
        $ramSize        = $_POST['ramSize'];
        $storageSize    = $_POST['storageSize'];
        $os             = $_POST['os'];
        $damage         = $_POST['damage'];
        $price          = $_POST['price'];

        $file           = $_FILES['file'];
        $fileName       = $file['name'];
        $fileTmpName    = $file['tmp_name'];
        $fileSize       = $file['size'];
        $fileError      = $file['error'];
        $fileType       = $file['type'];

        $fileDesc       = $_POST['description'];
        $fileMaxSize    = 204800; //200KB
        $fileUniqueName = time().uniqid(mt_rand(10000,99999));
        $location       = 'images/uploads/';
        $fileFinalName  = $location . $fileUniqueName . '.jpg';

        //******************
        //Έλέγχος για errors
        //******************

        //Έλεγχος για κενά πεδία στη φόρμα
        if(empty($brand) || empty($model) || empty($launchDate) || empty($cpuBrand) || empty($cpuModel) || empty($cpuCores) || empty($cpuFrequency)  || empty($ramSize) || empty($storageSize) || empty($os) || empty($price) || $damage < 0 || $damage > 1) {
            header('Location: page_notice_edit.php?msg=Παρακαλώ συμπληρώστε το form!');
            exit();
        } else {
            //Έλεγχος μήκος brand, model, cpuModel
            if(strlen($brand) < 2 || strlen($brand) > 25 || strlen($model) < 2 || strlen($model) > 100 || strlen($cpuModel) < 2 || strlen($cpuModel) > 20) {
                header('Location: page_notice_edit.php?msg=Πρόβλημα με Μάρκα ή Μοντέλο ή Μοντέλο Επεξεργαστή.');
                exit();
            } else {
                //Έλεγχος launchDate, cpuFrequency, ramSize, storageSize, price
                if(!filter_var($launchDate, FILTER_VALIDATE_INT) || ($launchDate < 2000 || $launchDate > 2018) || !filter_var($cpuFrequency, FILTER_VALIDATE_FLOAT) || ($cpuFrequency <= 0 || $cpuFrequency > 5.0) || !filter_var($ramSize, FILTER_VALIDATE_INT) || ($ramSize <= 0 || $ramSize > 32) || !filter_var($storageSize, FILTER_VALIDATE_INT) || ($storageSize <= 0 || $storageSize > 2000) || !filter_var($price, FILTER_VALIDATE_INT) || ($price <= 0 || $price > 5000)) {
                    header('Location: page_notice_edit.php?msg=Πρόβλημα με Έτος Κυκλοφορίας ή Συχνότητα Επεξεργαστή ή Μέγεθος Μνήμης RAM<br>ή Μέγεθος Αποθηκευτικού Χώρου ή Τιμής.');
                    exit();
                } else {
                    //Έλεγχος τύπου/μεγέθους αρχείου φωτογραφίας
                    if($fileType != 'image/jpeg' || $fileSize > $fileMaxSize) {
                        header('Location: page_notice_edit.php?msg=Μόνο αρχεία JPEG εως 200ΚΒ επιτρέπονται.');
                        exit();
                    } else {
                        //Δεν υπάρχουν errors. Η φόρμα έχει συμπλήρωθεί σωστά
                        try {
                            //Εισαγωγή των στοιχείων στη database
                            $sql = 'UPDATE laptops SET brand = ?, model = ?, launchDate = ?, cpuBrand = ?, cpuModel = ?, cpuCores = ?, cpuFrequency = ?, ramSize = ?, storageSize = ?, os = ?, damage = ?, price = ? WHERE userID = ?';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$brand, $model, $launchDate, $cpuBrand, $cpuModel, $cpuCores, $cpuFrequency, $ramSize, $storageSize, $os, $damage, $price, $userID]);

                            //Εύρεση του laptopID
                            $sql = 'SELECT laptopID FROM laptops WHERE userID = ?';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$userID]);
                            $result = $stmt->fetch();

                            $laptopID = $result['laptopID'];

                            //Εύρεση της παλιάς φωτο
                            $sql = 'SELECT name FROM images WHERE laptopID = ?';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$laptopID]);
                            $result = $stmt->fetch();

                            $oldName = $result['name'];
                            $oldFileFinalName  = $location . $oldName . '.jpg';

                            //Εισαγωγή των στοιχείων της φωτογραφίας στη database
                            $sql = 'UPDATE images SET name = ?, description = ? WHERE laptopID = ?';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$fileUniqueName, $fileDesc, $laptopID]);

                            $stmt->closeCursor();
                            $pdo = null;

                            if(move_uploaded_file($fileTmpName, $fileFinalName)) {
                                //Τα στοιχεία καταχωρήθηκαν στη database - Διαγραφή Παλιάς Φωτο
                                if(!unlink($oldFileFinalName)) {
                                    header('Location: page_notices.php?msg=Πρόβλημα με τη διαγραφή της παλιάς φωτογραφίας!');
                                    exit();
                                } else {
                                    header('Location: page_notices.php?msg=Η αγγελία άλλαξε με επιτυχία!');
                                    exit();
                                }
                            } else {
                                //Η φωτο δεν ανεβηκε
                                header('Location: page_notice_edit?msg=Η φωτο δεν ανεβηκε.');
                                exit();
                            }

                            //Τα στοιχεία καταχωρήθηκαν στη database
                            header('Location: page_notices.php?msg=Η αγγελία άλλαξε με επιτυχία!');
                            exit();
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                            exit();
                        }
                    }
                }
            }
        }
    } else {
        header('Location: page_notice_edit.php?msg=Πρόβλημα καταχώρησης αγγελίας');
        exit();
    }
?>