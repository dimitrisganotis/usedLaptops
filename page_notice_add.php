<?php

    session_start();

    require('includes/database.php');

    //Αν δεν είναι ήδη συνδεδεμλένος να μην έχει πρόσβαση στη συγκεκριμένη σελίδα
    if (!isset($_SESSION['username'])) {
        header("Location: page_register_login.php?msg=Συνδεθείτε για να καταχωρήσετε αγγελία!");
        exit();
    }

    //Αν είναι συνδεδεμένος απο λογαριασμό μη ενεργοποιημένο να γίνεται αποσύνδεση
    if(isset($_SESSION['username'], $_SESSION['status']) && $_SESSION['status'] == 0) {
        header("Location: con_logout.php");
    }

    //Αν έχει καταχωρήση ήδη μια αγγελία να μη μπορεί να καταχωρήσει άλλη
    try {
        $sql = 'SELECT userID FROM laptops WHERE userID = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['userID']]);

        if($stmt->rowCount() >= 1) {
            header('Location: page_notices.php?msg=Έχετε ήδη καταχωρήσει αγγελία!');
            exit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    $page = 'Αγγελίες';
    $subpage = 'Καταχώρηση Αγγελίας';
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
            <a href="/page_notice_add.php"><?php echo $subpage ?></a>
        </div>
    </div>

    <div class="container">

        <?php echo_msg(); ?>

        <section class="notice_info">
            <h2>Πληροφορίες Αγγελίας</h2>
            <p>Συμπληρώστε ολόκληρη τη φόρμα για να καταχωρήσετε την αγγελία</p>

            <form class="notice" action="con_notice_add.php" method="post" enctype="multipart/form-data">
                <div class="notice_input-group">
                    <label><b>Μάρκα</b></label>
                    <br>
                    <input type="text" name="brand" placeholder="Apple, Dell, Microsoft ..." pattern="[A-Za-z0-9 -]{2,25}" title="Από 2 έως 25 λατινικούς χαρακτήρες. Επιτρεπτοί ειδικοί χαρακτήρες: -" required>
                </div>
                <div class="notice_input-group">
                    <label><b>Μοντέλο</b></label>
                    <br>
                    <input type="text" name="model" placeholder="MacBook, Inspiron ..." pattern='[A-Za-z0-9 -/()"]{2,50}' title='Από 2 έως 50 λατινικούς χαρακτήρες. Επιτρεπτοί ειδικοί χαρακτήρες: -/()"' required>
                </div>
                <div class="notice_input-group">
                    <label><b>Έτος Κυκλοφορίας</b></label>
                    <br>
                    <input type="number" name="launchDate" min="2000" max="2018" step="1" required>
                </div>
                <div class="notice_input-group">
                    <label><b>Μάρκα Επεξεργαστή</b></label>
                    <br>
                    <input type="radio" name="cpuBrand" value="Intel" required> Intel
                    <input type="radio" class="radioButton" name="cpuBrand" value="AMD" required> AMD
                </div>
                <div class="notice_input-group">
                    <label><b>Μοντέλο Επεξεργαστή</b></label>
                    <br>
                    <input type="text" name="cpuModel" pattern='[A-Za-z0-9 -/()"]{2,20}' title='Από 2 έως 20 λατινικούς χαρακτήρες. Επιτρεπτοί ειδικοί χαρακτήρες: -/()"' required>
                </div>
                <div class="notice_input-group">
                    <label><b>Αριθμός Πυρήνων Επεξεργαστή</b></label>
                    <br>
                    <input type="radio" name="cpuCores" value="1" required> 1
                    <input type="radio" class="radioButton" name="cpuCores" value="2" required> 2
                    <input type="radio" class="radioButton" name="cpuCores" value="4" required> 4
                    <input type="radio" class="radioButton" name="cpuCores" value="8" required> 8
                </div>
                <div class="notice_input-group">
                    <label><b>Συχνότητα Επεξεργαστή</b></label>
                    <br>
                    <input type="text" name="cpuFrequency" required> Ghz
                </div>
                <div class="notice_input-group">
                    <label><b>Μέγεθος Μνήμης RAM</b></label>
                    <br>
                    <input type="text" name="ramSize" required> GB
                </div>
                <div class="notice_input-group">
                    <label><b>Χωρητικότητα Αποθήκευσης</b></label>
                    <br>
                    <input type="text" name="storageSize" required> GB
                </div>
                <div class="notice_input-group">
                    <label><b>Λειτουργικό Σύστημα</b></label>
                    <br>
                    <input type="radio"  name="os" value="Windows 7/8/8.1/10" required> Windows 7/8/8.1/10
                    <input type="radio" class="radioButton" name="os" value="MacOS" required> MacOS
                    <input type="radio" class="radioButton" name="os" value="Linux" required> Linux
                    <input type="radio" class="radioButton" name="os" value="No OS" required> Χωρίς Λειτουργικό Σύστημα
                </div>
                <div class="notice_input-group">
                    <label><b>Ζημιά</b></label>
                    <br>
                    <input type="radio" name="damage" value="1" required> Ναι
                    <input type="radio" class="radioButton" name="damage" value="0" required> Όχι
                </div>
                <div class="notice_input-group">
                    <label><b>Τιμή Πώλησης</b></label>
                    <br>
                    <input type="text" name="price" required> €
                </div>
                <div class="notice_input-group" style="margin-top: 20px;">
                    <fieldset>
                        <legend>Ανέβασμα Φωτογραφίας (JPEG έως 200KB)</legend>
                        <input type="file" name="file" multiple required style="padding: 10px; border: black thin solid; margin-top: 5px;">
                        <br>
                        <input type="text" name="description" placeholder="Περιγραφή Φωτογραφίας" required style="margin: 10px;">
                    </fieldset>
                </div>
                <br>
                <input class="notice_submit-btn" name="add" type="submit" value="Καταχώρηση">
                <br>
            </form>
        </section>

    </div>

</main>

<?php include('includes/footer.php'); ?>
