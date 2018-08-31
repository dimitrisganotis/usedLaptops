<?php

    session_start();

    //Αν είναι συνδεδεμένος απο λογαριασμό μη ενεργοποιημένο να γίνεται αποσύνδεση
    if(isset($_SESSION['username'], $_SESSION['status']) && $_SESSION['status'] == 0) {
        header("Location: con_logout.php");
    }

    if(isset($_SESSION['username']))
        $username = $_SESSION['username'];
    else
        $username = null;

    $page = 'Αγγελίες';
    $title = "$page | usedLaptops";
    include('includes/header.php');
    require('includes/database.php');

    $recordsPerPage = 4;
    //Ποιά είναι η τρέχουσα σελίδα?
    if (isset($_GET['page']))   //αν υπάρχει παράμετρος στο URL
        $curPage = $_GET['page']; //τότε ότι λέει η παράμετρος
    else                        //διαφορετικά είναι η πρώτη σελίδα
        $curPage = 1;

    //Υπολόγισε τον δείκτη της πρώτης από τις εγγραφές που θέλουμε
    $startIndex = ($curPage-1) * $recordsPerPage;

    //Εαν πατήσαμε το search button
    if(isset($_GET['submit'])) {
        $search = $_GET['search'];

        $sql = "SELECT count(laptopID) as recCount FROM users, laptops WHERE users.userID = laptops.userID  AND (username LIKE '%$search%' OR brand LIKE '%$search%' OR model LIKE '%$search%' OR price LIKE '%$search%')";
        $stmt = $pdo->query($sql);
        $record = $stmt->fetch();
        // υπολογισμός πλήθους σελίδων
        $count = $record['recCount'];
        $pages = ceil($record['recCount'] / $recordsPerPage);  //ceil -> στογγύλεμα προς τα πάνω
    } else {
        header("Location: page_notices.php");
        exit();
    }


?>

<!-- MAIN -->
<main id="main">

    <!-- PATH -->
    <div id="path">
        <div class="container">
            <a href="/">Αρχική</a>
            //
            <a href="/page_notices.php"><?php echo $page ?></a>
        </div>
    </div>

    <div class="container">

        <section class="search_addNotice">
            <form action="page_notices_search.php" method="get">
                <input id="search" type="text" name="search" value="<?php echo $search ?>">
                <input id="button" type="submit" name="submit" value="Αναζήτηση">
            </form>
        </section>

        <section class="search_addNotice">
            <a href="page_notice_add.php">Καταχώρηση Αγγελίας</a>
        </section>

        <!--
        <section id="filters">
            <form action="page_notices_filters.php" method="get" style="clear: both;">
                <fieldset>
                    <legend style="font-size: 1.4em;">| Φίλτρα |</legend>
                    <div class="filter">
                        <h3>Μάρκα</h3>
                        <label><input type="radio" name="brand" value="Apple"> Apple</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="Microsoft"> Microsoft</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="Dell"> Dell</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="HP"> HP</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="Lenovo"> Lenovo</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="Asus"> Asus</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="Acer"> Acer</label>
                    </div>
                    <div class="filter">
                        <h3>Πυρήνες Επεξεργαστή</h3>
                        <label><input type="radio" name="cpuCores" value="1"> 1</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="2"> 2</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="4"> 4</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="6"> 6</label>
                        <label><input class="buttonMarginLeft" type="radio" name="brand" value="8"> 8</label>
                    </div>
                    <div class="filter">
                        <h3>Μνήμη RAM</h3>
                        <label><input type="radio" name="ramSize" value="2"> 2 GB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="ramSize" value="4"> 4 GB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="ramSize" value="6"> 6 GB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="ramSize" value="8"> 8 GB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="ramSize" value="16"> 16 GB</label>
                    </div>
                    <div class="filter">
                        <h3>Χωρητικότητα Αποθήκευσης</h3>
                        <label><input type="radio" name="storageSize" value="250"> 250 GB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="storageSize" value="500"> 500 GB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="storageSize" value="1000"> 1 TB</label>
                        <label><input class="buttonMarginLeft" type="radio" name="storageSize" value="2000"> 2 TB</label>
                    </div>
                    <div class="filter">
                        <h3>Λειτουργικό Σύστημα</h3>
                        <label><input type="radio" name="os" value="Windows 7/8/8.1/10"> Windows 7/8/8.1/10</label>
                        <label><input class="buttonMarginLeft" type="radio" name="storageSize" value="MacOS"> MacOS</label>
                        <label><input class="buttonMarginLeft" type="radio" name="storageSize" value="Linux"> Linux</label>
                        <label><input class="buttonMarginLeft" type="radio" name="storageSize" value="No OS"> Χωρίς Λειτουργικό Σύστημα</label>
                    </div>
                    <div class="filter">
                        <h3>Ζημιά</h3>
                        <label><input type="radio" name="damage" value="1"> Ναι</label>
                        <label><input class="buttonMarginLeft" type="radio" name="damage" value="0"> Όχι</label>
                    </div>
                    <div class="filter">
                        <input id="filters-button" type="submit" name="submit" value="Αναζήτηση">
                    </div>
                </fieldset>
            </form>
        </section>
        -->


        <?php if($count == 0) {
            echo '';
        } else { ?>
            <section class="pages">
            <p>
            <?php
            for ($i = 1; $i <= $pages; $i++) {
                // εάν δεν είναι η τρέχουσα σελίδα, φτιάξε link
                if ($i <> $curPage) { ?>
                    <a href="page_notices_search.php?search=<?php echo $search ?>&submit=Αναζήτηση&page=<?php echo $i ?>"><?php echo $i ?></a>&nbsp;&nbsp;

                    <?php // αν είναι η τρέχουσα σελίδα, τύπωσε απλά τον αριθμό της
                } else
                    echo $i . "&nbsp;&nbsp;";
            }
        }
        ?>
            </p>
        </section>

        <section id="notices">
            <?php

            if($count == 0) {
                echo '<p style="text-align: center; margin: 15px 0; font-weight: bold;">Δεν βρέθηκε αγγελία</p>';
            }

            try {
                $sqlSearch = "SELECT laptops.laptopID, username, brand, model, damage, price, dateOfUpdate, name FROM users, laptops, images WHERE users.userID = laptops.userID AND laptops.laptopID = images.laptopID AND (username LIKE '%$search%' OR brand LIKE '%$search%' OR model LIKE '%$search%' OR price LIKE '%$search%') ORDER BY dateOfUpdate DESC LIMIT $startIndex, $recordsPerPage";
                $stmt = $pdo->query($sqlSearch);

                while($record = $stmt->fetch()) {
                    echo '<div class="result">';

                    echo '<a class="laptop_image" href="page_notice_details.php?laptopID='.$record['laptopID'].'" title="Περισσότερες πληροφορίες για την αγγελία" style="background-image: url(/images/uploads/'.$record['name'].'.jpg);"></a>';

                    echo '<div class="information">';
                    echo '<a class="title" href="page_notice_details.php?laptopID='.$record['laptopID'].'">'.$record['brand'].' '.$record['model'].' - '.$record['price'].'€ </a>';

                    //Εαν είναι συνδεδεμένος να μπορεί να επεξεργαστεί την αγγελία του
                    if($username == $record['username']) {
                        echo '<br><a href="page_notice_edit.php?laptopID='.$record['laptopID'].'" style="text-decoration: underline">'.'[Επεξεργασία Αγγελίας]</a>';
                    }

                    echo '<p style="margin-top: 15px;">Χρήστης: '.$record['username'].'</p>';
                    echo '<p>Υποβλήθηκε/Ανανεώθηκε: '.$record['dateOfUpdate'].'</p>';

                    if($record['damage'] == 0)
                        echo '<p>Ζημιά: ΟΧΙ</p>';
                    else if ($record['damage'] == 1)
                        echo '<p>Ζημιά: NAI</p>';

                    echo '</div></div>';
                }

                $stmt->closeCursor();
                $pdo = null;
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
            ?>
        </section>

        <?php if($count == 0) {
            echo '';
        } else { ?>
        <section class="pages">
            <p>
                <?php
                for ($i = 1; $i <= $pages; $i++) {
                    // εάν δεν είναι η τρέχουσα σελίδα, φτιάξε link
                    if ($i <> $curPage) { ?>
                        <a href="page_notices_search.php?search=<?php echo $search ?>&submit=Αναζήτηση&page=<?php echo $i ?>"><?php echo $i ?></a>&nbsp;&nbsp;

                        <?php // αν είναι η τρέχουσα σελίδα, τύπωσε απλά τον αριθμό της
                    } else
                        echo $i . "&nbsp;&nbsp;";
                }
                }
                ?>
            </p>
        </section>

    </div>

</main>

<?php include('includes/footer.php'); ?>
