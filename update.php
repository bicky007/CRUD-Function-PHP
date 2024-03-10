<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fname = $lname = $email = $cemail = $password = $gender = "";
$fname_err = $lname_err = $email_err = $cemail_err = $password_err = $gender_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter a name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Name should containt only characters.";
    } else{
        $fname = $input_fname;
    }

    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter a name.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Name should containt only characters.";
    } else{
        $lname = $input_lname;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email."; 
    } elseif(!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/")))){
        $email_err = "Please enter a valid email.";        
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
        $password_err = "Please enter the password.";     
    } elseif(!filter_var($input_password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/")))){
        $password_err = "Please enter a unique password.";
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
        // Prepare an update statement
        $sql = "UPDATE clients SET fname=?, lname=?, email=?, cemail=?, password=?, gender=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_fname , $param_lname, $param_email, $param_cemail, $param_password, $param_gender, $param_id);
            
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_cemail = $cemail;
            $param_password = $password;
            $param_gender = $gender;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM clients WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $fname = $row["fname"];
                    $lname = $row["lname"];
                    $email = $row["email"];
                    $cemail = $row["cemail"];
                    $password = $row["password"];
                    $gender = $row["gender"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 text-center">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" autocomplete="off" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                            <span class="invalid-feedback"><?php echo $fname_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" autocomplete="off" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                            <span class="invalid-feedback"><?php echo $lname_err;?></span>
                        </div>


                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" autocomplete="off" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Confirm Email</label>
                            <input type="text" autocomplete="off" name="cemail" class="form-control <?php echo (!empty($cemail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cemail; ?>">
                            <span class="invalid-feedback"><?php echo $cemail_err;?></span>
                        </div>


                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" autocomplete="off" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
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

                        <div class ="text-center">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                       </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>