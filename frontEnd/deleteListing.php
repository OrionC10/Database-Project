<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


include '../backEnd/config.inc'; // Change path if needed
// Create connection
 $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
 // Check connection
 if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
 }
 function displayListing() {
	 global $conn; //reference the global connection object (scope)
	 $sql = "SELECT listingID, make, model, year, color, mileage, askingPrice, description, sellerID FROM sleazCarListing";
         $result = $conn->query($sql);

	    if ($result->num_rows > 0) {
	       // Setup the table and headers
	       echo "<table class=\"center\"><tr><th>Listing ID</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Mileage</th><th>Asking Price</th><th>Description</th><th>Seller ID</th><th>Click To Remove</th></tr>";
	      // output data of each row into a table row
	      while($row = $result->fetch_assoc()) {
	          echo "<tr><td>".$row["listingID"]."</td><td>".$row["make"]."</td><td> ".$row["model"]."</td><td> ".$row["year"]."</td><td> ".$row["color"]."</td><td> ".$row["mileage"]."</td><td> ".$row["askingPrice"]."</td><td> ".$row["description"]."</td><td> ".$row["sellerID"]."</td><td><a href=\"deleteListing.php?form_submitted=1&id=".$row["listingID"]."\">Remove</a></td></tr>";
	          }
	     echo "</table>"; // close the table
	     echo "There are ". $result->num_rows . " results.";
	    // Don't render the table if no results found
	   } else {
	     echo "0 results";
		}
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Faculty</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		table, th, td { border: 1px solid black; }
		.center {  margin-left: auto;  margin-right: auto;}
    </style>
</head>
<body>
<h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Sleaze Bay.</h1>
    <p><nav class="nav justify-content-center">
    <a href="index.php" class="nav-item nav-link active">Home</a>
    <a href="listingTable.php" class="nav-item nav-link">View Listings</a>
    <a href="listing-search-prepared-links.php" class="nav-item nav-link">Search Listings</a>
    <a href="postListing.php" class="nav-item nav-link">Enter New Listing</a>
    <a href="deleteListing.php" class="nav-item nav-link" tabindex="-1">Delete Listing</a>
</nav>
<p><h2>Current Listings:</h2></p>
<?php
displayListing();
?>
<form action="deleteListing.php" method=get>
                <input type="hidden" name="form_submitted" >
                <input type="hidden" name="id" >
</form>


<?php //starting php code again!
if (isset($_GET["form_submitted"])){
  if (!empty($_GET["listingID"]) && !empty($_GET["form_submitted"]))
{
   $listingID = $_GET["listingID"]; //gets id from the form
   $sqlstatement = $conn->prepare("DELETE FROM sleazCarListing where listingID =?"); //prepare the statement
   $sqlstatement->bind_param("s",$listingID); //insert the variables into the ? in the above statement
   $sqlstatement->execute(); //execute the query
   echo $sqlstatement->error; //print an error if the query fails
   $sqlstatement->close();
 }
 else {
	 echo "<b> Error: Something went wrong with the form.</b>";
 }
header("Refresh:0;url=deleteListing.php");
}
   $conn->close();
  ?> <!-- this is the end of our php code -->
</body>
</html>
