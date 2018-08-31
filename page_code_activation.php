<?php

    session_start();

    //Να έχει πρόσβαση μόνο αν έχει κάνει login και αν το status=0
    if (!isset($_SESSION['username'], $_SESSION['status'])) {
        header("Location: page_register_login.php?msg=Πρέπει να κάνεις login!");
        exit();
    }

    if($_SESSION['status']==1) {
        header("Location: page_notices.php?msg=Έχεις ήδη ενεργοποιήσει το λογαριασμό σου");
        exit();
    }

    $page = 'Ενεργοποίηση Λογαριασμού';
    $title = "$page | usedLaptops";
    include('includes/functions.php');

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="To usedLaptops είναι μια on-line υπηρεσία αγγελιών μεταχειρισμένων laptops">
    <meta name="keywords" content="usedLaptops, αγγελίες, μεταχειρισμένα, laptop">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto%7CRoboto+Slab" rel="stylesheet">
</head>

<body>
<div id="page-container">
    <div id="activation-container">
        <h1>Ενεργοποίηση Λογαριασμού</h1>
        <p>Για να ενεργοποιήσετε το λογαριασμό σας, συμπλήρώστε το πενταψήφιο κωδικό που λάβατε στο email που σας στείλαμε
            κατα τη δημιουργία του λογαριασμού σας.</p>

        <?php echo_msg();?>

        <form name="activation-form" action="con_activation.php" method="post">
            <input name="activationCode" type="text" name="code" placeholder="Εισάγετε τον κωδικό σας" required>
            <input name="activation" type="submit" value="Ενεργοποίηση">
        </form>
    </div>
</div>
</body>
</html>