<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Creda Airlines</title>
    <link rel="stylesheet" href="SharedStyles.css">
    <script src="main.js"></script>
    <script src="register.js"></script>
    <script src="about.js"></script>

</head>
<body onload="mainPageLoad(0)" onclick="
  document.getElementById("searchResultsContainer").style.visibility='hidden';">

<div class="headerContainer">
    <div class="pageHeader">
        <div class="header top">
            <p id="titleText">
                Creda Airlines
            </p>
        </div>
        <div class="header search">
            <div class="search-wrapper">
                <span class="icon-search"></span>
                <form onsubmit="return validateSearch()" id="search-form">
                    <input name="searchField" id="searchField" type="text" onkeyup="performSearch(this.value)">
                </form>
            </div>
        </div>
        <div class="header bottom">
            <ul class="nav">
                <li><a href="index.php">HOME</a> </li>
                <li><a onclick="navigationItemClicked(1)" href="flights.php">FLIGHTS</a> </li>
                <li><a href="index.php">MAKE A RESERVATION</a></li>
                <li><a onclick="navigationItemClicked(3)" href="About.html">ABOUT US</a> </li>
                <li><a onclick="navigationItemClicked(4)" href="Contact.html">CONTACT</a> </li>
                <li><a onclick="navigationItemClicked(5)" href="Register.php">REGISTER</a> </li>
            </ul>
            <div class="dropdown">
                <span onclick="dropDownClicked(this)">Menu</span>
                <div id="dropdownContent" class="dropdown-content">
                    <li class="dropdown-item"><a href="index.php">Home</a> </li>
                    <li class="dropdown-item"><a href='flights.php'>Flights</a> </li>
                    <li class="dropdown-item"><a href="index.php">Make a reservation</a></li>
                    <li class="dropdown-item"><a href="About.html">About us</a> </li>
                    <li class="dropdown-item"><a href="Contact.html">Contact</a> </li>
                    <li class="dropdown-item"><a href="Register.php">Register</a> </li>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="searchResultsContainer">

</div>
<?php
session_start();

if(isset($_SESSION["username"])){
    if($_SESSION["username"]== "admin"){

        echo "<div class='row'>";
        echo "<div class='column twelve' id='user-info'>";
        echo "<button class='report'> <a class='report' href='generate_csv.php'>CSV Report </a> </button>";
        echo "<button class='report'> <a class='report' href='generate_pdf.php'>PDF Report </a> </button>";
        echo "<button class='report'> <a class='report' href='migrateToDb.php'>Migrate to Database</a> </button>";
        echo "<button class='report'> <a class='report' href='cities.php'>Manage Cities</a> </button>";
        if(isset($_REQUEST["succ"])){
          if($_REQUEST["succ"]==1){
            echo "<script>alert ('Migration was completed successfully!') </script>";
          }
          else{
            echo "<script>alert ('An error occured during migration!') </script>";
          }
        }
        echo "<button id='user-info-button'> <a href='logout.php'>Log Out </a> </button>";
        echo "<p id='user-info-p'>Logged in as admin  </p>";
        echo "</div>";
        echo "</div>";

    }
}
else{

}

?>


<div class="row main" id="subpageContainer">
    <div class="column nine main" id="news-container-div">
        <div class="column eleven news-container">
            <div class="row">
                <div class="column twelve title">
                    <p class="news-title">
                        New prices for autumn season
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="column two image">
                    <img class="news-image" src="Assets/Images/plane.jpg">
                </div>
                <div class="column ten content">
                    <p class="news-content">
                        William Howard Taft (1857–1930) was the 27th President of the United States (1909–1913)
                        and the 10th Chief Justice of the United States (1921–1930), the only person to have held
                        both offices. Taft initially served as a state and federal judge, and as governor of the
                        Philippines beginning in 1900. In 1904 Theodore Roosevelt made him Secretary of War. Taft
                        declined repeated offers to become a Supreme Court justice. He was Roosevelt's hand-picked
                        successor in 1908, and easily defeated William Jennings Bryan for the presidency jes ocami mog...
                    </p>
                </div>

            </div>

            <a class="read-more-link" href="index.php"> Read more... </a>


        </div>
        <div class="column eleven news-container">
            <div class="row">
                <div class="column twelve title">
                    <p class="news-title">
                        Creda  Airlines is hiring! Apply now!
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="column two image">
                    <img class="news-image" src="Assets/Images/people.jpg">
                </div>
                <div class="column ten content">
                    <p class="news-content">
                        William Howard Taft (1857–1930) was the 27th President of the United States (1909–1913)
                        and the 10th Chief Justice of the United States (1921–1930), the only person to have held
                        both offices. Taft initially served as a state and federal judge, and as governor of the
                        Philippines beginning in 1900. In 1904 Theodore Roosevelt made him Secretary of War. Taft
                        declined repeated offers to become a Supreme Court justice. He was Roosevelt's hand-picked
                        successor in 1908, and easily defeated William Jennings Bryan for the presidency. In the White...
                </div>
            </div>
            <a class="read-more-link" href="index.php"> Read more... </a>
        </div>
        <div class="column eleven news-container">
            <div class="row">
                <div class="column twelve title">
                    <p class="news-title">
                        All flights canceled due to fog
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="column two image">
                    <img class="news-image" src="Assets/Images/plane.jpg">
                </div>
                <div class="column ten content">
                    <p class="news-content">
                        William Howard Taft (1857–1930) was the 27th President of the United States (1909–1913)
                        and the 10th Chief Justice of the United States (1921–1930), the only person to have held
                        both offices. Taft initially served as a state and federal judge, and as governor of the
                        Philippines beginning in 1900. In 1904 Theodore Roosevelt made him Secretary of War. Taft
                        declined repeated offers to become a Supreme Court justice. He was Roosevelt's hand-picked
                        successor in 1908, and easily defeated William Jennings Bryan for the presidency jes ocami mog...
                    </p>
                </div>

            </div>

            <a class="read-more-link" href="index.php"> Read more... </a>


        </div>

    </div>

    <div class="column three right" id="login-div">

        <div class="row">
            <div class="column twelve right login">
                <div class="column ten login">
                    <form id="login-form" action="login.php" method="post" onsubmit="return validateLogin()">
                        <input onblur="validateLoginUsernameField(this)" id="login-username-textfield" name="login-username" type="text" placeholder="Username">
                        <input onblur="validateLoginPassword(this)" id="login-password-textfield" name="login-password" type="password" placeholder="Password">
                        <div class="row">
                            <div class="column twelve">
                                <p id="loginErrorField"></p>
                                <input id="login-button" type="submit" value="Log in">
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="column twelve" id="createAccDiv">
                            <a id="create-account-link" href="javascript:loadSubpage('Register.html')"> New here? Create account now. </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php

if(isset($_SESSION["username"])){
    if($_SESSION["username"]== "admin"){

        echo "<script>";
        echo "document.getElementById('login-div').style.visibility ='hidden';";
        echo "document.getElementById('login-div').style.width ='0px';";

        echo "document.getElementById('news-container-div').style.width ='100%';";

        echo "</script>";
    }
}

?>

</body>
</html>
