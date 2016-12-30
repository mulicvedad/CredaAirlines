var isDropdownActive = false;
function mainPageLoad(num) {
    var body = document.getElementsByTagName("body")[0];
    body.addEventListener("click", bodyContentClicked, true);
    navigationItemClicked(num);

}
function loadSubpage(pageUrl) {
    var ajax=new XMLHttpRequest();
    if(isDropdownActive){
        isDropdownActive=false;
        dropdownContent.style.display = "none";
    }
    ajax.onreadystatechange=function () {
        if (ajax.readyState == 4) {
            if(ajax.status==200){
                document.getElementById("subpageContainer").innerHTML= ajax.responseText;
            }
            else if(ajax.status==404){
                alert("Subpage " + pageUrl + " not found.");
            }
            else{
                alert("Error occured.");
            }
        }


    }
    ajax.open("GET",pageUrl,true);
    ajax.send();
}

function navigationItemClicked(itemIndex) {
    var navigationDiv=document.getElementsByClassName("nav")[0];
    var navigationItems=navigationDiv.getElementsByTagName("a");
    var i;
    for(i=0;i<navigationItems.length;i++){
        var currentItem=navigationItems[i];
        if(i==itemIndex){
            currentItem.style.color="white";
            currentItem.style.backgroundColor="#4c4b48";
            currentItem.style.paddingBottom="6px";
            currentItem.style.borderBottom="4px solid lightblue";
        }
        else{
            currentItem.style.color="white";
            currentItem.style.backgroundColor="#898885";
            currentItem.style.paddingBottom="10px";
            currentItem.style.borderBottom="0px solid lightblue";
        }
    }
}

function navigationItemDragBegan(itemIndex) {
    var navigationDiv=document.getElementsByClassName("nav")[0];
    var navigationItems=navigationDiv.getElementsByTagName("a");
    var currentItem=navigationItems[itemIndex];
    currentItem.style.color="white";
    currentItem.style.backgroundColor="#4c4b48";
    currentItem.style.paddingBottom="6px";
    currentItem.style.borderBottom="4px solid lightblue";
}

function navigationItemDragEnded(itemIndex) {
    var navigationDiv=document.getElementsByClassName("nav")[0];
    var navigationItems=navigationDiv.getElementsByTagName("a");
    var currentItem=navigationItems[itemIndex];
    currentItem.style.color="white";
    currentItem.style.backgroundColor="#898885";
    currentItem.style.paddingBottom="10px";
    currentItem.style.borderBottom="0px solid lightblue";

}
function validateLogin() {
    var usernameField = document.forms["login-form"]["login-username-textfield"];
    var passwordField = document.forms["login-form"]["login-password-textfield"];

    var isUsernameValid=validateLoginUsernameField(usernameField);
    var isPasswordValid = validateLoginPassword(passwordField);

    if(isUsernameValid && isPasswordValid){
        //login logic
        return true;
    }
    else{
        return false;
    }
}
function validateLoginUsernameField(input) {
    var reg=/^[a-zA-Z0-9_\s]+$/;
    var usernameErrorField=document.getElementById("loginErrorField");

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


function validateLoginPassword(input) {
    var passwordErrorField=document.getElementById("loginErrorField");
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


function validateSearch(input) {
    var searchField = document.getElementsByName("searchField")[0];

    if(searchField.value == ""){
        searchField.placeholder="Type text...";
        return false;
    }
    else{
        searchField.placeholder="";
        return true;
    }


}

function dropDownClicked(item) {
    var dropdownContent = document.getElementById("dropdownContent");

    if(!isDropdownActive){
        isDropdownActive=true;
        dropdownContent.style.display = "block";
    }
    else {
        isDropdownActive=false;
        dropdownContent.style.display = "none";
    }
}

function bodyContentClicked() {
    if(isDropdownActive){
        isDropdownActive=false;
        dropdownContent.style.display = "none";
    }
}

function performSearch(searchString) {

    if(searchString.length==0){
        document.getElementById("searchResultsContainer").innerHTML="";
        document.getElementById("searchResultsContainer").style.visibility="hidden";
        return;
    }
    ajax=new XMLHttpRequest();

    ajax.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            document.getElementById("searchResultsContainer").innerHTML=this.responseText;
            document.getElementById("searchResultsContainer").style.visibility="visible";
        }
    }

    ajax.open("GET","search.php?query="+searchString,true);
    ajax.send();

}