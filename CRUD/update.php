<!DOCTYPE HTML>
<html>
<head>
    <title>Update a Record</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
</head>
<body>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
     
        <?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
 
//include database connection
include 'config/database.php';
 
// read current record's data
try {
    // prepare select query
	$query = "SELECT id, first_name, last_name, email, password FROM student WHERE id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
     
    // this is the first question mark
    $stmt->bindParam(1, $id);
     
    // execute our query
    $stmt->execute();
     
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    // values to fill up our form
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
	$password = $row['password'];
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>
 
       <?php
 
// check if form was submitted
if($_POST){
     
    try{
     
        // write update query
        // in this case, it seemed like we have so many fields to pass and 
        // it is better to label them and not use question marks
        $query = "UPDATE student 
                    SET first_name=:first_name, last_name=:last_name, email=:email, password=:password
                    WHERE id =:id";
 
        // prepare query for excecution
        $stmt = $con->prepare($query);
 
        // posted values
        $first_name=htmlspecialchars(strip_tags($_POST['first_name']));
        $last_name=htmlspecialchars(strip_tags($_POST['last_name']));
        $email=htmlspecialchars(strip_tags($_POST['email']));
		$password=htmlspecialchars(strip_tags($_POST['password']));
 
        // bind the parameters
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':id', $id);
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was updated.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
        }
         
    }
     
    // show errors
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!--we have our html form here where new record information can be updated-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>First Name</td>
            <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
			<td>Last Name</td>
            <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><textarea name='email' class='form-control'><?php echo htmlspecialchars($email, ENT_QUOTES);  ?></textarea></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='text' name='password' value="<?php echo htmlspecialchars($password, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
                <a href='page.php' class='btn btn-danger'>Back to read student</a>
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