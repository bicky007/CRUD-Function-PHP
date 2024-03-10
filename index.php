<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Employees Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM clients";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">
                                    <thead>';
                                    echo "<tr>";
                                    echo "<th>#</th>" .
                                         "<th>First Name</th>" .
                                         "<th>Last Name</th>" .
                                         "<th>Email</th>" .
                                         "<th>Confirm Email</th>" .
                                         "<th>Password</th>" .
                                         "<th>Gender</th>" .
                                         "<th colspan='3' class='text-center'>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>".
                                             "<td>" . $row['fname'] . "</td>".
                                             "<td>" . $row['lname'] . "</td>".
                                             "<td>" . $row['email'] . "</td>".
                                             "<td>" . $row['cemail'] . "</td>".
                                             "<td>" . str_repeat("*", strlen($row["password"])) . "</td>".
                                             "<td>" . ucwords($row["gender"]) . "</td>";
                                        echo "<td class='text-center'>";
                                            //echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<button class="btn btn-primary " title="View Record" data-toggle="tooltip" onclick="window.location.href=\'read.php?id='. $row['id'] .'\'"> View </button>';
                                            echo "</td>";
                                            echo "<td class='text-center'>";
                                            //echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<button class="btn btn-warning " title="Update Record" data-toggle="tooltip" onclick="window.location.href=\'update.php?id='. $row['id'] .'\'">Update</button>';
                                            echo "</td>";
                                            echo "<td class='text-center'>";
                                            //echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo '<button class="btn btn-danger " title="Delete Record" data-toggle="tooltip" onclick="window.location.href=\'delete.php?id='. $row['id'] .'\'">Delete</button>'; 
                                            echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>