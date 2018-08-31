<?php

    session_start();

    //Αν είναι συνδεδεμένος απο λογαριασμό μη ενεργοποιημένο να γίνεται αποσύνδεση
    if(isset($_SESSION['username'], $_SESSION['status']) && $_SESSION['status'] == 0) {
        header("Location: con_logout.php");
    }

    $page = 'Αρχική';
    $title = "$page | usedLaptops";
	include('includes/header.php');

?>

<!-- MAIN -->
<main id="main">

    <div class="container">
        <section id="showcase">
            <h2>Καλώς ήρθατε στο usedLaptops, την on-line υπηρεσία μεταχειρισμένων laptops!</h2>
            <p>Μπορείτε να ψάξετε το κατάλογο, ώστε να δείτε πληροφορίες για τις καταχωρημένες προς πώληση αγγελίες laptop.</p>
            <p>Αν επιθυμείτε να καταχωρήσετε την δική σας αγγελία, αρκεί να κάνετε εγγραφή στην υπηρεσία μας!</p>
        </section>

        <section id="news">
            <div class="box">
                <h2>Τελευταία Νέα</h2>
                <ul>
                    <li>Εγγραφές χρηστών</li>
                    <li>Καταχωρήσεις αγγελιών</li>
                    <li> --- </li>
                </ul>
            </div>
        </section>

        <section id="contact">
            <div class="box">
                <h2>Επικοινωνία</h2>
                <ul>
                    <li><b>Διεύθυνση</b>: Λάρισα, Ελλάδα</li>
                    <li><b>Email</b>: info@usedlaptops.gr</li>
                    <li><b>Τηλέφωνο</b>: 6969696969</li>
                </ul>
        </section>

        <section id="follow">
            <div class="box">
                <h2>Ακολουθήστε μας</h2>
                <ul>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
        </section>
    </div>
</main>

<?php include('includes/footer.php'); ?>