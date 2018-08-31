<?php

    session_start();
    unset($_SESSION['username'], $_SESSION['userID'], $_SESSION['status']);
    session_destroy();
    header('Location: page_register_login.php?msg=Αποσυνδεθήκατε επιτυχώς!');
    exit();

?>