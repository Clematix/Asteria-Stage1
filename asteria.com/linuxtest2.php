<?php
	$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "linuxtest2";



$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    echo "Database Connected Successfully<br><br>";
}


$sql = "SELECT id, firstname, lastname FROM myguests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "Welcome ".  $row["firstname"]. " " . $row["lastname"]. "!!";
    }
} 
else {
    echo "0 results";
}
?>

