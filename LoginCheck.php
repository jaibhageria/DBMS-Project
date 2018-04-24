<?php
// Include config file
include 'Config.php';
session_start();
// Define variables and initialize with empty values
$username = $password = "";
$login_username_err = $login_password_err = "";
$usertype = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $login_username_err = 'Please enter username.';
        $_SESSION["login_username_error"] = $login_username_err;
        header("location: Login_Page.php");
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $login_password_err = 'Please enter your password.';
        $_SESSION["login_password_error"] = $login_password_err;
        header("location: Login_Page.php");
    } else{
        $password = trim($_POST['password']);
    }
	
	$usertype = trim($_POST['usertype']);

    // Validate credentials
    if(empty($login_username_err) && empty($login_password_err)){
		if($usertype == "Customer"){
        // Prepare a select statement
           $sql = "SELECT Username, Password FROM user WHERE Username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $user_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password == $user_password){
                            header("location: Customer.php");
                        } else{
                            // Display an error message if password is not valid
                            $login_password_err = 'The password you entered was not valid.';
                            $_SESSION["login_password_error"] = $login_password_err;
                            header("location: Login_Page.php");
                        }
                    }
                } else{

                    // Display an error message if username doesn't exist
                    $login_username_err = 'No account found with that username.';
                    $_SESSION["login_username_error"] = $login_username_err;
                    header("location: Login_Page.php");
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
	
	if($usertype == 'Admin'){
        
		    if($username=='admin' && $password=='12345'){
			  header("location: Admin.php");
			}
             else{
				    $login_username_err = 'You are not the admin we know..sorry!!';
                    $_SESSION["login_username_error"] = $login_username_err;
                    header("location: Login_Page.php");
            }
        }

    }

    // Close connection
    mysqli_close($conn);
}
?>
