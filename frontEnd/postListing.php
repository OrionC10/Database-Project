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
<p><h2>Post Listing Form:</h2></p>
<form action="postListing.php" method=get>
    <!-- create car ID -->
	Enter Car Make: <input type=text size=20 name="make">
	<p>Enter Car Model: <input type=text size=5 name="model">
	<p>Enter Car Year: <input type=text size=5 name="year">
    <p>Enter Car Color: <input type=text size=5 name="color">
    <p>Enter Car Mileage: <input type=text size=5 name="mileage">
    <p>Enter Car Asking Price: <input type=text size=5 name="askingPrice">
    <p>Enter Car Description: <input type=text size=5 name="description">
    <!-- seller ID thing -->

	<p> <input type=submit value="submit">
                <input type="hidden" name="form_submitted" value="1" >
</form>


<?php //starting php code again!
$error_message = "This is a test error message from PHP";


if (!isset($_GET["form_submitted"]))
{
		echo "Hello. Please enter the car's information and submit the form.";
}
else {
  if (!empty($_GET["listingID"]) && !empty($_GET["make"]) && !empty($_GET["model"]) && !empty($_GET["year"]) && !empty($_GET["color"]) && !empty($_GET["mileage"]) && !empty($_GET["askingPrice"]) && !empty($_GET["description"]) && !empty($_GET["sellerID"]))
{
  $listingID = $_GET["listingID"];
  $carMake = $_GET["make"];
  $carModel = $_GET["model"];
  $carYear = $_GET["year"];
  $carColor = $_GET["color"];
  $carMileage = $_GET["mileage"];
  $carAskingPrice = $_GET["askingPrice"];
  $carDescription = $_GET["description"];
  //  $carSellerID = $_GET["sellerID"]; // ***may need to be changed
  // $carSellerID = session()->get("userID");
  $sqlstatement = $conn->prepare("INSERT INTO sleazCarListing (listingID, make, model, year, color, mileage, askingPrice, description, sellerID) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $sqlstatement->bind_param("issisiis",$listingID,$carMake,$carModel,$carYear,$carColor,$carMileage,$carAskingPrice,$carDescription); //insert the variables into the ? in the above statement // "sssssssss" may not be correct
  $sqlstatement->execute(); //execute the query
  echo $sqlstatement->error; //print an error if the query fails
  $sqlstatement->close();
 }
 else {
  echo "<b> Error: Please enter car information to proceed.</b>";
 }
  $conn->close();
 } //end else condition where form is submitted
  ?> <!-- this is the end of our php code -->
</body>
</html>
