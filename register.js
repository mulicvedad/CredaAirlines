

function registerFormValidation() {
    var firstNameField=document.forms["registrationForm"]["registerFirstName"];
    var lastNameField=document.forms["registrationForm"]["registerLastName"];
    var emailField=document.forms["registrationForm"]["registerEmail"];
    var usernameField=document.forms["registrationForm"]["registerUsername"];
    var passwordField=document.forms["registrationForm"]["registerPassword"];
    var confirmPasswordField=document.forms["registrationForm"]["registerConfirmPassword"];
    var checkbox=document.forms["registrationForm"]["termsCheckbox"];


    var isFirstNameValid= validateFirstNameField(firstNameField);
    var isLastNameValid= validateLastNameField(lastNameField);
    var isEmailValid=validateEmail(emailField);
    var isUsernameValid=validateUsernameField(usernameField);
    var isPasswordValid= validatePassword(passwordField);
    var isConfirmPasswordValid = validateConfirmPassword(confirmPasswordField);
    if(isFirstNameValid && isLastNameValid && isEmailValid && isPasswordValid && isUsernameValid && isConfirmPasswordValid){
        if(!checkbox.checked){
            alert("You can not register unles you accept terms of service.")
            return false;
        }
        alert("You have successfully registered. Check your email for conformation")
        return true;
    }
    else{
        return false;
    }
}

function validateFirstNameField(input) {
    var reg=/^[a-zA-Z\s]+$/;
    var firstNameErrorField=document.getElementById("firstNameErrorField");

    if(input.value.match(reg)){
        firstNameErrorField.textContent="";
        return true;
    }
    else if(input.value==""){
        firstNameErrorField.textContent="This field cannot be empty!";
        return false;
    }
    else{
        firstNameErrorField.textContent="You can only use letters in this field!";
        return false;
    }
}

function validateLastNameField(input) {
    var reg=/^[a-zA-Z\s]+$/;
    var lastNameErrorField=document.getElementById("lastNameErrorField");

    if(reg.test(input.value)){
        lastNameErrorField.textContent="";
        return true;
    }
    else if(input.value==""){
        lastNameErrorField.textContent="This field cannot be empty!";
        return false;
    }
    else{
        lastNameErrorField.textContent="You can only use letters in this field!";
        return false;
    }
}

function validateUsernameField(input) {
    var reg=/^[a-zA-Z0-9_\s]+$/;
    var usernameErrorField=document.getElementById("usernameErrorField");

    if(reg.test(input.value)){
        usernameErrorField.textContent="";
        return true;
    }
    else if(input.value==""){
        usernameErrorField.textContent="This field cannot be empty!";
        return false;
    }
    else{
        usernameErrorField.textContent="Only alphanumeric symbols and underscores!";
        return false;
    }
}
function validateEmail(input) {
    var mailRegex=/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
    var emailErrorField=document.getElementById("emailErrorField");

    if(mailRegex.test(input.value)){
        emailErrorField.textContent="";
        return true;
    }
    else if(input.value==""){
        emailErrorField.textContent="This field cannot be empty!";
        return false;
    }
    else{
        emailErrorField.textContent="You mistyped your email address!";
        return false;
    }
}

function validatePassword(input) {
    var passwordErrorField=document.getElementById("passwordErrorField");
    if(input.value==""){
        passwordErrorField.textContent="Password field cannot be empty!";
        return false;
    }
    else if(input.value.length<5){
        passwordErrorField.textContent="Password must be at least 4 character long!";
        return false;
    }
    else{
        passwordErrorField.textContent="";
        return true;
    }
}

function validateConfirmPassword(input) {
    var passwordField=document.forms["registrationForm"]["registerPassword"];
    var confirmPasswordErrorField=document.getElementById("confirmPasswordErrorField");
    if(input.value==""){
        confirmPasswordErrorField.textContent="Password field cannot be empty!";
        return false;
    }
    else if(input.value.length<5){
        confirmPasswordErrorField.textContent="Password must be at least 4 character long!";
        return false;
    }
    else if(passwordField.value!=input.value) {
        confirmPasswordErrorField.textContent="Passwords don't match!";

        return false;
    }
    else{
        confirmPasswordErrorField.textContent="";
        return true;
    }
}
