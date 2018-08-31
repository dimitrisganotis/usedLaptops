<!-- NAVIGATION -->
<nav id="navigation">
    <ul>
        <li><a <?php if($page=="Αγγελίες") { echo 'id="active"'; }?> href="page_notices.php">Αγγελίες</a></li>
        <li><a <?php if($page=="Ρυθμίσεις") { echo 'id="active"'; } ?> href="page_settings.php">Ρυθμίσεις</a></li>

        <!-- Η ΕΠΙΛΟΓΗ REGISTER/LOGIN ΔΙΝΕΤΑΙ ΜΟΝΟ ΟΤΑΝ ΔΕΝ ΕΧΕΙ ΚΑΝΕΙ LOGIN Ο ΧΡΗΣΤΗΣ -->
        <?php if(!isset($_SESSION['username'])) { ?>
            <li><a <?php if($page=="Σύνδεση Xρήστη") { echo 'id="active"'; } ?> href="page_register_login.php">Σύνδεση Xρήστη</a></li>
        <?php } else { ?>
            <li><a <?php if($page=="Αποσύνδεση Xρήστη") { echo 'id="active"'; } ?> href="con_logout.php">Αποσύνδεση Xρήστη</a></li>
        <?php } ?>
    </ul>
</nav>
      
