<html>
<style>
table, th, td {
  border: 1px solid black;
}
<?php
include '../backEnd/config.inc'; //change file path for config.inc if needed
?>


</style
<body>
<p><h2>Car Listing Search:</h2></p>
<form action="listing-search-prepared-links.php" method=get>
	Enter Car Make: <input type=text size=20 name="make">
	<p>Enter Listing ID number: <input type=text size=5 name="listingID">
  <p>Enter Car Color: <input type=text size=5 name="color">
        <p> <input type=submit value="submit">
                <input type="hidden" name="form_submitted" value="1" >
</form>


<?php //starting php code again!
if (!isset($_GET["form_submitted"]))
{
		echo "Hello. Please enter a car make, listing ID number, or color and submit the form.";
}
else {
// Create connection

 $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
 // Check connection
 if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
 }
 if (!empty($_GET["make"]))
 {
   $listingMake = $_GET["name"]; //gets make from the form
   $sqlstatement = $conn->prepare("SELECT listingID, make, model, year, color, mileage, askingPrice, description, sellerID FROM sleazCarListing where make=?"); //prepare the statement
   $sqlstatement->bind_param("s",$listingMake); //insert the String variable into the ? in the above statement
   $sqlstatement->execute(); //execute the query
   $result = $sqlstatement->get_result(); //return the results
   $sqlstatement->close();
 }
 elseif (!empty($_GET["listingID"]))
 {
   $listingID = "%" . $_GET["id"] . "%";
   $sqlstatement = $conn->prepare("SELECT listingID, make, model, year, color, mileage, askingPrice, description, sellerID FROM sleazCarListing where listingID=?"); //prepare the statement
   $sqlstatement->bind_param("s",$listingID); //insert the variable into the ? in the above statement
   $sqlstatement->execute(); //execute the query
   $result = $sqlstatement->get_result(); //return the results
   $sqlstatement->close();
 }
 elseif (!empty($_GET["color"]))
 {
   $listingColor = $_GET["color"];
   $sqlstatement = $conn->prepare("SELECT listingID, make, model, year, color, mileage, askingPrice, description, sellerID FROM sleazCarListing where color=?"); //prepare the statement
   $sqlstatement->bind_param("s",$listingColor); //insert the variable into the ? in the above statement
   $sqlstatement->execute(); //execute the query
   $result = $sqlstatement->get_result(); //return the results
   $sqlstatement->close();
 }
 else {
	 echo "<b>Please enter a make, a listing ID number, or a color</b>";
 }
 if ($result->num_rows > 0) {
  // Setup the table and headers
    echo "<table><tr><th>ID</th><th>Name</th><th>Department</th><th>Schedule</th></tr>";
    // output data of each row into a table row
    while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>".$row["listingID"]."</td>
            <td>".$row["make"]."</td>
            <td>".$row["model"]."</td>
            <td>".$row["year"]."</td>
            <td>".$row["color"]."</td>
            <td>".$row["mileage"]."</td>
            <td>".$row["askingPrice"]."</td>
            <td>".$row["description"]."</td>
            <td>".$row["sellerID"]."</td>
          </tr>";
    }
    echo "</table>"; // close the table
    echo "There are ". $result->num_rows . " results.";
	// Don't render the table if no results found
   	} else {
               echo "$name not found. 0 results";
    }
   $conn->close();
   } //end else condition where form is submitted
  ?> <!-- this is the end of our php code -->
<p> Thanks for using the listing search! 
</body>
</html>
