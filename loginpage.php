<!DOCTYPE html PUBLIC>
<?php session_start(); ?>

<?php

// Initialise error messages
$usernameErr=$passwordErr=$loginErr="";

if(!isset($_POST["signIn"])) {
    // Do nothing since no $_POST variables created i.e. no signIn form submission
}
else {
    // Instantiate Session variables upon successful login
    function createSession($userID, $username) {
        $_SESSION["userID"] = $userID;
        $_SESSION["username"] = $username;
        // echo $_SESSION["userID"]."<br>";
        // echo $_SESSION["username"]."<br>";
    }        

    // Recognise user input
    function hasDataInput($usernameErr,$passwordErr) {
        
        if (!isset($_POST['userName']) or trim($_POST['userName']) == '') {
            $usernameErr = 'Please enter a valid username';
            return FALSE;
        }
        elseif (!isset($_POST['passWord']) or trim($_POST['passWord']) == '') {
            $passwordErr = 'Please enter a valid password';
            return FALSE;
        }
        
        if ($usernameErr == "" and $passwordErr == "") {
            // echo $_POST['userName'] . " and " . $_POST['passWord'] ." successfully submitted to server-side validation"."<br>"; // Delete this ########
            return TRUE;
        }
    }
        
    // Validation process
    if (hasDataInput($usernameErr,$passwordErr) == TRUE) {
        
        include './database.php';                                                                                                                                                  

        // Step 1 - Sanitise username and password and Instantiate from $_POST array
        $username = trim($_POST["userName"]);
        $username = mysqli_escape_string($connection, $username);
        $user_pass = trim($_POST["passWord"]);
        // echo $username."<br>";
        // echo $user_pass."<br>";

        // Step 2 - Search for username and password in users database

        // Search for username in users table
        $sql_users = "SELECT username FROM users WHERE username = ?";
        $result_users = mysqli_prepare($connection, $sql_users);
        mysqli_stmt_bind_param($result_users, 's', $username);
        mysqli_stmt_execute($result_users);
        $result = mysqli_stmt_get_result($result_users);
        $rows_users = ($result->num_rows);
        if ($rows_users > 0) {
            // echo $rows_users;
        }
        // echo "connected to users" . "<br>";

        // Username found in users table
        if ($rows_users == 1) {
            // echo ($username . " has been found in users table" . "<br>"); // Delete this ########
            
            // Check if password matches in users table
            $sql_users_pw = "SELECT * FROM users WHERE username = ?";
            $result_users_pw = mysqli_prepare($connection, $sql_users_pw);
            mysqli_stmt_bind_param($result_users_pw, 's', $username);
            mysqli_stmt_execute($result_users_pw);
            $result = mysqli_stmt_get_result($result_users_pw);
            
            while($row = $result->fetch_assoc()) {
                if (password_verify($user_pass, $row["password1"])) {
                    // echo "Successfully logged in"."<br>";
                    $userID = $row["userID"]; 
                    createSession($userID, $username);
                    // echo "Successfully created Session variable"."<br>";

                    $host  = $_SERVER['HTTP_HOST'];
                    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                    $extra = 'index.php';
                    $link="http://".$host.$uri."/".$extra;
                
                    header("Location: http://$host$uri/$extra");
                }
                else {
                    $loginErr = "Invalid username and password entered.";
                    // echo "Invalid password entered"."<br>";
                }
            }
        }
        else {
            $loginErr = $username . " is not a registered user. Please register as a new user." . "<br>"; // Delete this ########
            // echo ($username . " is not registered in the database. Do you wish to register as a new user?" . "<br>"); // Delete this ########
        }
    }
    else {
        $loginErr = "Invalid username or password entered.";
        // echo "Data did not pass validation";
    }
}
?>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-type" content="text/html"; charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Team 10 eBay - Login</title>
    </head>
    <body>

        <div align="center">
        <h3> Please log in </h3>
        <form name="login_form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <label for="userName">Username:</label><br>
        <input type="text" name="userName" placeholder="Username" pattern=".{3,}" required title="Minimum 3 characters or more"><span id="error_userName"></span>
        <span class="error"> <?php echo $usernameErr;?></span>
        <br>
        <br>
        <label for="passWord">Password:</label><br>
        <input type="password" name="passWord" placeholder="Password" pattern=".{6,}" required title="Minimum 6 characters or more"><span id="error_passWord"></span>
        <span class="error"> <?php echo $passwordErr;?></span>
        <br>
        <br>
        <p><input type="submit" onclick="return validateForm(this)" name="signIn" value="Sign in"> 
        <button onclick="window.location.href = './regNewUser.php';" type="button" name="regNewUser">Sign Up</button> </p>
        <br>
        <span class="error"> <?php echo $loginErr;?></span>
        </form>
        </div>
            
    </body>
</html>