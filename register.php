<?php
require "validation.php";
require "Account.php";

$firstName=$lastName=$email=$username=$password=$confirmPassword="";
$firstNameError=$lastNameError=$emailError=$usernameError=$passwordError=$confirmPasswordError="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_POST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_POST);

    if(isset($_POST["registerFirstName"]) && isset($_POST["registerLastName"]) && isset($_POST["registerEmail"]) && isset($_POST["registerUsername"])
        && isset($_POST["registerPassword"]) && isset($_POST["registerConfirmPassword"])){

        $firstName=preventXSS($_POST["registerFirstName"]);
        $lastName=preventXSS($_POST["registerLastName"]);
        $email=preventXSS($_POST["registerEmail"]);
        $username=preventXSS($_POST["registerUsername"]);
        $password=preventXSS($_POST["registerPassword"]);
        $confirmPassword=preventXSS($_POST["registerConfirmPassword"]);
        $isValid=true;
        if(!isNameValid($firstName)){
            $firstNameError="'First name' field can contain only letters and cannot be empty. <br>";
            $isValid=false;

        }
        if(!isNameValid($lastName)){
            $lastNameError="'Last name' field can contain only letters and cannot be empty. <br>";
            $isValid=false;

        }
        if(!isUsernameValid($username)){
            $usernameError="'Username' field can only contain alphanumeric symbols and cannot be empty. <br>";
            $isValid=false;

        }
        if(!isEmailValid($email)){
            $emailError="Invalid email format <br>";
            $isValid=false;

        }
        if(!isPasswordValid($password) || !isPasswordValid($confirmPassword)){
            $passwordError="'Password' fields must contain at least 4 symbols. <br>";
            $isValid=false;

        }

        if($confirmPassword != $password){
            $confirmPasswordError="Passwords do not match.";
            $isValid=false;

        }

        if($isValid){
            $account=new Account($firstName, $lastName, $email, $username);
            $account->serialize();
            $firstName="";
            $lastName="";
            $email="";
            $username="";
            $password="";
            $confirmPassword="";
        }

    }

}


?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Creda Airlines</title>
    <link rel="stylesheet" href="SharedStyles.css">
    <link rel="stylesheet" href="Register.css">
    <script src="register.js"></script>
    <script src="main.js"></script>

</head>
<body onload="mainPageLoad(5)">

<div class="headerContainer">
    <div class="pageHeader">
        <div class="header top">
            <p id="titleText">
                Creda Airlines
            </p>
        </div>
        <div class="header search">

        </div>
        <div class="header bottom">
            <ul class="nav">
                <li><a href="MainPage.php">HOME</a> </li>
                <li><a onclick="navigationItemClicked(1)" href="flights.php">FLIGHTS</a> </li>
                <li><a href="MainPage.php">MAKE A RESERVATION</a></li>
                <li><a onclick="navigationItemClicked(3)" href="About.html">ABOUT US</a> </li>
                <li><a onclick="navigationItemClicked(4)" href="Contact.html">CONTACT</a> </li>
                <li><a onclick="navigationItemClicked(5)" href="Register.php">REGISTER</a> </li>
            </ul>
            <div class="dropdown">
                <span onclick="dropDownClicked(this)">Menu</span>
                <div id="dropdownContent" class="dropdown-content">
                    <li class="dropdown-item"><a href="MainPage.php">Home</a> </li>
                    <li class="dropdown-item"><a href='flights.php'>Flights</a> </li>
                    <li class="dropdown-item"><a href="MainPage.php">Make a reservation</a></li>
                    <li class="dropdown-item"><a href="About.html">About us</a> </li>
                    <li class="dropdown-item"><a href="Contact.html">Contact</a> </li>
                    <li class="dropdown-item"><a href="Register.php">Register</a> </li>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row main">

        <div class="column eight register-container">
            <div class="row">
                <div class="column twelve register-field">
                    <p class="register-account-label">Create new account</p>
                </div>
            </div>
            <form name="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return registerFormValidation()" method="post">
                <div class="row">

                    <div class="column five register-field">
                        <p class="register-label">First name:</p>
                    </div>
                    <div class="column seven register-field">
                        <input onblur="validateFirstNameField(this)" class="register-field" name="registerFirstName" type="text" value=<?=$firstName?>>
                        <p class="errorField" id="firstNameErrorField">
                        </p>
                    </div>

                </div>
                <div class="row">

                    <div class="column five register-field">
                        <p class="register-label">Last name:</p>
                    </div>
                    <div class="column seven register-field">
                        <input onblur="validateLastNameField(this)" class="register-field" name="registerLastName" type="text" value=<?=$lastName?>>
                        <p class="errorField" id="lastNameErrorField">
                        </p>
                    </div>

                </div>
                <div class="row">

                    <div class="column five register-field">
                        <p class="register-label">Email:</p>
                    </div>
                    <div class="column seven register-field">
                        <input onblur="validateEmail(this)" class="register-field" name="registerEmail" type="text" value=<?=$email?>>
                        <p class="errorField" id="emailErrorField">
                        </p>
                    </div>

                </div>
                <div class="row">

                    <div class="column five register-field">
                        <p class="register-label">Username:</p>
                    </div>
                    <div class="column seven register-field">
                        <input onblur="validateUsernameField(this)" class="register-field" name="registerUsername" type="text" value=<?=$username?>>
                        <p class="errorField" id="usernameErrorField">
                        </p>
                    </div>

                </div>

                <div class="row">

                    <div class="column five register-field">
                        <p class="register-label">Password:</p>
                    </div>
                    <div class="column seven register-field">
                        <input onblur="validatePassword(this)" class="register-field" name="registerPassword" type="password" value=<?=$password?>>
                        <p class="errorField" id="passwordErrorField">
                        </p>
                    </div>

                </div>
                <div class="row">

                    <div class="column five register-field">
                        <p class="register-label">Confirm password:</p>
                    </div>
                    <div class="column seven register-field">
                        <input onblur="validateConfirmPassword(this)" class="register-field" name="registerConfirmPassword" type="password" value=<?=$confirmPassword?>>
                        <p class="errorField" id="confirmPasswordErrorField">
                        </p>
                    </div>

                </div>
                <div class="row">
                    <div class="column twelve create-account">
                        <input name="termsCheckbox" type="checkbox" checked> I agree on terms of service
                    </div>
                </div>
                <div class="row">
                    <div class="column twelve create-account">
                        <input name="registerButton" type="submit" value="Register">
                    </div>
                </div>
                <div class="row">
                    <div class="column twelve error-log" id="errorDiv">
                        <?php
                        echo $firstNameError;
                        echo $lastNameError;
                        echo $emailError;
                        echo $usernameError;
                        echo $passwordError;
                        echo $confirmPasswordError;
                        ?>
                    </div>
                </div>

            </form>

        </div>


</div>


</body>
</html>