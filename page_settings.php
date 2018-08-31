<?php

    session_start();

    //Αν είναι συνδεδεμένος απο λογαριασμό μη ενεργοποιημένο να γίνεται αποσύνδεση
    if(isset($_SESSION['username'], $_SESSION['status']) && $_SESSION['status'] == 0) {
        header("Location: con_logout.php");
    }

    require('includes/database.php');

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $userID = $_SESSION['userID'];
        try {
            $sql = 'SELECT email, phone FROM users WHERE userID = '.$userID;
            $stmt = $pdo->query($sql);

            while($record = $stmt->fetch()) {
                $email = $record['email'];
                $phone = $record['phone'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    } else
        $username = null;

    $page = 'Ρυθμίσεις';
    $title = "$page | usedLaptops";
    include('includes/header.php');

?>

<!-- MAIN -->
<main id="main">

<!-- PATH -->
<div id="path">
    <div class="container">
        <a href="/">Αρχική</a>
        //
        <a href="/page_settings.php"><?php echo $page ?></a>
    </div>
</div>

<div class="container">

    <?php echo_msg(); ?>

    <?php
        if($username != null) {
    ?>

    <section class="register-login" style="width: 100%; min-height: 0px; margin: 0 auto 20px auto;">
        <div class="images">
            <img src="/images/login.png" alt="Εικονίδιο Προσθήκης Χρήστη">
        </div>
        <h2>Αλλαγή Στοιχείων Χρήστη</h2>

        <form class="credentials" action="con_settings.php" method="post">
            <div class="input-group">
                <label><b>Username</b></label>
                <input type="text" name="username" placeholder="Εισάγετε όνομα χρήστη" pattern="[A-Za-z]+[A-Za-z0-9_]*[A-Za-z0-9]+" title="Το username να ξεκινάει με λατινικό χαρακτήρα και να τελειώνει με λατινικό χαρακτήρα ή ψηφίο!" value="<?php echo $_SESSION['username']; ?>" required>
            </div>
            <div class="input-group">
                <label><b>Email</b></label>
                <input type="email" name="email" placeholder="Εισάγετε email" value="<?php echo $email; ?>" required>
            </div>
            <div class="input-group">
                <label><b>Password</b></label>
                <input type="password" name="password" placeholder="Εισάγετε καινούργιο κωδικό"
                       pattern="[A-Za-z0-9_]{10,}" title="Το password να έχει μήκος τουλάχιστον 10 χαρακτήρες!"
                       required>
            </div>
            <div class="input-group">
                <label><b>Phone</b></label>
                <input type="text" name="phone" placeholder="Εισάγετε το τηλέφωνο" pattern="\d{10}"
                       title="Το νούμερο να αποοτελείται από 10 ψηφία" value="<?php echo $phone; ?>" required>
            </div>
            <br>
            <input class="submit-btn" name="change" type="submit" value="Αλλαγή">
            <br>
        </form>
    </section>

    <?php
        try {
            $sql = 'SELECT laptopID FROM laptops, users WHERE users.userID = laptops.userID AND users.userID ='.$userID;
            $stmt = $pdo->query($sql);

            //Ο χρηστης έχει αγγελία
            if($stmt->rowCount() > 0) {
                $record = $stmt->fetch();
                echo '<section id="edit-notice">';
                echo '<h2>Επεξεργασία Αγγελίας</h2>';
                echo '<a href="page_notice_edit.php?laptopID='.$record['laptopID'].'" style="text-decoration: underline;">'.'Επεξεργασία</a>';
                echo '</section>';
            }

            $stmt->closeCursor();
            $pdo = null;

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
        }
    ?>

    <section id="colors">
        <h2>Αλλαγή Θέματος</h2>
        <?php
        //εκτύπωση της τρέχουσας επιλογής για εκπαιδευτικούς λόγους
        if (!isset($_COOKIE['css'])) {
            echo '<p>Τρέχουσα Επιλογή: default</p>';
        } else {
            echo '<p>Τρέχουσα Επιλογή: '.getCSS().'</p>';
        }
        ?>
        <ul>
            <li><a href="con_style.php?style=1">default</a></li>
            <li><a href="con_style.php?style=2">Light</a></li>
            <li><a href="con_style.php?style=3">Dark</a></li>
        </ul>
    </section>

</div>

<?php include('includes/footer.php'); ?>