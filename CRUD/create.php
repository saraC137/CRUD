<!DOCTYPE HTML>
<html>
<head>
    <title>Create a Record</title>
      
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
      
    <?php
if($_POST){
 
    // include database connection
    include 'config/database.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO student SET first_name=:first_name, last_name=:last_name, email=:email, password=:password";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        $fisrt_name=htmlspecialchars(strip_tags($_POST['first_name']));
        $last_name=htmlspecialchars(strip_tags($_POST['last_name']));
        $email=htmlspecialchars(strip_tags($_POST['email']));
		$password=htmlspecialchars(strip_tags($_POST['password']));
 
        // bind the parameters
        $stmt->bindParam(':first_name', $fisrt_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
         
        // specify when this record was inserted to the database
        //$created=date('Y-m-d H:i:s');
        //$stmt->bindParam(':created', $created);
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
         
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>First Name</td>
            <td><input type='text' name='first_name' class='form-control' /></td>
        </tr>
        <tr>
		<tr>
            <td>Last Name</td>
            <td><input type='text' name='last_name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><textarea name='email' class='form-control'></textarea></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='text' name='password' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='page.php' class='btn btn-danger'>Back to read students</a>
            </td>
        </tr>
    </table>
</form>
          
    </div> <!-- end .container -->
      
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>