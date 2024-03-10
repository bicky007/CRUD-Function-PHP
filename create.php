<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fname = $lname = $email = $cemail = $password = $gender = "";
$fname_err = $lname_err = $email_err = $cemail_err = $password_err = $gender_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Please enter a valid name.";
    } else{
        $fname = $input_fname;
    }

    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter a name.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid name.";
    } else{
        $lname = $input_lname;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter email."; 
    } elseif(!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/")))){
        $email_err = "Please enter correct email.";        
    } else{
        $email = $input_email;
    }

    $input_cemail = trim($_POST["cemail"]);
    if(empty($input_cemail)){
        $cemail_err = "Please enter email.";  
    } else{
        $cemail = $input_cemail;
        if ($cemail != $email) {
            $cemail_err = "Email Addresses do not match"; 
        }
    }
    
    // Validate password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter the Password.";     
    } elseif(!filter_var($input_password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/")))){
        $password_err = "Password should be unique.";
    } else{
        $password = $input_password;
    }

    //Validate gender

    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err = "Please select a gender.";
    } else{
    $gender = $input_gender;
    }
    
    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err) && empty($email_err) && empty($cemail_err) && empty($password_err) && empty($gender_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clients (fname, lname, email, cemail, password, gender) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_fname, $param_lname, $param_email, $param_cemail, $param_password, $param_gender);

            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_cemail = $cemail;
            $param_password = $password;
            $param_gender = $gender;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<script>
 
 function validateForm() {
      var fname = document.forms["registrationForm"]["fname"].value;
      var lname = document.forms["registrationForm"]["lname"].value;
      var email = document.forms["registrationForm"]["email"].value;
      var cemail = document.forms["registrationForm"]["cemail"].value;
      var password = document.forms["registrationForm"]["password"].value;
      var gender = document.forms["registrationForm"]["gender"].value;

      var nameRegex = /^[a-zA-Z ]+$/;
      var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      var passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;

      if (!fname.match(nameRegex)) {
        alert("Please enter a valid first name.");
        return false;
      }

      if (!lname.match(nameRegex)) {
        alert("Please enter a valid last name.");
        return false;
      }

      if (!email.match(emailRegex)) {
        alert("Please enter a valid email address.");
        return false;
      }

      if (email !== cemail) {
        alert("Email addresses do not match.");
        return false;
      }

      if (!password.match(passwordRegex)) {
        alert("Please enter a valid password. It should be at least 8 characters long and contain at least one number and one special character.");
        return false;
      }
      
      if (gender === "") {
        alert("Please select a gender.");
        return false;
     }
      
      return true;
    }

</script>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 text-center">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form name="registrationForm" onsubmit="return validateForm()"
                          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" autocomplete="off" name="fname" class="form-control   <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                            <span class="invalid-feedback"><?php echo $fname_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" autocomplete="off" name="lname" class="form-control  <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                            <span class="invalid-feedback"><?php echo $lname_err;?></span>
                        </div>


                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" autocomplete="off" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Confirm Email</label>
                            <input type="text" autocomplete="off" name="cemail" class="form-control <?php echo (!empty($cemail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cemail; ?>">
                            <span class="invalid-feedback"><?php echo $cemail_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>   
                        <div class="form-group">
                        <label>Gender</label>
                          <select name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>">
                             <option value="">Select Gender</option>
                             <option value="male" <?php if($gender === 'male') echo 'selected'; ?>>Male</option>
                             <option value="female" <?php if($gender === 'female') echo 'selected'; ?>>Female</option>
                             <option value="other" <?php if($gender === 'other') echo 'selected'; ?>>Other</option>
                             </select>
                            <span class="invalid-feedback"><?php echo $gender_err;?></span>
                        
                         </div>
                        <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                       </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>