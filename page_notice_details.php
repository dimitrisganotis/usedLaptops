<?php

    session_start();

    //Αν είναι συνδεδεμένος απο λογαριασμό μη ενεργοποιημένο να γίνεται αποσύνδεση
    if(isset($_SESSION['username'], $_SESSION['status']) && $_SESSION['status'] == 0) {
        header("Location: con_logout.php");
        exit();
    }

    if(isset($_SESSION['username']))
        $username = $_SESSION['username'];
    else
        $username = null;

    require('includes/database.php');

    try {
        $sql = 'SELECT laptopID, username, brand, model, damage, price, dateOfUpdate FROM users, laptops WHERE users.userID = laptops.userID AND laptopID = '.$_GET['laptopID'];
        $stmt = $pdo->query($sql);

        while($record = $stmt->fetch())
            $subpage = $record['brand'] . ' ' . $record['model'];

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    $page = 'Αγγελίες';
    $title = "$subpage | $page | usedLaptops";
    include('includes/header.php');

    ?>

<!-- MAIN -->
<main id="main">

    <!-- PATH -->
    <div id="path">
        <div class="container">
            <a href="/">Αρχική</a>
            //
            <a href="/page_notices.php"><?php echo $page ?></a>
            //
            <?php

            $sql = 'SELECT laptopID, username FROM users, laptops WHERE users.userID = laptops.userID AND laptopID='.$_GET['laptopID'];
            $stmt = $pdo->query($sql);

            while($record = $stmt->fetch())
                echo '<a href="/page_notice_details.php?laptopID='.$record['laptopID'].'">Αγγελία Χρήστη: '.$record['username'].'</a>';

            ?>
        </div>
    </div>

    <div class="container">

<?php

    try {
        $sql = 'SELECT laptops.laptopID, username, phone, brand, model, launchDate, cpuBrand, cpuModel, cpuCores, cpuFrequency, ramSize, storageSize, os, damage, price, dateOfUpdate, name, description FROM users, laptops, images WHERE users.userID = laptops.userID AND laptops.laptopID = images.laptopID AND laptops.laptopID = '.$_GET['laptopID'];
        $stmt = $pdo->query($sql);

        while($record = $stmt->fetch()) {
            echo '<div id="laptop-details"><div id="basic-info">';
            echo '<a class="laptop_image" href="/images/uploads/'.$record['name'].'.jpg" target="_blank" title="Προβολή Φωτογραφίας" style="background-image: url(/images/uploads/'.$record['name'].'.jpg); background-size: contain; width: 384px; height:216px;"></a>';
            echo '<h2 class="title">' . $record['brand'] . ' ' . $record['model'] . ' - ' . $record['price'] . '€</h2>';

            //Εαν είναι συνδεδεμένος να μπορεί να επεξεργαστεί την αγγελία του
            if($username == $record['username']) {
                echo '<a href="page_notice_edit.php?laptopID='.$record['laptopID'].'" style="text-decoration: underline;">'.'[Επεξεργασία Αγγελίας]</a>';
            }

            echo '<p style="margin-top: 15px;">Χρήστης: ' . $record['username'] . '</p>';
            echo '<p>Τηλ.Επικοινωνίας: ' . $record['phone'] . '</p>';
            echo '<p>Υποβλήθηκε/Ανανεώθηκε: ' . $record['dateOfUpdate'] . '</p>';

            if ($record['damage'] == 0)
                echo '<p>Ζημιά: ΟΧΙ</p>';
            else if ($record['damage'] == 1)
                echo '<p>Ζημιά: NAI</p>';

            echo '</div><div id="more-info"><h3>Χαρακτηριστικά Laptop</h3>';
            echo '<p><b>Ημερομηνία Κυκλοφορίας: </b>' . $record['launchDate'] . '</p>';
            echo '<p><b>Μάρκα Επεξεργαστή: </b>' . $record['cpuBrand'] . '</p>';
            echo '<p><b>Μοντέλο Επεξεργαστή: </b>' . $record['cpuModel'] . '</p>';
            echo '<p><b>Πυρήνες Επεξεργαστή: </b>' . $record['cpuCores'] . '</p>';
            echo '<p><b>Συχνότητα Επεξεργαστή: </b>' . $record['cpuFrequency'] . ' Ghz</p>';
            echo '<p><b>Μέγεθος Μνήμης RAM: </b>' . $record['ramSize'] . ' GB</p>';
            echo '<p><b>Χωρητικότητα Αποθήκευσης: </b>' . $record['storageSize'] . ' GB</p>';
            echo '<p><b>Λειτουργικό Σύστημα: </b>' . $record['os'] . '</p>';
            echo '</div></div>';
        }

        $stmt->closeCursor();
        $pdo = null;

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
