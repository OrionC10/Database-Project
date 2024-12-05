<!DOCTYPE html>
<style>

table, th, td {
  border: 1px solid black;
}
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include '../backEnd/config.inc'; //change file path for config.inc if needed

// Create connection
 $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
 // Check connection
 if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
 }
?>


</style
<body>
<p><h2>Post Listing Form :</h2></p>
<form action="postListing.php" method=get>
    <!-- create car ID -->
	  <p>Enter Car Make: <input type="text" size=20 name="make">
	  <p>Enter Car Model: <input type="text" size=5 name="model">
	  <p>Enter Car Year: <input type="number" size=5 name="year">
    <p>Enter Car Color: <input type="text" size=5 name="color">
    <p>Enter Car Mileage: <input type="number" size=5 name="mileage">
    <p>Enter Car Asking Price: <input type="number" size=5 name="askingPrice">
    <p>Enter Car Description: <input type="text" size=300 name="description">
    <!-- seller ID thing -->

	<p> <input type=submit value="submit">
                <input type="hidden" name="form_submitted" value="1" >



<?php //starting php code again!

if (!isset($_GET["form_submitted"]))
{
		echo "Hello. Please enter the car's information and submit the form.";
}
else {
  if (!empty($_GET["make"]) && !empty($_GET["model"]) && !empty($_GET["year"]) && !empty($_GET["color"]) && !empty($_GET["mileage"]) && !empty($_GET["askingPrice"]) && !empty($_GET["description"]))
  {
    // $listingID = $_GET["listingID"];
    // echo "<b>  </b>";
    $carMake = $_GET["make"];
    $carModel = $_GET["model"];
    $carYear = $_GET["year"];
    $carColor = $_GET["color"];
    $carMileage = $_GET["mileage"];
    $carAskingPrice = $_GET["askingPrice"];
    $carDescription = $_GET["description"];
    //get user id
    $sellerID = 6;
    // $sellerID = $_SESSION["id"];
    echo "<b>session id is $sellerID</b>";
    // $sellerUsername = $_SESSION["username"]; //should grab the ID forom the current session
    // $sqlUserID = "SELECT userID FROM sleazUser WHERE username = $sellerUsername";
    // if($stmt = $conn->prepare($sqlUserID)){
    //   if($stmt->execute()){
    //     // Store result
    //     $stmt->store_result();
    //     $stmt->bind_result($sellerID);
    //     $stmt->fetch();
    //   } else {
    //     echo "<b>error getting user id</b>";
    //   }
    // }

    $sqlstatement = $conn->prepare("INSERT INTO sleazCarListing (make, model, year, color, mileage, askingPrice, description, sellerID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sqlstatement->bind_param("ssisiisi",$carMake,$carModel,$carYear,$carColor,$carMileage,$carAskingPrice,$carDescription,$sellerID); //insert the variables into the ? in the above statement // "sssssssss" may not be correct
    if($sqlstatement->execute()) { //execute the query
      echo "<b> Sucess </b>";
    } else {
      echo "<b> Error: form submition not working, ty again later </b>";
      echo "<b>values are, $carMake, $carModel, $carYear, $carColor, $carMileage, $carAskingPrice, $carDescription, $sellerID</b>";
    }
    // echo $sqlstatement->error; //print an error if the query fails
    $sqlstatement->close();
  } else {
    echo "<b> Error: Please enter car information to proceed.</b>";
  }
  $conn->close();
} //end else condition where form is submitted
?> 
</form>
</body>
</html>
