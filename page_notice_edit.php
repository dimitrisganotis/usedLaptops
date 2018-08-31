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
        $sql = 'SELECT laptopID, username, brand, model, damage, price, dateOfUpdate FROM users, laptops WHERE users.userID = laptops.userID AND laptops.laptopID = '.$_GET['laptopID'];
        $stmt = $pdo->query($sql);

        while($record = $stmt->fetch()) {
            //Ελεγχος αν επεξεργάζεται τη δική του αγγελία
            if($username != $record['username']) {
                header("Location: page_notices.php?msg=Μπορείς να επεξεργαστείς μόνο τη δική σου αγγελία");
                exit();
            }
            $subpage = $record['brand'] . ' ' . $record['model'];
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    $page = 'Αγγελίες';
    $title = "Επεξεργασία | $subpage | $page | usedLaptops";
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

            $sql = 'SELECT laptops.laptopID, brand, model, launchDate, cpuBrand, cpuModel, cpuCores, cpuFrequency, ramSize, storageSize, os, damage, price FROM users, laptops, images WHERE users.userID = laptops.userID AND laptops.laptopID = images.laptopID AND laptops.laptopID = '.$_GET['laptopID'];
            $stmt = $pdo->query($sql);

            while($record = $stmt->fetch()) {
                echo '<a href="/page_notice_edit.php?laptopID=' . $record['laptopID'] . '">Επεξεργασία της αγγελίας μου</a>';
                $laptopID = $record['laptopID'];
                $brand = $record['brand'];
                $model = $record['model'];
                $launchDate = $record['launchDate'];
                $cpuBrand = $record['cpuBrand'];
                $cpuModel = $record['cpuModel'];
                $cpuCores = $record['cpuCores'];
                $cpuFrequency = $record['cpuFrequency'];
                $ramSize = $record['ramSize'];
                $storageSize = $record['storageSize'];
                $os = $record['os'];
                $damage = $record['damage'];
                $price = $record['price'];
            }
            ?>
        </div>
    </div>

    <?php echo_msg(); ?>

    <div class="container">

        <section class="notice_info">
            <h2>Επεξεργασία Αγγελίας</h2>
            <p>Συμπληρώστε τη φόρμα για να αλλάξετε την αγγελία</p>

            <form class="notice" action="con_notice_edit.php" method="post" enctype="multipart/form-data">
                <div class="notice_input-group">
                    <label><b>Μάρκα</b></label>
                    <br>
                    <input type="text" name="brand" placeholder="Apple, Dell, Microsoft ..." pattern="[A-Za-z0-9 -]{2,25}" title="Από 2 έως 25 λατινικούς χαρακτήρες. Επιτρεπτοί ειδικοί χαρακτήρες: -" value="<?php echo $brand; ?>" required>
                </div>
                <div class="notice_input-group">
                    <label><b>Μοντέλο</b></label>
                    <br>
                    <input type="text" name="model" placeholder="MacBook, Inspiron ..." pattern='[A-Za-z0-9 -/()"]{2,50}' title='Από 2 έως 50 λατινικούς χαρακτήρες. Επιτρεπτοί ειδικοί χαρακτήρες: -/()"' value="<?php echo $model; ?>" required>
                </div>
                <div class="notice_input-group">
                    <label><b>Έτος Κυκλοφορίας</b></label>
                    <br>
                    <input type="number" name="launchDate" min="2000" max="2018" step="1" value="<?php echo $launchDate; ?>" required>
                </div>
                <div class="notice_input-group">
                    <label><b>Μάρκα Επεξεργαστή</b></label>
                    <br>
                    <input type="radio" name="cpuBrand" value="Intel" <?php if($cpuBrand == 'Intel') echo 'checked="checked"'; ?> required> Intel
                    <input type="radio" class="radioButton" name="cpuBrand" value="AMD" <?php if($cpuBrand == 'AMD') echo 'checked="checked"'; ?> required> AMD
                </div>
                <div class="notice_input-group">
                    <label><b>Μοντέλο Επεξεργαστή</b></label>
                    <br>
                    <input type="text" name="cpuModel" pattern='[A-Za-z0-9 -/()"]{2,20}' title='Από 2 έως 20 λατινικούς χαρακτήρες. Επιτρεπτοί ειδικοί χαρακτήρες: -/()"' value="<?php echo $cpuModel; ?>" required>
                </div>
                <div class="notice_input-group">
                    <label><b>Αριθμός Πυρήνων Επεξεργαστή</b></label>
                    <br>
                    <input type="radio" name="cpuCores" value="1"  <?php if($cpuCores == 1) echo 'checked="checked"'; ?> required> 1
                    <input type="radio" class="radioButton" name="cpuCores" value="2" <?php if($cpuCores == 2) echo 'checked="checked"'; ?> required> 2
                    <input type="radio" class="radioButton" name="cpuCores" value="4" <?php if($cpuCores == 4) echo 'checked="checked"'; ?> required> 4
                    <input type="radio" class="radioButton" name="cpuCores" value="8" <?php if($cpuCores == 8) echo 'checked="checked"'; ?> required> 8
                </div>
                <div class="notice_input-group">
                    <label><b>Συχνότητα Επεξεργαστή</b></label>
                    <br>
                    <input type="text" name="cpuFrequency" value="<?php echo $cpuFrequency; ?>" required> Ghz
                </div>
                <div class="notice_input-group">
                    <label><b>Μέγεθος Μνήμης RAM</b></label>
                    <br>
                    <input type="text" name="ramSize" value="<?php echo $ramSize; ?>" required> GB
                </div>
                <div class="notice_input-group">
                    <label><b>Χωρητικότητα Αποθήκευσης</b></label>
                    <br>
                    <input type="text" name="storageSize" value="<?php echo $storageSize; ?>" required> GB
                </div>
                <div class="notice_input-group">
                    <label><b>Λειτουργικό Σύστημα</b></label>
                    <br>
                    <input type="radio"  name="os" value="Windows 7/8/8.1/10" <?php if($os == 'Windows 7/8/8.1/10') echo 'checked="checked"'; ?> required> Windows 7/8/8.1/10
                    <input type="radio" class="radioButton" name="os" value="ΜacOS" <?php if($os == 'ΜacOS') echo 'checked="checked"'; ?> required> MacOS
                    <input type="radio" class="radioButton" name="os" value="Linux" <?php if($os == 'Linux') echo 'checked="checked"'; ?> required> Linux
                    <input type="radio" class="radioButton" name="os" value="No OS" <?php if($os == 'No OS') echo 'checked="checked"'; ?> required> Χωρίς Λειτουργικό Σύστημα
                </div>
                <div class="notice_input-group">
                    <label><b>Ζημιά</b></label>
                    <br>
                    <input type="radio" name="damage" value="1" <?php if($damage == 1) echo 'checked="checked"'; ?> required> Ναι
                    <input type="radio" class="radioButton" name="damage" value="0" <?php if($damage == 0) echo 'checked="checked"'; ?> required> Όχι
                </div>
                <div class="notice_input-group">
                    <label><b>Τιμή Πώλησης</b></label>
                    <br>
                    <input type="text" name="price" value="<?php echo $price; ?>" required> €
                </div>
                <div class="notice_input-group" style="margin-top: 20px;">
                    <fieldset>
                        <legend>Αλλαγή Φωτογραφίας (JPEG έως 200KB) (Να επιλεγεί υποχρεωτικά φωτογραφία)</legend>
                        <input type="file" name="file" multiple style="padding: 10px; border: black thin solid; margin-top: 5px;">
                        <br>
                        <input type="text" name="description" placeholder="Περιγραφή Φωτογραφίας" style="margin: 10px;">
                    </fieldset>
                </div>
                <br>
                <input class="notice_submit-btn" name="edit" type="submit" value="Καταχώρηση">
                <br>
            </form>
        </section>

        <section class="notice_info">
            <h2>Διαγραφή Αγγελίας</h2>
            <p>Διαγράψτε την αγγελίας σας</p>

            <form action="con_notice_delete.php" method="post">
                <label><b style="margin-right: 3px;">Αγγελία με ID:</b></label>
                <input type="number" name="laptopID" min="1" max="4294967295" value="<?php echo $laptopID; ?>" readonly required>
                <input class="notice_submit-btn" name="delete" type="submit" value="Διαγραφή" onclick="if (confirm('Είσαι σίγουρος ότι θες να διαγράψεις την αγγελία σου;')) commentDelete(1); return false">
                <br>
            </form>
        </section>

    </div>
</main>

<?php include('includes/footer.php'); ?>
