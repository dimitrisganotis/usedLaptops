<?php

    if(!isset($_GET['style'])) {
        header('Location: page_settings.php');
        exit();
    }

    switch($_GET['style']) {
        case 1: if (isset($_COOKIE['css']))
                    setcookie ('css', '', time()-3600);
                header('Location: page_settings.php');
                exit();
        case 2: $style = 'style.css';
                break;
        case 3: $style = 'style2.css';
                break;
        default: $style = 'style.css';
    }

    //έστω μια νέα ημ/νία λήξης, 120 μέρες μετά
    $expire=  time() + 120*24*60*60;

    //βάζουμε το νέο cookie στον browser του χρήστη
    setcookie( 'css', $style, $expire);

    header('Location: page_settings.php');
    exit();

?>