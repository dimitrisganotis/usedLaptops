<?php

    //PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function getCSS() {
        //αν δεν υπάρχει σχετικό cookie, τότε ο χρήστης
        //ΔΕΝ έχει επιλέξει - δώσε το default (δηλ. το css1.css)
        if (!isset($_COOKIE['css']))
            $css='style.css';
        else
            //αλλιώς δώσε ότι λέει το cookie
            $css= $_COOKIE['css'];
        //επέστρεψε το αποτέλεσμα
        return $css;
    }

    function echo_msg() {
        if (isset($_GET['msg']))
            echo '<p style="color:red; text-align: center; font-size: 18px; margin-bottom: 15px;"><b>'.$_GET['msg'].'</b></p>';
    }

    //---------
    //PHPMailer
    //---------

    //Load Composer's autoloader
    function sendCodeViaEmail($email, $username, $activationCode) {
        require 'PHPMailer/vendor/autoload.php';
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'usedlaptopsplatform2018@gmail.com';                 // SMTP username
            $mail->Password = 'usedlaptops2018';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('usedlaptopsplatform2018@gmail.com', 'usedLaptops');
            $mail->addAddress($email, $username);     // Add a recipient

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "$username please activate your usedLaptops account";
            $mail->Body    = '<strong">Your account has been created successfully!</strong><br><br>Your activation code is: <i style="background-color: black; color: white; font-size: 1.3em; border:red thin solid;">'.$activationCode.'</i>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            header('Location: page_register_login.php?msg=Η δημιουργία του λογαριασμού ολοκληρώθηκε!<br>Συνδεθείτε για να ενεργοποιήσετε το λογαριασμό σας, μέσω του κωδικού που σας έχει αποσταλεί!');
            exit();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

?>
