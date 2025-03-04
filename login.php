<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}
 
// Include config file
require_once "includes/connection.php";
$page_name = 'login';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  // Check if username is empty
  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter username.";
  } else{
    $username = trim($_POST["username"]);
  }
  
  // Check if password is empty
  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter your password.";
  } else{
    $password = trim($_POST["password"]);
  }
  
  // Validate credentials
  if(empty($username_err) && empty($password_err)){
    // Prepare a select statement
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    
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
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
          if(mysqli_stmt_fetch($stmt)){
            if(password_verify($password, $hashed_password)){
              // Password is correct, so start a new session
              session_start();
              
              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;

              // Redirect user to welcome page
              if(isset($_SESSION['current_page'])) {
                header('location: ' . $_SESSION['current_page']);
              } else {
                header('location: index.php');
              }
              //echo $_SESSION['current_page'];
            } else{
              // Display an error message if password is not valid
              $password_err = "The password you entered was not valid.";
            }
          }
        } else{
          // Display an error message if username doesn't exist
          $username_err = "No account found with that username.";
        }
      } else{
          echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }
  
  // Close connection
  mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Masjid Jam'Iyyatul Muslimin | Login</title>

  <?php include 'includes/head.php';?>
</head>
<body>
  <header>
    <?php include('includes/header.php'); ?> 
  </header>
  <main>
    <div class="py-5">
      <div class="wrapper">
        <h1 class="h4 pt-4">Login</h1>
        <div class="row">
          <div class="col-md-4">
            <p>Please fill in your credentials to login.</p>
            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-item <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Username</label>
                <div class="field-wrap">
                  <input type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div class="form-text text-danger"><em><?php echo $username_err; ?></em></div>
              </div>    
              <div class="form-item <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Password</label>
                <div class="field-wrap">
                  <input type="password" name="password">
                </div>
                <div class="form-text text-danger"><em><?php echo $password_err; ?></em></div>
              </div>
              <div class="form-item">
                <button class="btn button-1" type="submit">Submit</button>
              </div>
              <!--p>Don't have an account? <a href="register.php">Sign up now</a>.</p-->
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>  
</body>
</html>