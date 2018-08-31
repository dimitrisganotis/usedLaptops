<?php

    session_start();

    //Αν είναι ήδη συνδεδεμλένος να μην έχει πρόσβαση στη συγκεκριμένη σελίδα
    if (isset($_SESSION['username'], $_SESSION['status'])) {
        header("Location: /");
        exit();
    }

    $page = 'Σύνδεση Xρήστη';
    $title = "$page | usedLaptops";
    include('includes/header.php');

?>

<script type="text/javascript">
    function myAJAXCall(username) {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp=new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        else {
            alert("Your browser does not support XMLHTTP!");
        }

        var d = new Date();
        var url= "con_ajax.php?foo="+d;

        //-----υποβολή ερωτήματος στον server-----
        xmlhttp.open("POST",url,true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("username="+username);

        xmlhttp.onreadystatechange=function() {
            if(xmlhttp.readyState==4 && xmlhttp.status==200) {
                document.getElementById("username").innerHTML= xmlhttp.responseText;
            } else
                document.getElementById("username").innerHTML= "Μη αποδεκτή απάντηση<br/>στην AJAX κλίση!";
        }
    }
</script>

<!-- MAIN -->
<main id="main">

    <!-- PATH -->
    <div id="path">
        <div class="container">
            <a href="/">Αρχική</a>
            //
            <a href="/page_register_login.php"><?php echo $page ?></a>
        </div>
    </div>

    <div class="container">

        <?php echo_msg(); ?>

        <section class="register-login">
			<div class="images">
				<img src="/images/add-user.png" alt="Εικονίδιο Προσθήκης Χρήστη">
			</div>
			<h2>Εγγραφή μέλους</h2>
			<p>Συμπληρώστε τη φόρμα για να κάνετε εγγραφή!</p>

            <script type="text/javascript" src="includes/functions.js"></script>
			
			<form class="credentials" action="con_register.php" method="post" onsubmit="return validate_form();">
				<div class="input-group">
					<label><b>Username</b></label>
					<input id="username" type="text" name="username" placeholder="Εισάγετε όνομα χρήστη" pattern="[A-Za-z]+[A-Za-z0-9_]*[A-Za-z0-9]+" title="Το username να ξεκινάει με λατινικό χαρακτήρα και να τελειώνει με λατινικό χαρακτήρα ή ψηφίο!" required onclick="myAJAXCall(this.value)">
				</div>
				<div class="input-group">
					<label><b>Email</b></label>
					<input id="email" type="email" name="email" placeholder="Εισάγετε email" required>
				</div>
				<div class="input-group">
					<label><b>Password</b></label>
					<input id="password" type="password" name="password" placeholder="Εισάγετε κωδικό" pattern="[A-Za-z0-9_]{10,}" title="Το password να έχει μήκος τουλάχιστον 10 χαρακτήρες!" required>
				</div>
				<div class="input-group">
					<label><b>Phone</b></label>
					<input id="phone" type="text" name="phone" placeholder="Εισάγετε το τηλέφωνο" pattern="\d{10}" title="Το νούμερο να αποοτελείται από 10 ψηφία" required>
				</div>
                <br><img id="captcha-img" src="includes/captcha.php"><br>
                <input class="captcha-input" name="captcha" type="text" placeholder="Εισάγετε το CAPTCHA" required><br><br>
                <input class="submit-btn" name="register" type="submit" value="Εγγραφή">
                <br>
            </form>
		</section>


        <section class="register-login">
			<div class="images">
				<img src="/images/login.png" alt="Εικονίδιο Προσθήκης Χρήστη">
			</div>
			<h2>Είσοδος μέλους</h2>
			<p>Καλωσήρθατε στο usedLaptops, παρακαλώ συνδεθείτε!</p>
			
			<form class="credentials" action="con_login.php" method="post">
				<div class="input-group">
                    <label><b>Username</b></label>
                    <input type="text" name="username" placeholder="Εισάγετε το όνομα χρήστη" required>
				</div>
				<div class="input-group">
					<label><b>Password</b></label>
					<input type="password" name="password" placeholder="Εισάγετε το κωδικό" required>
				</div>
                <br><img id="captcha-img" src="includes/captcha.php"><br>
                <input class="captcha-input" name="captcha" type="text" placeholder="Εισάγετε το CAPTCHA" required><br><br>
                <input class="submit-btn" name="login" type="submit" value="Σύνδεση">
                <br>
			</form>

			<br><br>
			<p>Υπάρχει κάποιο πρόβλημα με τη σύνδεση σου;<br>Επικοινώνησε μαζί μας!</p>
        </section>

        <section id="info">
            <h3>Επιτρέπονται μόνο λατινικοί χαρακτήρες, ψηφία και η κάτω παύλα.</h3>
        </section>

    </div>
</main>

<?php include('includes/footer.php'); ?>

