function email_validation(str) {
    var result = true;
    var ampersatPos = str.indexOf("@");    //η θεση του @ στο str
    var dotPos = str.indexOf(".");         //η θεση της . στο str
    var dotPosAfterAmpersat = str.indexOf(".", ampersatPos); //θεση της . μετά το @

    if (ampersatPos <= 0)
        result = false;
    if (dotPos < 0)
        result = false;
    if (dotPosAfterAmpersat-ampersatPos == 1)
        result = false;
    if (str.indexOf(".") == 0 || str.lastIndexOf(".") == str.length-1)
        result = false;

    return result;
}

function validate_form() {

    var result = true;
    var errorMessage = '';
    var illegalChars = new RegExp("/\W/");

    //έλεγχος username
    var username = document.getElementById("username").value;
    if (illegalChars.test(username) || username.length > 25) {
        result=false;
        errorMessage = errorMessage + "Στο username επιτρέπονται έως 25 επιτρεπτοί χαρακτήρες!\n";
    }

    //έλεγχος email
    var email = document.getElementById("email").value;
    if (!email_validation(email)) {
        result=false;
        errorMessage = errorMessage + "Το email δεν είναι αποδεκτό!\n";
    }

    //έλεγχος password
    var password = document.getElementById("password").value;
    if (illegalChars.test(password) || password.length < 10) {
        result=false;
        errorMessage = errorMessage + "Το password να είναι πάνω από 10 επιτρεπτοί χαρακτήρες!\n"
    }

    //έλεγχος phone
    var phone = document.getElementById("phone").value;
    if (phone.length != 10|| isNaN(phone)) {
        result=false;
        errorMessage = errorMessage + "Μη αποδεκτό phone!\n";
    }

    // ----- ΤΕΛΟΣ ΕΛΕΓΧΩΝ -------------------------------------------------

    // αν έχει καταγραφεί errorMessage τύπωσε alert
    if (errorMessage!=='')
        alert(errorMessage);

    return result;
}
